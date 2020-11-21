<?php


namespace Application;


use Model\Email;
use Model\SantaAssociation;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class EmailGenerator
{
    private const SUBJECT = 'This is your Secret Santa';
    private const DETAILS_TEMPLATE_REPLACE = '<!--DETAILS-->';
    private const FROM_TEMPLATE_REPLACE = '<!--FROM-->';
    private const NAME_TEMPLATE_REPLACE = '<!--NAME-->';
    private const ADDRESS_TEMPLATE_REPLACE = '<!--ADDRESS-->';
    private const SUGGESTION_TEMPLATE_REPLACE = '<!--SUGGESTION-->';

    private $template;

    /**
     * EmailSender constructor.
     *
     * @param string $template
     */
    public function __construct(string $template)
    {
        $this->template = $template;

    }

    /**
     * @param string $details
     */
    public function setDetails(string $details): void
    {
        $this->template = str_replace(static::DETAILS_TEMPLATE_REPLACE, $details, $this->template);
    }

    /**
     * @param SantaAssociation[] $associations
     *
     * @return Email[]
     */
    public function getEmails(array $associations): array
    {
        $emails = [];

        foreach ($associations as $association) {
            $emails[] = $this->getEmail($association);
        }

        return $emails;
    }

    /**
     * @param SantaAssociation $association
     * @return Email
     */
    private function getEmail(SantaAssociation $association): Email
    {
        $from = $association->from();
        $to = $association->to();

        $toEmail = $from->email();
        $nameTo = $to->name();
        $nameFrom = $from->name();
        $addressTo = $to->address();
        $suggestionTo = $to->suggestions();

        $message = $this->generateEmail($nameFrom, $nameTo, $addressTo, $suggestionTo);

        return new Email($toEmail, static::SUBJECT, $message);
    }

    /**
     * @param string $fromName
     * @param string $toName
     *
     * @param string $address
     * @param string $suggestion
     * @return string
     */
    private function generateEmail(string $fromName, string $toName, string $address, string $suggestion): string
    {
        $templateMessage = $this->template;

        return str_replace(
            [static::FROM_TEMPLATE_REPLACE, static::NAME_TEMPLATE_REPLACE, static::ADDRESS_TEMPLATE_REPLACE, static::SUGGESTION_TEMPLATE_REPLACE],
            [$fromName, $toName, $address, $suggestion],
            $templateMessage
        );
    }
}