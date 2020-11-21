<?php

namespace Tests\Application;

use Application\Raffle;
use Model\Participants;
use Model\SantaAssociation;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \Application\Raffle
 */
class RaffleTest extends TestCase
{
    /**
     * @test
     */
    public function shouldFailWhenLessThan2Participants(): void
    {
        $this->expectException(\LogicException::class);

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

        new Raffle($participants);
    }

    /**
     * @test
     */
    public function shouldFailWhenDuplicatedEmails(): void
    {
        $this->expectException(\LogicException::class);

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
            [
                'name' => $name,
                'email' => $email,
                'address' => $address,
                'suggestion' => $suggestions,
            ],
        ];

        $participants = Participants::buildFromArray($participantsData);

        new Raffle($participants);
    }


    /**
     * @test
     */
    public function shouldMakeRaffle(): void
    {

        $participantsData = [
            [
                'name' => 'Juan',
                'email' => 'juan@gmail.com',
                'address' => '',
                'suggestion' => '',
            ],
            [
                'name' => 'Maria',
                'email' => 'maria@gmail.com',
                'address' => '',
                'suggestion' => '',
            ],
            [
                'name' => 'Jaimito',
                'email' => 'jaimito@gmail.com',
                'address' => '',
                'suggestion' => '',
            ],
        ];

        $participants = Participants::buildFromArray($participantsData);

        $raffle = new Raffle($participants);

        $associations = $raffle->getAssociations();

        static::assertContainsOnlyInstancesOf(SantaAssociation::class, $associations);

        $validFromNames = ['Juan', 'Maria', 'Jaimito'];
        $validToNames = ['Juan', 'Maria', 'Jaimito'];
        $nameExistFrom = [];
        foreach ($associations as $association) {
            $from = $association->from();
            $to = $association->to();
            $nameExistFrom[$from->name()] = \in_array($from->name(), $validFromNames, true);
            $nameExistTo[$to->name()] = \in_array($to->name(), $validToNames, true);
        }
        self::assertTrue($nameExistFrom['Juan']);
        self::assertTrue($nameExistFrom['Maria']);
        self::assertTrue($nameExistFrom['Jaimito']);

        self::assertTrue($nameExistTo['Juan']);
        self::assertTrue($nameExistTo['Maria']);
        self::assertTrue($nameExistTo['Jaimito']);
    }
}
