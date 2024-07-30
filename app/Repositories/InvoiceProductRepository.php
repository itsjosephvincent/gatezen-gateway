<?php

namespace App\Repositories;

use App\Interface\Repositories\InvoiceProductRepositoryInterface;
use App\Models\InvoiceProduct;

class InvoiceProductRepository implements InvoiceProductRepositoryInterface
{
    public function findInvoiceProductByInvoiceable($payload)
    {
        return InvoiceProduct::where('invoiceable_type', get_class($payload))
            ->where('invoiceable_id', $payload->id)
            ->first();
    }

    public function storeSalesOrderInvoiceProduct($salesOrderProduct, $invoiceId)
    {
        $invoiceProduct = new InvoiceProduct();
        $invoiceProduct->invoice_id = $invoiceId;
        $invoiceProduct->invoiceable_type = get_class($salesOrderProduct->sales_order);
        $invoiceProduct->invoiceable_id = $salesOrderProduct->sales_order->id;
        $invoiceProduct->product_id = $salesOrderProduct->sellable->product_id;
        $invoiceProduct->product_name = $salesOrderProduct->product_name;
        $invoiceProduct->price = $salesOrderProduct->price;
        $invoiceProduct->quantity = $salesOrderProduct->quantity;
        $invoiceProduct->description = $salesOrderProduct->description ?? null;
        $invoiceProduct->position = $salesOrderProduct->position ?? null;
        $invoiceProduct->discount = $salesOrderProduct->discount ?? null;
        $invoiceProduct->save();

        return $invoiceProduct->fresh();
    }

    public function storeDealInvoiceProduct($payload, $invoiceId)
    {
        $invoiceProduct = new InvoiceProduct();
        $invoiceProduct->invoice_id = $invoiceId;
        $invoiceProduct->invoiceable_type = get_class($payload->deal);
        $invoiceProduct->invoiceable_id = $payload->deal->id;
        $invoiceProduct->product_id = $payload->deal->dealable->product_id;
        $invoiceProduct->product_name = $payload->deal->dealable->name;
        $invoiceProduct->price = $payload->billable_price;
        $invoiceProduct->quantity = $payload->billable_quantity;
        $invoiceProduct->save();

        return $invoiceProduct->fresh();
    }
}
