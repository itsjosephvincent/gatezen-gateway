<?php

namespace App\Interface\Repositories;

use App\Models\Invoice;

interface InvoicePaymentRepositoryInterface
{
    public function storeZohoBooksInvoicePayment($paymentData, Invoice $invoice);

    public function store($data, $invoiceId);

    public function findOneByInvoiceId(int $invoiceId);
}
