<?php

namespace App\Jobs;

use App\Repositories\ProjectSyncRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncTgiBankTransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $projectSyncRepository;

    private $project;

    private $queryType;

    public function __construct($project, $queryType)
    {
        $this->projectSyncRepository = new ProjectSyncRepository;
        $this->project = $project;
        $this->queryType = $queryType;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->projectSyncRepository->syncTgiBankTransactions($this->project, $this->queryType);
    }
}
