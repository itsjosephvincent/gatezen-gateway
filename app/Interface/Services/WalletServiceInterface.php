<?php

namespace App\Interface\Services;

use App\Models\User;

interface WalletServiceInterface
{
    public function getUserReesWallet(User $user);

    public function getUserWallet(int $userId);

    public function getUserWalletTotalEstimate(User $user);

    public function getUserReesWalletTotalEstimate(User $user);

    public function getWalletByHoldableAndBelongable($user, $ticker);

    public function editWalletBalance($shares, int $walletId);

    public function createWallet($user, $ticker, $shares);
}
