<?php

namespace App\Services;

use App\Http\Resources\SalesOrderResource;
use App\Interface\Repositories\SalesOrderRepositoryInterface;
use App\Interface\Services\SalesOrderServiceInterface;

class SalesOrderService implements SalesOrderServiceInterface
{
    private $salesOrderRepository;

    public function __construct(SalesOrderRepositoryInterface $salesOrderRepository)
    {
        $this->salesOrderRepository = $salesOrderRepository;
    }

    public function getSalesOrderByUserId($userId)
    {
        $salesOrder = $this->salesOrderRepository->findSalesOrderByUserId($userId);

        return SalesOrderResource::collection($salesOrder);
    }
}
