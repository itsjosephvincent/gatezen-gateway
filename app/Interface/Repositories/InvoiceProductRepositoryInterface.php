<?php

namespace App\Interface\Repositories;

use App\Models\SalesOrderProduct;

interface InvoiceProductRepositoryInterface
{
    public function findInvoiceProductByInvoiceable(object $payload);

    public function storeSalesOrderInvoiceProduct(SalesOrderProduct $salesOrderProduct, int $invoiceId);

    public function storeDealInvoiceProduct(object $payload, int $invoiceId);
}
