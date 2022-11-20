<?php

declare(strict_types=1);

namespace Application;

use Model\Participants;
use Model\SantaAssociation;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class Raffle
{
    private Participants $participants;

    /**
     * Santa constructor.
     *
     * @param Participants $participants
     */
    public function __construct(Participants $participants)
    {
        $this->assertUserListCorrect($participants);

        $this->participants = $participants;
    }


    /**
     * @return SantaAssociation[]
     */
    public function getAssociations(): array
    {
        $users = $this->participants->participants();

        $userCount = \count($users);
        $associations = [];

        $numbers = range(0, $userCount - 1);
        shuffle($numbers);

        for ($i = 1; $i < $userCount; ++$i) {
            $from = $users[$numbers[$i - 1]];
            $to = $users[$numbers[$i]];
            $associations[] = new SantaAssociation($from, $to);
        }

        $from = $users[$numbers[$i - 1]];
        $to = $users[$numbers[0]];
        $associations[] = new SantaAssociation($from, $to);

        return $associations;
    }

    /**
     * @param Participants $users
     */
    private function assertUserListCorrect(Participants $users): void
    {
        $filteredUsers = [];
        foreach ($users->participants() as $user) {
            $email = $user->email();
            if (false === \in_array($email, $filteredUsers, true)) {
                $filteredUsers[] = $email;
            }
        }


        if (\count($filteredUsers) !== \count($users->participants())) {
            throw new \LogicException(sprintf('ERROR: Duplicated emails'));
        }

        if (\count($filteredUsers) < 2) {
            throw new \LogicException(sprintf('Expected at least 2 users in the list, %s given.', \count($filteredUsers)));
        }
    }
}
