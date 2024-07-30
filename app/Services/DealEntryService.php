<?php

namespace App\Services;

use App\Http\Resources\DealEntryResource;
use App\Interface\Repositories\DealEntryRepositoryInterface;
use App\Interface\Services\DealEntryServiceInterface;
use App\Models\Deal;

class DealEntryService implements DealEntryServiceInterface
{
    private $dealEntryRepository;

    public function __construct(
        DealEntryRepositoryInterface $dealEntryRepository,
    ) {
        $this->dealEntryRepository = $dealEntryRepository;
    }

    public function createDealEntry(object $payload, Deal $deal)
    {
        $entry = $this->dealEntryRepository->storeDealEntry($payload, $deal);

        return new DealEntryResource($entry);
    }
}
