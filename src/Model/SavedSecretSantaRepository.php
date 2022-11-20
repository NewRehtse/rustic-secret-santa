<?php

declare(strict_types=1);

namespace Model;

interface SavedSecretSantaRepository
{
    /**
     * @param Notification[] $notifications
     * @throws \Exception
     */
    public function saveNotifications(array $notifications): void;

    /**
     * @return Notification[]
     * @throws \Exception
     */
    public function getNotifications(): array;
}
