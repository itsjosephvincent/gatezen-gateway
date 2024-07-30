<?php

namespace App\Interface\Repositories;

use App\Models\Deal;

interface DealEntryRepositoryInterface
{
    public function updateStatusToInvoiced(int $dealEntryId, int $invoiceId);

    public function updateDealEntryStatus($dealEntryId, $status);

    public function storeSyncDealEntry($payload, $deal);

    public function storeDealEntry(object $payload, Deal $deal);

    public function updateDealEntry(object $payload, $dealEntryId);

    public function getDealByUserIdDealIdDealableQuantity($userId, $dealId, $dealableQuantity);
}
