<?php

namespace App\Interface\Services;

interface SalesOrderProductServiceInterface
{
    public function createSalesOrderProduct(object $payload, $record);
}
