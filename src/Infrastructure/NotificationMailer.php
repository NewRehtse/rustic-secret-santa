<?php

declare(strict_types=1);

namespace Infrastructure;

use Model\NotificationRepository;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class NotificationMailer implements NotificationRepository
{
    private PHPMailer $mailer;

    private const ENCRYPTION = 'ssl'; // Igual que tu clase anterior

    public function __construct(
        string $smtpServer,
        string $smtpPort,
        string $smtpUser,
        string $smtpPassword,
    ) {
        $this->mailer = new PHPMailer(true);

        // Configuración SMTP
        $this->mailer->isSMTP();
        $this->mailer->Host       = $smtpServer;
        $this->mailer->Port       = (int)$smtpPort;
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = $smtpUser;
        $this->mailer->Password   = $smtpPassword;
        $this->mailer->SMTPSecure = self::ENCRYPTION; // 'ssl' o 'tls' según necesites

        // Por defecto usaremos HTML
        $this->mailer->isHTML(true);
    }

    /**
     * @throws \Exception
     */
    public function notificateTo(string $to, string $subject, string $body): void
    {
        try {
            // Reset de destinatarios (PHPMailer mantiene estado entre envíos)
            $this->mailer->clearAddresses();
            $this->mailer->clearAttachments();

            // Remitente → con SwiftMailer usabas el mismo $to (no muy correcto),
            // lo mantengo por compatibilidad, pero lo normal es usar un from real.
            $this->mailer->setFrom('no-reply@example.com', 'Secret Santa');
            $this->mailer->addAddress($to);

            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $body;

            echo "Sending email to: " . $to;

            if (!$this->mailer->send()) {
                throw new \Exception(
                    "ERROR sending mail to $to: " . $this->mailer->ErrorInfo
                );
            }

            echo "OK: Notification to: " . $to;
        } catch (Exception $e) {
            throw new \Exception("PHPMailer ERROR: " . $e->getMessage());
        }
    }
}

