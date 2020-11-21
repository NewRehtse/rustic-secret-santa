<?php

namespace Tests\Model;

use Model\Participant;
use Model\Participants;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \Model\Participants
 */
class ParticipantsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBuildValidParticipantsObject(): void
    {
        $name = 'Maria';
        $email = 'maria@gmail.com';
        $address = 'C\Madrid,1. Madrid';
        $suggestions = 'Una bombilla';

        $participantsData = [
            [
                'name' => $name,
                'email' => $email,
                'address' => $address,
                'suggestion' => $suggestions,
            ],
        ];

        $participants = Participants::buildFromArray($participantsData);

        static::assertContainsOnlyInstancesOf(Participant::class, $participants->participants());
    }
}
