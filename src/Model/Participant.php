<?php

declare(strict_types=1);

namespace Model;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
final class Participant
{
    /** @var string */
    private $name;

    /** @var string */
    private $email;

    /** @var string */
    private $address;

    /** @var string */
    private $suggestions;

    /**
     * User constructor.
     * @param string $name
     * @param string $email
     * @param string $address
     * @param string $suggestions
     */
    public function __construct(string $name, string $email, string $address, string $suggestions)
    {
        if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \LogicException(sprintf('ERROR: email %s is not valid!!', $email));
        }

        $this->name = $name;
        $this->email = $email;
        $this->address = $address;
        $this->suggestions = $suggestions;
    }

    public static function buildFromArray(array $participantData): Participant
    {
        $name = $participantData['name'] ?? '';
        $email = $participantData['email'] ?? '';
        $address = $participantData['address'] ?? '';
        $suggestion = $participantData['suggestion'] ?? '';

        return new self($name, $email, $address, $suggestion);
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        //TODO Refactor name this can be a phone number in a future
        return $this->email;
    }

    /**
     * @return string
     */
    public function address(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function suggestions(): string
    {
        return $this->suggestions;
    }
}
