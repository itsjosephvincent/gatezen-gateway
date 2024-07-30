<?php

namespace App\Repositories;

use App\Interface\Repositories\TickerRepositoryInterface;
use App\Models\Ticker;

class TickerRepository implements TickerRepositoryInterface
{
    public function findReesList($projectIds)
    {
        return Ticker::with(['currency'])
            ->whereIn('project_id', $projectIds)
            ->get();
    }

    public function findReesIdList($projectIds)
    {
        return Ticker::whereIn('project_id', $projectIds)
            ->pluck('id');
    }

    public function findTickerArray($payload)
    {
        return Ticker::with(['project'])
            ->whereIn('id', $payload['ticker'])
            ->get();
    }

    public function findProjectIdsArrayInArrayTickerIds($tickerIds)
    {
        return Ticker::whereIn('id', $tickerIds)->pluck('project_id');
    }

    public function findTickerById($tickerId)
    {
        return Ticker::findOrFail($tickerId);
    }

    public function findTickerByName(string $name)
    {
        return Ticker::where('ticker', $name)->first();
    }
}
