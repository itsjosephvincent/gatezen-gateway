<?php

namespace App\Repositories;

use App\Interface\Repositories\CurrencyRepositoryInterface;
use App\Models\Currency;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    public function showByCurrencyCode(string $code)
    {
        return Currency::where('code', $code)->first();
    }
}
