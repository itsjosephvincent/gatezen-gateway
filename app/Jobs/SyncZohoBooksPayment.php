<?php

namespace App\Jobs;

use App\Repositories\ZohoRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncZohoBooksPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $zohoRepository;

    private $invoices;

    public function __construct($invoices)
    {
        $this->zohoRepository = new ZohoRepository;
        $this->invoices = $invoices;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->zohoRepository->syncBulkZohoPayment($this->invoices);
    }
}
