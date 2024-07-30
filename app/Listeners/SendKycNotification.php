<?php

namespace App\Listeners;

use App\Events\KycEvent;
use App\Notifications\KycNotification;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Notification;

class SendKycNotification
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle the event.
     */
    public function handle(KycEvent $event): void
    {
        $user = $this->userRepository->findUserById($event->kycApplication->user_id);
        Notification::sendNow($user, new KycNotification($event->kycApplication));
    }
}
