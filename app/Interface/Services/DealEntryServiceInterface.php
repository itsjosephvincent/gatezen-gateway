<?php

namespace App\Interface\Services;

use App\Models\Deal;

interface DealEntryServiceInterface
{
    public function createDealEntry(object $payload, Deal $deal);
}
