<?php

declare(strict_types=1);

namespace Tests\Application;

use Application\NotificationGenerator;
use Model\Participant;
use Model\SantaAssociation;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \Application\NotificationGenerator
 */
class EmailGeneratorTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBuildValidEmailObjectWithEmailGenerator(): void
    {
        $template = 'Template <!--FROM--> to <!--NAME--> with <!--DETAILS--> with <!--ADDRESS--> and <!--SUGGESTION-->.';
        $details = 'Estos son los detalles del email';
        $expectedMessage = 'Template Maria to Juan with Estos son los detalles del email with direccion and ideas.';

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
            'address' => 'direccion',
            'suggestion' => 'ideas',
        ];

        $participantTo = Participant::buildFromArray($toData);

        $association = new SantaAssociation($participantFrom, $participantTo);

        $associations = [$association];

        $generator = new NotificationGenerator($template);
        $generator->setDetails($details);
        $emails = $generator->getNotifications($associations);

        static::assertCount(1, $emails);
        $email = $emails[0];
        static::assertSame($expectedMessage, $email->body());
        static::assertSame('maria@gmail.com', $email->to());
        static::assertSame('This is your Secret Santa', $email->subject());
    }
}
