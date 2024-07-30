<?php

namespace App\Services;

use App\Http\Resources\TickerResource;
use App\Interface\Repositories\ProjectRepositoryInterface;
use App\Interface\Repositories\TickerRepositoryInterface;
use App\Interface\Services\TickerServiceInterface;

class TickerService implements TickerServiceInterface
{
    private $projectRepository;

    private $tickerRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository, TickerRepositoryInterface $tickerRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->tickerRepository = $tickerRepository;
    }

    public function getReesTickers()
    {
        $projectIds = $this->projectRepository->findReesProjectIds();
        $tickers = $this->tickerRepository->findReesList($projectIds);

        return TickerResource::collection($tickers);
    }
}
