<?php

namespace App\Http\Controllers\Api\Gateway;

use App\Http\Controllers\Controller;
use App\Interface\Services\NotificationServiceInterface;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    private $notificationService;

    public function __construct(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(): JsonResponse
    {
        $user = auth()->user();

        return $this->notificationService->getAllNotifications($user->id)->response();
    }

    public function readNotification($notificationId): JsonResponse
    {
        return $this->notificationService->updateNotification($notificationId)->response();
    }

    public function totalUnreadNotification()
    {
        $user = auth()->user();

        return $this->notificationService->getUnreadNotificationCount($user->id);
    }
}
