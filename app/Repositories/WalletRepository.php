<?php

namespace App\Repositories;

use App\Interface\Repositories\WalletRepositoryInterface;
use App\Models\Wallet;
use Illuminate\Support\Str;

class WalletRepository implements WalletRepositoryInterface
{
    public function findWalletById($walletId)
    {
        return Wallet::findOrFail($walletId);
    }

    public function findWalletByHoldableId($holdableId)
    {
        $wallets = Wallet::with([
            'transactions',
            'belongable',
        ])
            ->where('holdable_id', $holdableId)
            ->get();

        $wallets->each(function ($wallet): void {
            $pendingBalance = $wallet->transactions->where('is_pending', true)->sum('amount');
            $wallet->pending_balance = $pendingBalance;
        });

        return $wallets;
    }

    public function findManyWalletsByUser($user)
    {
        return Wallet::where('holdable_type', get_class($user))
            ->where('holdable_id', $user->id)
            ->get();
    }

    public function findTickerIdArrayByHoldableId($holdableId)
    {
        return Wallet::where('holdable_id', $holdableId)->pluck('belongable_id');
    }

    public function findReesWalletByUserId($userId, $tickersIds)
    {
        return Wallet::with([
            'belongable',
        ])
            ->where('holdable_type', 'App\Models\User')
            ->where('holdable_id', $userId)
            ->where('belongable_type', 'App\Models\Ticker')
            ->whereIn('belongable_id', $tickersIds)
            ->get();
    }

    public function findWalletByHoldableAndBelongable($user, $ticker)
    {
        return Wallet::with(['belongable'])
            ->where('holdable_type', get_class($user))
            ->where('holdable_id', $user->id)
            ->where('belongable_type', get_class($ticker))
            ->where('belongable_id', $ticker->id)
            ->first();
    }

    public function store($user, $ticker, $shares = 0.0000)
    {
        $wallet = new Wallet();
        $wallet->holdable_type = get_class($user);
        $wallet->holdable_id = $user->id;
        $wallet->belongable_type = get_class($ticker);
        $wallet->belongable_id = $ticker->id;
        $wallet->slug = Str::slug($ticker->ticker);
        $wallet->balance = $shares;
        $wallet->save();

        return $wallet->fresh();
    }

    public function refreshWalletBalance($shares, $walletId)
    {
        $wallet = Wallet::findOrFail($walletId);
        $wallet->balance = number_format($shares, 4, '.', '');
        $wallet->save();

        return $wallet->fresh();
    }

    public function updateWalletBalance($shares, $walletId)
    {
        $wallet = Wallet::findOrFail($walletId);
        $wallet->balance = $wallet->balance + number_format($shares, 4, '.', '');
        $wallet->save();

        return $wallet->fresh();
    }

    public function deductWalletBalance($shares, $walletId)
    {
        $wallet = Wallet::findOrFail($walletId);
        $wallet->balance = $wallet->balance - number_format($shares, 4, '.', '');
        $wallet->save();

        return $wallet->fresh();
    }
}
