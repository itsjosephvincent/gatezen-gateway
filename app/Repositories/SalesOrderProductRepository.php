<?php

namespace App\Repositories;

use App\Interface\Repositories\SalesOrderProductRepositoryInterface;
use App\Models\SalesOrderProduct;

class SalesOrderProductRepository implements SalesOrderProductRepositoryInterface
{
    public function findCurrencyBySalesOrderId($salesOrderId)
    {
        return SalesOrderProduct::where('sales_order_id', $salesOrderId)->first();
    }

    public function storeSalesOrderProduct($payload, $salesOrder)
    {
        $salesOrderProduct = new SalesOrderProduct();
        $salesOrderProduct->sales_order_id = $salesOrder->id;
        $salesOrderProduct->sellable_type = $payload->sellable_type;
        $salesOrderProduct->sellable_id = $payload->id ?? $payload->sellable_id;
        $salesOrderProduct->product_name = $payload->name ?? $payload->product_name;
        $salesOrderProduct->price = $payload->price;
        $salesOrderProduct->quantity = $payload->quantity;
        $salesOrderProduct->save();

        return $salesOrderProduct->fresh();
    }
}
