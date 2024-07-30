<?php

namespace App\Interface\Repositories;

interface NotificationRepositoryInterface
{
    public function findManyByUserId(int $userId);

    public function update(int $notificationId);

    public function findAllCount(int $userId);

    public function showNotification(string $title, string $body, string $color);
}
