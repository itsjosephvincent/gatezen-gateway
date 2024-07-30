<?php

namespace App\Services;

use App\Http\Resources\DealResource;
use App\Interface\Repositories\DealRepositoryInterface;
use App\Interface\Services\DealServiceInterface;

class DealService implements DealServiceInterface
{
    private $dealRepository;

    public function __construct(
        DealRepositoryInterface $dealRepository,
    ) {
        $this->dealRepository = $dealRepository;
    }

    public function getAllUserDealsByUserId($userId)
    {
        $deal = $this->dealRepository->findAllDealsByUserId($userId);

        return DealResource::collection($deal);
    }
}
