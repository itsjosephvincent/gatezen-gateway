<?php

namespace App\Services;

use App\Http\Resources\NullResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectWalletResource;
use App\Interface\Repositories\ProjectRepositoryInterface;
use App\Interface\Repositories\TickerRepositoryInterface;
use App\Interface\Repositories\WalletRepositoryInterface;
use App\Interface\Services\ProjectServiceInterface;
use App\Traits\SortingTraits;

class ProjectService implements ProjectServiceInterface
{
    use SortingTraits;

    private $projectRepository;

    private $walletRepository;

    private $tickerRepository;

    public function __construct(
        ProjectRepositoryInterface $projectRepository,
        WalletRepositoryInterface $walletRepository,
        TickerRepositoryInterface $tickerRepository
    ) {
        $this->projectRepository = $projectRepository;
        $this->walletRepository = $walletRepository;
        $this->tickerRepository = $tickerRepository;
    }

    public function getActiveProjects()
    {
        $projects = $this->projectRepository->findActiveProjects();

        return ProjectResource::collection($projects);
    }

    public function getProjectById($projectId)
    {
        $project = $this->projectRepository->findProjectById($projectId);

        return new ProjectResource($project);
    }

    public function getProjectsWithWalletByUserId($projectId, $user)
    {
        $project = $this->projectRepository->findProjectById($projectId);

        $wallets = [];
        foreach ($project->tickers as $ticker) {
            $data = $this->walletRepository->findWalletByHoldableAndBelongable($user, $ticker);
            if ($data) {
                $data['type'] = $ticker->type;
                $wallets[] = $data;
            }
        }

        if (! $wallets) {
            $data = [];

            return new NullResource($data);
        }

        $data = [];
        foreach ($wallets as $wallet) {
            $data[] = [
                'wallet_id' => $wallet->uuid,
                'class' => $wallet->type,
                'balance' => $wallet->balance,
                'pending_balance' => $wallet->pending_balance,
                'estimated_value' => $wallet->balance * $wallet->belongable->price,
            ];
        }

        return ProjectWalletResource::collection($data);
    }

    public function getProjectsByUserId($userId)
    {
        $walletTickerIds = $this->walletRepository->findTickerIdArrayByHoldableId($userId);
        $tickerProjectIds = $this->tickerRepository->findProjectIdsArrayInArrayTickerIds($walletTickerIds);
        $projects = $this->projectRepository->findProjectsByArrayTickerProjectIds($tickerProjectIds);

        return ProjectResource::collection($projects);
    }
}
