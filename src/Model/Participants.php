<?php

declare(strict_types=1);

namespace Model;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
final class Participants
{
    /** @var Participant[] */
    private $participants = [];

    public function __construct(array $participants)
    {
        $this->participants = $participants;
    }

    public static function buildFromArray(array $participantsData): Participants
    {
        $participants = [];

        foreach ($participantsData as $participantData) {
            $participants[] = Participant::buildFromArray($participantData);
        }

        return new self($participants);
    }

    /**
     * @return Participant[]
     */
    public function participants(): array
    {
        return $this->participants;
    }
}
