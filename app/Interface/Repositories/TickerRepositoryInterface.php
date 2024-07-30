<?php

namespace App\Interface\Repositories;

interface TickerRepositoryInterface
{
    public function findReesList(array $projectIds);

    public function findReesIdList(array $projectIds);

    public function findTickerArray(array $payload);

    public function findProjectIdsArrayInArrayTickerIds(array $tickerIds);

    public function findTickerById(int $tickerId);

    public function findTickerByName(string $name);
}
