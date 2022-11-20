<?php

declare(strict_types=1);

namespace Model;

interface NotificationRepository
{
    /**
     * @throws \Exception
     */
    public function notificateTo(string $to, string $subject, string $body): void;
}
