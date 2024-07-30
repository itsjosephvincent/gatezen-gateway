<?php

namespace App\Services;

use App\Http\Resources\TransactionResource;
use App\Interface\Repositories\SalesOrderRepositoryInterface;
use App\Interface\Repositories\TransactionRepositoryInterface;
use App\Interface\Services\TransactionServiceInterface;

class TransactionService implements TransactionServiceInterface
{
    private $transactionRepository;

    private $pdfService;

    private $salesOrderRepository;

    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        SalesOrderRepositoryInterface $salesOrderRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->salesOrderRepository = $salesOrderRepository;
        $this->pdfService = new PdfService;
    }

    public function editSalesOrderIsPendingToFalse($salesOrder)
    {
        $transaction = $this->transactionRepository->updateSalesOrderProductIsPendingToFalse($salesOrder);

        return new TransactionResource($transaction);
    }

    public function editDealIsPendingToFalse($deal)
    {
        $transaction = $this->transactionRepository->updateDealIsPendingToFalse($deal);

        return new TransactionResource($transaction);
    }

    public function findTransactionByWalletId(int $walletId)
    {
        $transactions = $this->transactionRepository->showByWalletId($walletId);

        return TransactionResource::collection($transactions);
    }

    public function downloadInvoiceByTransactionId(int $transactionId)
    {
        $transaction = $this->transactionRepository->findTransactionById($transactionId);

        $salesOrder = $this->salesOrderRepository->findSalesOrderById($transaction->payable->sales_order_id);

        return $this->pdfService->downloadInvoice($salesOrder->invoice);
    }
}
