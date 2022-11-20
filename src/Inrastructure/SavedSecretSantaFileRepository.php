<?php

declare(strict_types=1);

namespace Inrastructure;

use Model\Notification;

class SavedSecretSantaFileRepository
{
    private const ENCRYPTION_CIPHERING = "AES-128-CTR";
    private const ENCRYPTION_OPTIONS = 0;
    private const ENCRYPTION_KEY = 'rustic-santa';

    public function __construct(private readonly string $filePath)
    {
    }

    /**
     * @param Notification[] $notifications
     * @throws \Exception
     */
    public function saveNotifications(array $notifications): void
    {
        $notificationsSerializedArray = array_map(
            static function (Notification $notification) {
                return $notification->serialize();
            },
            $notifications
        );

        $json = json_encode($notificationsSerializedArray, JSON_THROW_ON_ERROR);

        $encodedNotifications = openssl_encrypt(
            $json,
            self::ENCRYPTION_CIPHERING,
            self::ENCRYPTION_KEY,
            self::ENCRYPTION_OPTIONS
        );

        file_put_contents($this->filePath, $encodedNotifications);
    }

    /**
     * @return Notification[]
     * @throws \Exception
     */
    public function getNotifications(): array
    {
        $encodedNotifications = file_get_contents($this->filePath);
        if (false === $encodedNotifications) {
            throw new \Exception("ERROR: Template not found");
        }
        return $this->decodeNotifications($encodedNotifications);
    }

    /**
     * @return Notification[]
     * @throws \Exception
     */
    private function decodeNotifications(string $encodedNotifications): array
    {
        $notificationsJson = openssl_decrypt(
            $encodedNotifications,
            self::ENCRYPTION_CIPHERING,
            self::ENCRYPTION_KEY,
            self::ENCRYPTION_OPTIONS
        );

        $notificatoinsArray = json_decode($notificationsJson, true, 512, JSON_THROW_ON_ERROR);

        $notifications = [];
        foreach ($notificatoinsArray as $notificationArray) {
            $notifications[] = Notification::buildFromArray($notificationArray);
        }

        return $notifications;
    }
}
