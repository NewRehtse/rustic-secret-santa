<?php


namespace Model;


/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class Email
{
    /** @var string */
    private $to;

    /** @var string */
    private $subject;

    /** @var string */
    private $body;

    public function __construct(string $to, string $subject, string $body)
    {
        if(false === filter_var($to, FILTER_VALIDATE_EMAIL)) {
            throw new \LogicException(sprintf('ERROR: email %s is not valid!!', $to));
        }

        $this->subject = $subject;
        $this->to = $to;
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function to(): string
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function subject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function body(): string
    {
        return $this->body;
    }
}