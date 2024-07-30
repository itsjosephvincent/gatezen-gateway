<?php

namespace App\Interface\Repositories;

use App\Models\SalesOrder;

interface SalesOrderProductRepositoryInterface
{
    public function findCurrencyBySalesOrderId(int $salesOrderId);

    public function storeSalesOrderProduct(object $payload, SalesOrder $salesOrder);
}
