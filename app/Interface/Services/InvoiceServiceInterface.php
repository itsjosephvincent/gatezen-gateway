<?php

namespace App\Interface\Services;

use App\Models\Deal;
use App\Models\DealEntry;
use App\Models\SalesOrder;
use App\Models\User;

interface InvoiceServiceInterface
{
    public function createSalesOrderInvoice(SalesOrder $salesOrder, User $user);

    public function createDealInvoice(Deal $deal);

    public function createDealInvoiceForSingleEntry(DealEntry $dealEntry);

    public function getReesInvoice(User $user);

    public function getInvoiceByUserId(int $userId);
}
