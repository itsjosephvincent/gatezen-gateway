<?php

namespace App\Interface\Services;

use App\Models\Ticker;
use App\Models\User;

interface ExchangeServiceInterface
{
    public function buy(User $user, array $data, $sync, $transactionData);

    public function buyAsset(Ticker $ticker, User $user, array $data, $sync, $transactionData);

    public function sell(array $data);

    public function dealTransfers($dealEntry, $walletIdFrom, $walletIdTo, $shares, $user, $ticker, $pendingTransactionStatus, $transactionDate = null);

    public function purchaseThroughRees(User $user, $payload);

    public function validateData($data);
}
