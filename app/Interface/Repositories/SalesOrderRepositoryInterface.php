<?php

namespace App\Interface\Repositories;

interface SalesOrderRepositoryInterface
{
    public function storeSalesOrder(object $payload, int $customerId);

    public function updateStatusToInvoiced(int $salesOrderId, int $invoiceId);

    public function findSalesOrderById(int $salesOrderId);

    public function findSalesOrderByUserId(int $userId);
}
