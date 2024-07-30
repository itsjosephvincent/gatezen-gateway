<?php

namespace App\Notifications;

use App\Models\KycApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class KycNotification extends Notification
{
    use Queueable;

    private $kycApplication;

    public function __construct(KycApplication $kycApplication)
    {
        $this->kycApplication = $kycApplication;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'kyc' => $this->kycApplication,
        ];
    }
}
