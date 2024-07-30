<?php

namespace App\Services;

use App\Enum\TransactionType;
use App\Http\Resources\SalesOrderProductResource;
use App\Interface\Repositories\SalesOrderProductRepositoryInterface;
use App\Interface\Repositories\SalesOrderRepositoryInterface;
use App\Interface\Repositories\TickerRepositoryInterface;
use App\Interface\Repositories\TransactionRepositoryInterface;
use App\Interface\Repositories\WalletRepositoryInterface;
use App\Interface\Services\SalesOrderProductServiceInterface;
use Illuminate\Support\Facades\DB;
use Throwable;

class SalesOrderProductService implements SalesOrderProductServiceInterface
{
    private $salesOrderProductRepository;

    private $transactionRepository;

    private $walletRepository;

    private $tickerRepository;

    private $salesOrderRepository;

    public function __construct(
        SalesOrderProductRepositoryInterface $salesOrderProductRepository,
        TransactionRepositoryInterface $transactionRepository,
        WalletRepositoryInterface $walletRepository,
        TickerRepositoryInterface $tickerRepository,
        SalesOrderRepositoryInterface $salesOrderRepository
    ) {
        $this->salesOrderProductRepository = $salesOrderProductRepository;
        $this->transactionRepository = $transactionRepository;
        $this->walletRepository = $walletRepository;
        $this->tickerRepository = $tickerRepository;
        $this->salesOrderRepository = $salesOrderRepository;
    }

    public function createSalesOrderProduct(object $payload, $record)
    {
        try {
            DB::beginTransaction();
            $salesOrder = $this->salesOrderRepository->findSalesOrderById($record->id);
            $salesOrderProduct = $this->salesOrderProductRepository->storeSalesOrderProduct($payload, $salesOrder);
            $ticker = $this->tickerRepository->findTickerById($salesOrderProduct->sellable_id);
            $wallet = $this->walletRepository->store($salesOrder->customer, $ticker);
            $this->transactionRepository->storeSalesOrderProductTransaction($salesOrderProduct, $wallet, $payload->quantity, TransactionType::Bought->value);
            DB::commit();

            return new SalesOrderProductResource($salesOrderProduct);
        } catch (Throwable $e) {
            DB::rollBack();
        }
    }
}
