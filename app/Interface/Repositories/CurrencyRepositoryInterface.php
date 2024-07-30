<?php

namespace App\Interface\Repositories;

interface CurrencyRepositoryInterface
{
    public function showByCurrencyCode(string $code);
}
