<?php

namespace App\Repositories;

use App\Interface\Repositories\DealEntryRepositoryInterface;
use App\Models\DealEntry;

class DealEntryRepository implements DealEntryRepositoryInterface
{
    public function updateStatusToInvoiced($dealEntryId, $invoiceId)
    {
        $entry = DealEntry::findOrFail($dealEntryId);
        $entry->invoice_id = $invoiceId;
        $entry->save();

        return $entry->fresh();
    }

    public function updateDealEntryStatus($dealEntryId, $status)
    {
        $entry = DealEntry::findOrFail($dealEntryId);
        $entry->status = $status;
        $entry->save();

        return $entry->fresh();
    }

    public function storeSyncDealEntry($payload, $deal)
    {
        $entry = new DealEntry();
        $entry->deal_id = $deal->id;
        $entry->user_id = $payload->user_id;
        $entry->status = $payload->status;
        $entry->dealable_quantity = $payload->dealable_quantity;
        $entry->billable_price = $payload->billable_price ?? null;
        $entry->billable_quantity = $payload->billable_quantity ?? null;
        $entry->notes = $payload->notes ?? null;
        $entry->save();

        return $entry->fresh();
    }

    public function storeDealEntry($payload, $deal)
    {
        $entry = new DealEntry();
        $entry->deal_id = $deal->id;
        $entry->user_id = $payload->user_id;
        $entry->status = $payload->status;
        $entry->dealable_quantity = $payload->dealable_quantity;
        $entry->billable_price = $payload->billable_price ?? null;
        $entry->billable_quantity = $payload->billable_quantity ?? null;
        $entry->notes = $payload->notes ?? null;
        $entry->save();

        return $entry->fresh();
    }

    public function updateDealEntry($payload, $dealEntryId)
    {
        $entry = DealEntry::findOrFail($dealEntryId);
        $entry->user_id = $payload->user_id;
        $entry->status = $payload->status;
        $entry->dealable_quantity = $payload->dealable_quantity;
        $entry->billable_price = $payload->billable_price;
        $entry->billable_quantity = $payload->billable_quantity;
        $entry->notes = $payload->notes;
        $entry->save();

        return $entry->fresh();
    }

    public function getDealByUserIdDealIdDealableQuantity($userId, $dealId, $dealableQuantity)
    {
        return DealEntry::where('user_id', $userId)
            ->where('deal_id', $dealId)
            ->where('dealable_quantity', $dealableQuantity)
            ->first();
    }
}
