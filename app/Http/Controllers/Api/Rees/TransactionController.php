<?php

namespace App\Http\Controllers\Api\Rees;

use App\Http\Controllers\Controller;
use App\Interface\Services\TransactionServiceInterface;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct(TransactionServiceInterface $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function downloadInvoice(int $transactionId)
    {
        return $this->transactionService->downloadInvoiceByTransactionId($transactionId);
    }
}
