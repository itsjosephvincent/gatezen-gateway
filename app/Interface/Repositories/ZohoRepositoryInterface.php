<?php

namespace App\Interface\Repositories;

interface ZohoRepositoryInterface
{
    public function syncInvoices();

    public function syncBulkZohoPayment($invoices);
}
