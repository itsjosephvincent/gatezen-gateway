<?php

namespace App\Interface\Repositories;

use App\Models\SalesOrder;
use App\Models\User;

interface InvoiceRepositoryInterface
{
    public function storeDealInvoice(object $payload, int $pdfId);

    public function storeZohoBooksInvoice($invoiceData, $currencyId, $projectId, User $user, $pdfId, $status);

    public function storeSalesOrderInvoice(SalesOrder $salesOrder, $pdfId);

    public function findInvoiceByUserId(int $userId);

    public function findReesInvoiceByUserId(object $projectIds, int $customerId);

    public function findInvoiceById(int $invoiceId);
}
