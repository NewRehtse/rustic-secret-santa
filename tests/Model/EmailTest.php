<?php

namespace Tests\Model;

use Model\Email;
use PHPUnit\Framework\TestCase;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 *
 * @covers \Model\Email
 */
class EmailTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBuildValidEmailObject(): void
    {
        $to = 'maria@gmail.com';
        $subject = 'Secret Santa';
        $body = 'Este es el cuerpo del email';

        $email = new Email($to, $subject, $body);

        static::assertSame($to, $email->to());
        static::assertSame($subject, $email->subject());
        static::assertSame($body, $email->body());
    }

    /**
     * @test
     */
    public function shouldFailWhenInvalidEmailAddress(): void
    {
        $this->expectException(\LogicException::class);

        $to = 'maria';
        $subject = 'Secret Santa';
        $body = 'Este es el cuerpo del email';

        new Email($to, $subject, $body);
    }
}
