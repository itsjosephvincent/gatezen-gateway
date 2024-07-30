<?php

namespace App\Repositories;

use App\Interface\Repositories\NotificationRepositoryInterface;
use App\Models\Notification;
use Carbon\Carbon;
use Filament\Notifications\Notification as FilamentNotification;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function findManyByUserId($userId)
    {
        return Notification::where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', $userId)
            ->paginate(config('services.paginate.default'));
    }

    public function update($notificationId)
    {
        $notification = Notification::findOrFail($notificationId);
        $notification->read_at = Carbon::now();
        $notification->save();

        return $notification->fresh();
    }

    public function findAllCount($userId)
    {
        return Notification::where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', $userId)
            ->whereNull('read_at')
            ->get()
            ->count();
    }

    public function showNotification($title, $body, $color)
    {
        return FilamentNotification::make()
            ->title($title)
            ->body($body)
            ->color($color)
            ->send();
    }
}
