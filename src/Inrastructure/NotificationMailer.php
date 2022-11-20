<?php

declare(strict_types=1);

namespace Inrastructure;

use Model\NotificationRepository;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class NotificationMailer implements NotificationRepository
{
    private Swift_Mailer $mailer;

    private const ENCRYPTION = 'ssl';

    public function __construct(
        string $smtpServer,
        string $smtpPort,
        string $smtpUser,
        string $smtpPassword,
    ) {
        $transport = new Swift_SmtpTransport($smtpServer, $smtpPort, self::ENCRYPTION);
        $transport->setUsername($smtpUser);
        $transport->setPassword($smtpPassword);

        $this->mailer = new Swift_Mailer($transport);
    }

    /**
     * @throws \Exception
     */
    public function notificateTo(string $to, string $subject, string $body): void
    {
        $message = new Swift_Message($subject, $body, 'text/html');
        $message->setTo($to);
        $message->setFrom($to);

        //TODO save this echos into log
        echo "Sending email to: " . $to;
        $result = $this->mailer->send($message);
        if ($result === 0) {
            throw new \Exception("ERROR: There has been an error with: " . $to);
        }
        echo "OK: Notification to: " . $to;
    }
}
