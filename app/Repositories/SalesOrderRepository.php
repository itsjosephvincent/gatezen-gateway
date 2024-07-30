<?php

namespace App\Repositories;

use App\Enum\Status;
use App\Interface\Repositories\SalesOrderRepositoryInterface;
use App\Models\SalesOrder;
use Carbon\Carbon;

class SalesOrderRepository implements SalesOrderRepositoryInterface
{
    public function storeSalesOrder($payload, $customerId)
    {
        $salesOrder = new SalesOrder();
        $salesOrder->project_id = $payload->project_id ?? null;
        $salesOrder->customer_id = $customerId;
        $salesOrder->currency_id = $payload->currency_id;
        $salesOrder->status = Status::Draft->value;
        $salesOrder->order_date = Carbon::now();
        $salesOrder->save();

        return $salesOrder->fresh();
    }

    public function updateStatusToInvoiced($salesOrderId, $invoiceId)
    {
        $salesOrder = SalesOrder::findOrFail($salesOrderId);
        $salesOrder->status = Status::Invoiced->value;
        $salesOrder->invoice_id = $invoiceId;
        $salesOrder->save();

        return $salesOrder->fresh();
    }

    public function findSalesOrderById($salesOrderId)
    {
        return SalesOrder::with(['invoice'])->findOrFail($salesOrderId);
    }

    public function findSalesOrderByUserId($userId)
    {
        return SalesOrder::with(['sales_order_products'])
            ->where('customer_id', $userId)
            ->get();
    }
}
