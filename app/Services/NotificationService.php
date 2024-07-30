<?php

namespace App\Services;

use App\Http\Resources\NotificationResource;
use App\Interface\Repositories\NotificationRepositoryInterface;
use App\Interface\Services\NotificationServiceInterface;

class NotificationService implements NotificationServiceInterface
{
    private $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function getAllNotifications($userId)
    {
        $notifications = $this->notificationRepository->findManyByUserId($userId);

        return NotificationResource::collection($notifications);
    }

    public function updateNotification($notificationId)
    {
        $notification = $this->notificationRepository->update($notificationId);

        return new NotificationResource($notification);
    }

    public function getUnreadNotificationCount($userId)
    {
        $notification = $this->notificationRepository->findAllCount($userId);

        return $notification;
    }
}
