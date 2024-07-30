<?php

namespace App\Repositories;

use App\Enum\Status;
use App\Interface\Repositories\DealRepositoryInterface;
use App\Models\Deal;
use App\Models\Ticker;

class DealRepository implements DealRepositoryInterface
{
    public function updateDealStatusToOngoing($dealId)
    {
        $deal = Deal::findOrFail($dealId);
        $deal->status = Status::Ongoing->value;
        $deal->save();

        return $deal->fresh();
    }

    public function findAllDealsByUserId($userId)
    {
        return Deal::with(['deal_entries' => function ($query) use ($userId): void {
            $query->where('user_id', $userId);
        }])
            ->get();
    }

    public function findDealByName(string $name)
    {
        return Deal::where('name', $name)->first();
    }

    public function create(object $payload, Ticker $ticker)
    {
        $deal = new Deal();
        $deal->name = $payload->name;
        $deal->dealable_type = get_class($ticker);
        $deal->dealable_id = $ticker->id;
        $deal->start_date = $payload->date;
        $deal->save();

        return $deal->fresh();
    }

    public function findDealById(int $dealId)
    {
        return Deal::findOrFail($dealId);
    }
}
