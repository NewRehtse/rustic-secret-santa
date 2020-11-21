<?php

namespace Tests\Model;

use Model\Participant;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \Model\Participant
 */
class ParticipantTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBuildValidParticipant(): void
    {
        $name = 'Maria';
        $email = 'maria@gmail.com';
        $address = 'C\Madrid,1. Madrid';
        $suggestions = 'Una bombilla';

        $partipantData = [
            'name' => $name,
            'email' => $email,
            'address' => $address,
            'suggestion' => $suggestions,
        ];

        $participant = Participant::buildFromArray($partipantData);

        static::assertSame($name, $participant->name());
        static::assertSame($email, $participant->email());
        static::assertSame($address, $participant->address());
        static::assertSame($suggestions, $participant->suggestions());
    }

    /**
     * @test
     */
    public function shouldFailWhenWrongEmail(): void
    {
        $this->expectException(\LogicException::class);

        $name = 'Maria';
        $email = 'maria';
        $address = 'C\Madrid,1. Madrid';
        $suggestions = 'Una bombilla';

        new Participant($name, $email, $address, $suggestions);
    }
}
