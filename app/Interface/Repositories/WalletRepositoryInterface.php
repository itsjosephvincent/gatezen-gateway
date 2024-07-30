<?php

namespace App\Interface\Repositories;

use App\Models\Ticker;
use App\Models\User;

interface WalletRepositoryInterface
{
    public function findWalletById(int $walletId);

    public function findWalletByHoldableId(int $holdableId);

    public function findManyWalletsByUser(User $user);

    public function findTickerIdArrayByHoldableId(int $holdableId);

    public function findReesWalletByUserId(int $userId, array $tickersIds);

    public function findWalletByHoldableAndBelongable(User $user, Ticker $ticker);

    public function store(User $user, Ticker $ticker, $shares = 0.0000);

    public function refreshWalletBalance($shares, $walletId);

    public function updateWalletBalance($shares, $walletId);

    public function deductWalletBalance($shares, $walletId);
}
