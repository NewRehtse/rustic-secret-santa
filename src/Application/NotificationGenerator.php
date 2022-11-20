<?php

declare(strict_types=1);

namespace Application;

use Model\Notification;
use Model\SantaAssociation;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class NotificationGenerator
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
     * @throws \Exception
     */
    public static function buildFromFile(string $filePath): self
    {
        $templateMessage = file_get_contents($filePath);
        if (false === $templateMessage) {
            throw new \Exception("ERROR: Template not found");
        }
        return new self($templateMessage);
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
     * @return Notification[]
     */
    public function getNotifications(array $associations): array
    {
        $notifications = [];

        foreach ($associations as $association) {
            $notifications[] = $this->getNotification($association);
        }

        return $notifications;
    }

    /**
     * @param SantaAssociation $association
     * @return Notification
     */
    private function getNotification(SantaAssociation $association): Notification
    {
        $from = $association->from();
        $to = $association->to();

        $toEmail = $from->email();
        $nameTo = $to->name();
        $nameFrom = $from->name();
        $addressTo = $to->address();
        $suggestionTo = $to->suggestions();

        $message = $this->generateNotification($nameFrom, $nameTo, $addressTo, $suggestionTo);

        return new Notification($toEmail, static::SUBJECT, $message);
    }

    /**
     * @param string $fromName
     * @param string $toName
     *
     * @param string $address
     * @param string $suggestion
     * @return string
     */
    private function generateNotification(string $fromName, string $toName, string $address, string $suggestion): string
    {
        $templateMessage = $this->template;

        return str_replace(
            [static::FROM_TEMPLATE_REPLACE, static::NAME_TEMPLATE_REPLACE, static::ADDRESS_TEMPLATE_REPLACE, static::SUGGESTION_TEMPLATE_REPLACE],
            [$fromName, $toName, $address, $suggestion],
            $templateMessage
        );
    }
}
