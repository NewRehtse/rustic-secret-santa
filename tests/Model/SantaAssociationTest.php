<?php

namespace Tests\Model;

use Model\Participant;
use Model\SantaAssociation;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \Model\SantaAssociation
 */
class SantaAssociationTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBuildValidSantaAssociation(): void
    {
        $fromData = [
            'name' => 'Maria',
            'email' => 'maria@gmail.com',
            'address' => '',
            'suggestion' => '',
        ];

        $participantFrom = Participant::buildFromArray($fromData);

        $toData = [
            'name' => 'Juan',
            'email' => 'juan@gmail.com',
            'address' => '',
            'suggestion' => '',
        ];

        $participantTo = Participant::buildFromArray($toData);

        $association = new SantaAssociation($participantFrom, $participantTo);

        static::assertSame($participantFrom, $association->from());
        static::assertSame($participantTo, $association->to());
    }
}
