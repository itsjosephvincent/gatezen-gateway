<?php

namespace App\Actions;

use App\Models\Ticker;
use App\Models\User;
use App\Models\Wallet;

class CreateUserWallet
{
    public function execute(User $user, ?Ticker $ticker = null, $slug = 'euro')
    {
        $wallet = $user->wallets()->ofType($ticker ? $ticker->slug : $slug)->first();

        if (! $wallet) {
            $wallet = new Wallet();
            $wallet->slug = $ticker ? $ticker->slug : $slug;
            $wallet->holdable()->associate($user);

            if ($ticker) {
                $wallet->belongable()->associate($ticker);
            }

            $wallet->save();
        }

        return $wallet;
    }
}
