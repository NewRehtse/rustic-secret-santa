<?php

declare(strict_types=1);

namespace Inrastructure;

use Model\Participants;
use Model\ParticipantsRepository;

//TODO esto no tiene sentido que se llame particpants, y el fichero json tampoco
class ParticipantsFileRepository implements ParticipantsRepository
{
    public function __construct(private readonly string $filePath)
    {
    }

    /**
     * @throws \Exception
     */
    public function getParticipants(): Participants
    {
        $data = $this->getFileData();
        $participansData = $data['participants'] ?? [];

        return Participants::buildFromArray($participansData);
    }

    /**
     * @throws \Exception
     */
    public function getDetails(): string
    {
        $data = $this->getFileData();
        return $data['details'] ?? '';
    }

    /**
     * @return array<string, mixed>
     *
     * @throws \Exception
     */
    private function getFileData(): array
    {
        $json = file_get_contents($this->filePath);

        if (false === $json) {
            throw new \Exception("ERROR: File does not exists");
        }

        $data = json_decode($json, true);

        if (null === $data) {
            throw new \Exception("ERROR: File does not contains valid json");
        }

        return $data;
    }
}
