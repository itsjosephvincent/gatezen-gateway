<?php

namespace App\Http\Controllers\Api\Gateway;

use App\Http\Controllers\Controller;
use App\Interface\Services\InvoiceServiceInterface;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
{
    private $invoiceService;

    public function __construct(InvoiceServiceInterface $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function index(): JsonResponse
    {
        $user = auth()->user();

        return $this->invoiceService->getInvoiceByUserId($user->id)->response();
    }
}
