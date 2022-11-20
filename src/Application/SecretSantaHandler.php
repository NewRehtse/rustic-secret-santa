<?php

declare(strict_types=1);

namespace Application;

use Inrastructure\SavedSecretSantaFileRepository;
use Model\NotificationRepository;
use Model\ParticipantsRepository;

class SecretSantaHandler
{
    public function __construct(
        private readonly ParticipantsRepository         $participantsRepository,
        private readonly NotificationRepository         $notificationRepository,
        private readonly NotificationGenerator          $notificationGenerator,
        private readonly SavedSecretSantaFileRepository $savedSecretSantaRepository,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function secretSanta(): void
    {
        $participants = $this->participantsRepository->getParticipants();
        $details = $this->participantsRepository->getDetails();

        try {
            $santa = new Raffle($participants);
            $associations = $santa->getAssociations();
        } catch (\Exception $e) {
            echo $e->getMessage();
            return;
        }

        $this->notificationGenerator->setDetails($details);
        $notifications = $this->notificationGenerator->getNotifications($associations);
        $this->savedSecretSantaRepository->saveNotifications($notifications);

        foreach ($notifications as $notification) {
            $this->notificationRepository->notificateTo($notification->to(), $notification->subject(), $notification->body());
        }
    }

    /**
     * @throws \Exception
     */
    public function cachedSecretSanta(): void
    {
        $notifications = $this->savedSecretSantaRepository->getNotifications();
        foreach ($notifications as $notification) {
            $this->notificationRepository->notificateTo($notification->to(), $notification->subject(), $notification->body());
        }
    }
}
