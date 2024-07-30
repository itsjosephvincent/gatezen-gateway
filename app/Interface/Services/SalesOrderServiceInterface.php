<?php

namespace App\Interface\Services;

interface SalesOrderServiceInterface
{
    public function getSalesOrderByUserId(int $userId);
}
