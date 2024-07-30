<?php

namespace App\Interface\Repositories;

use App\Models\DealEntry;
use App\Models\SalesOrderProduct;
use App\Models\Sync;
use App\Models\Transaction;
use App\Models\Wallet;

interface TransactionRepositoryInterface
{
    public function storeWalletTransaction(Wallet $wallet, $shares, $transaction_type, $description = null, $transaction_date = null);

    public function storeSyncTransaction(Sync $sync, Wallet $wallet, $shares, $transaction_type, $description = null, $transaction_date = null);

    public function storeSalesOrderProductTransaction(SalesOrderProduct $salesOrderProduct, Wallet $wallet, $shares, $transaction_type, $description = null, $transaction_date = null);

    public function storeDealEntryTransaction(DealEntry $dealEntry, Wallet $wallet, $shares, $transaction_type, $description = null, $transaction_date = null);

    public function storeZohoBooksTransaction($status, DealEntry $dealEntry, Wallet $wallet, $shares, $transaction_type, $description = null, $transaction_date = null);

    public function updateSalesOrderProductIsPendingToFalse(SalesOrderProduct $salesOrderProduct);

    public function setTransactionToPending(Transaction $transaction);

    public function setTransactionToApproved(Transaction $transaction);

    public function updateDealIsPendingToFalse(DealEntry $dealEntry);

    public function findTransactionByPayableAndWalletId(DealEntry $dealEntry, $walletId);

    public function findSumOfTransactionApprovedBalanceByWalletId($walletId);

    public function showByWalletId(int $walletId);

    public function findTransactionById(int $transactionId);

    public function updateTransactionCreatedAt($transactionDate, int $transactionId);
}
