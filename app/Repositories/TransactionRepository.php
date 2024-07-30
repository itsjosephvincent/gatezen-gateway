<?php

namespace App\Repositories;

use App\Interface\Repositories\TransactionRepositoryInterface;
use App\Models\DealEntry;
use App\Models\SalesOrderProduct;
use App\Models\Sync;
use App\Models\Transaction;
use App\Models\Wallet;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function storeWalletTransaction(Wallet $wallet, $shares, $transaction_type, $description = null, $transaction_date = null)
    {
        $transaction = new Transaction();
        $transaction->payable_type = $wallet->belongable_type;
        $transaction->payable_id = $wallet->belongable_id;
        $transaction->wallet_id = $wallet->id;
        $transaction->amount = number_format($shares, 4, '.', '');
        $transaction->is_pending = false;
        $transaction->transaction_type = $transaction_type;
        $transaction->description = $description;
        $transaction->created_at = $transaction_date ?? now();
        $transaction->save();

        return $transaction->fresh();
    }

    public function storeSyncTransaction(Sync $sync, Wallet $wallet, $shares, $transaction_type, $description = null, $transaction_date = null)
    {
        $transaction = new Transaction();
        $transaction->payable_type = get_class($sync);
        $transaction->payable_id = $sync->id;
        $transaction->wallet_id = $wallet->id;
        $transaction->amount = number_format($shares, 4, '.', '');
        $transaction->is_pending = false;
        $transaction->transaction_type = $transaction_type;
        $transaction->description = $description;
        $transaction->created_at = $transaction_date ?? now();
        $transaction->save();

        return $transaction->fresh();
    }

    public function storeSalesOrderProductTransaction(SalesOrderProduct $salesOrderProduct, Wallet $wallet, $shares, $transaction_type, $description = null, $transaction_date = null)
    {
        $transaction = new Transaction();
        $transaction->payable_type = get_class($salesOrderProduct);
        $transaction->payable_id = $salesOrderProduct->id;
        $transaction->wallet_id = $wallet->id;
        $transaction->amount = number_format($shares, 4, '.', '');
        $transaction->transaction_type = $transaction_type;
        $transaction->description = $description;
        $transaction->created_at = $transaction_date ?? now();
        $transaction->save();

        return $transaction->fresh();
    }

    public function storeDealEntryTransaction(DealEntry $dealEntry, Wallet $wallet, $shares, $transaction_type, $description = null, $transaction_date = null)
    {
        $transaction = new Transaction();
        $transaction->payable_type = get_class($dealEntry);
        $transaction->payable_id = $dealEntry->id;
        $transaction->wallet_id = $wallet->id;
        $transaction->amount = number_format($shares, 4, '.', '');
        $transaction->transaction_type = $transaction_type;
        $transaction->description = $description;
        $transaction->created_at = $transaction_date ?? now();
        $transaction->save();

        return $transaction->fresh();
    }

    public function storeZohoBooksTransaction($status, DealEntry $dealEntry, Wallet $wallet, $shares, $transaction_type, $description = null, $transaction_date = null)
    {
        $transaction = new Transaction();
        $transaction->payable_type = get_class($dealEntry);
        $transaction->payable_id = $dealEntry->id;
        $transaction->wallet_id = $wallet->id;
        $transaction->amount = number_format($shares, 4, '.', '');
        $transaction->is_pending = $status;
        $transaction->transaction_type = $transaction_type;
        $transaction->description = $description;
        $transaction->created_at = $transaction_date ?? now();
        $transaction->save();

        return $transaction->fresh();
    }

    public function updateSalesOrderProductIsPendingToFalse($salesOrderProduct)
    {
        $transaction = Transaction::where('payable_type', get_class($salesOrderProduct))
            ->where('payable_id', $salesOrderProduct->id)
            ->where('is_pending', true)
            ->first();
        $transaction->is_pending = false;
        $transaction->save();

        return $transaction->fresh();
    }

    public function setTransactionToPending(Transaction $transaction)
    {
        $transaction = Transaction::findOrFail($transaction->id);
        $transaction->is_pending = true;
        $transaction->save();

        return $transaction->fresh();
    }

    public function setTransactionToApproved(Transaction $transaction)
    {
        $transaction = Transaction::findOrFail($transaction->id);
        $transaction->is_pending = false;
        $transaction->save();

        return $transaction->fresh();
    }

    public function updateDealIsPendingToFalse($dealEntry)
    {
        $transaction = Transaction::where('payable_type', get_class($dealEntry))
            ->where('payable_id', $dealEntry->id)
            ->where('is_pending', true)
            ->first();
        $transaction->is_pending = false;
        $transaction->save();

        return $transaction->fresh();
    }

    public function findTransactionByPayableAndWalletId($dealEntry, $walletId)
    {
        return Transaction::where('payable_type', get_class($dealEntry))
            ->where('payable_id', $dealEntry->id)
            ->where('wallet_id', $walletId)
            ->first();
    }

    public function findSumOfTransactionApprovedBalanceByWalletId($walletId)
    {
        return Transaction::where('wallet_id', $walletId)
            ->where('is_pending', false)
            ->sum('amount');
    }

    public function showByWalletId(int $walletId)
    {
        return Transaction::where('wallet_id', $walletId)
            ->paginate(config('services.paginate.projects'));
    }

    public function findTransactionById(int $transactionId)
    {
        return Transaction::with(['payable'])->findOrFail($transactionId);
    }

    public function updateTransactionCreatedAt($transactionDate, int $transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        $transaction->created_at = $transactionDate;
        $transaction->save();

        return $transaction->fresh();
    }
}
