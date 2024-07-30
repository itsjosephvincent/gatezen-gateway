<?php

namespace App\Events;

use App\Models\KycApplication;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KycEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $kycApplication;

    public function __construct(KycApplication $kycApplication)
    {
        $this->kycApplication = $kycApplication;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('KYC Application '.$this->kycApplication->id);
    }
}
