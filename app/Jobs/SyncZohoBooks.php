<?php

namespace App\Jobs;

use App\Repositories\ZohoRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncZohoBooks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $zohoRepository;

    public function __construct()
    {
        $this->zohoRepository = new ZohoRepository;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->zohoRepository->syncInvoices();
    }
}
