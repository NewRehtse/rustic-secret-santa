<?php

declare(strict_types=1);

namespace Model;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class Notification
{
    /** @var string */
    private $to;

    /** @var string */
    private $subject;

    /** @var string */
    private $body;

    public function __construct(string $to, string $subject, string $body)
    {
        if (false === filter_var($to, FILTER_VALIDATE_EMAIL)) {
            throw new \LogicException(sprintf('ERROR: email %s is not valid!!', $to));
        }

        $this->subject = $subject;
        $this->to = $to;
        $this->body = $body;
    }

    public static function buildFromArray(array $data): Notification
    {
        return new self(
            $data['to'],
            $data['subject'],
            $data['body'],
        );
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

    public function serialize(): array
    {
        return [
            'to' => $this->to,
            'subject' => $this->subject,
            'body' => $this->body,
        ];
    }
}
