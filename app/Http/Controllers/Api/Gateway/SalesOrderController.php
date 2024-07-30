<?php

namespace App\Http\Controllers\Api\Gateway;

use App\Http\Controllers\Controller;
use App\Interface\Services\SalesOrderServiceInterface;
use Illuminate\Http\JsonResponse;

class SalesOrderController extends Controller
{
    private $salesOrderService;

    public function __construct(SalesOrderServiceInterface $salesOrderService)
    {
        $this->salesOrderService = $salesOrderService;
    }

    public function index(): JsonResponse
    {
        $user = auth()->user();

        return $this->salesOrderService->getSalesOrderByUserId($user->id)->response();
    }
}
