<?php

namespace App\Interface\Services;

use App\Models\Deal;
use App\Models\SalesOrder;

interface TransactionServiceInterface
{
    public function editSalesOrderIsPendingToFalse(SalesOrder $salesOrder);

    public function editDealIsPendingToFalse(Deal $deal);

    public function findTransactionByWalletId(int $walletId);

    public function downloadInvoiceByTransactionId(int $transactionId);
}
