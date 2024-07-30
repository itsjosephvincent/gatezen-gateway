<?php

namespace App\Interface\Repositories;

use App\Models\Ticker;

interface DealRepositoryInterface
{
    public function updateDealStatusToOngoing(int $dealId);

    public function findAllDealsByUserId(int $userId);

    public function findDealByName(string $name);

    public function create(object $payload, Ticker $ticker);

    public function findDealById(int $dealId);
}
