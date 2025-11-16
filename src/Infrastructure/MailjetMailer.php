<?php

declare(strict_types=1);

namespace Infrastructure;

use Model\NotificationRepository;
use Mailjet\Client;
use Mailjet\Resources;

class MailjetMailer implements NotificationRepository
{
    private Client $mailer;

    public function __construct(
        string $apiKey,
        string $apiSecret,
        private readonly string $fromEmail,
    ) {
        $this->mailer = new Client($apiKey, $apiSecret,true,['version' => 'v3.1']);
    }

    /**
     * @throws \Exception
     */
    public function notificateTo(string $to, string $subject, string $body): void
    {
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $this->fromEmail,
                        'Name' => "Me"
                    ],
                    'To' => [
                        [
                            'Email' => $to,
                            'Name' => $to
                        ]
                    ],
                    'Subject' => $subject,
                    'TextPart' => 'Rustic Secret Santa by NewRehtse',
                    'HTMLPart' => $body,
                ]
            ]
        ];

        echo "Sending email to: " . $to;
        $response = $this->mailer->post(Resources::$Email, ['body' => $body]);
        //TODO save this echos into log
        if ($response->getStatus() !== 200) {
            throw new \Exception("ERROR: There has been an error with: " . $to . " " . $response->getStatus(). " " . print_r($response->getBody(), true));

        }

        //$response->success() && var_dump($response->getData());
        echo "OK: Notification to: " . $to;
    }
}
