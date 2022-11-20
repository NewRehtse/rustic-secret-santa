<?php

declare(strict_types=1);

namespace Model;

interface ParticipantsRepository
{
    public function getParticipants(): Participants;
    public function getDetails(): string;
}
