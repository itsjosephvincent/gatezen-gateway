<?php

namespace App\Interface\Services;

interface NotificationServiceInterface
{
    public function getAllNotifications(int $userId);

    public function updateNotification(int $notificationId);

    public function getUnreadNotificationCount(int $userId);
}
