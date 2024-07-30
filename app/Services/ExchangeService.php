<?php

namespace App\Services;

use App\Actions\CreateUserWallet;
use App\Enum\TransactionType;
use App\Http\Resources\ReesPurchaseResource;
use App\Http\Resources\SalesOrderProductsResource;
use App\Http\Resources\SalesOrderResource;
use App\Interface\Services\ExchangeServiceInterface;
use App\Mail\SendInvoiceEmail;
use App\Models\Ticker;
use App\Models\User;
use App\Repositories\InvoiceProductRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\PdfTemplateRepository;
use App\Repositories\SalesOrderProductRepository;
use App\Repositories\SalesOrderRepository;
use App\Repositories\TickerRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ExchangeService implements ExchangeServiceInterface
{
    private $tickerRepository;

    private $walletRepository;

    private $transactionRepository;

    private $salesOrderRepository;

    private $salesOrderProductRepository;

    private $invoiceRepository;

    private $pdfTemplateRepository;

    private $invoiceProductRepository;

    public function __construct()
    {
        $this->tickerRepository = new TickerRepository();
        $this->walletRepository = new WalletRepository();
        $this->transactionRepository = new TransactionRepository();
        $this->salesOrderRepository = new SalesOrderRepository();
        $this->salesOrderProductRepository = new SalesOrderProductRepository();
        $this->invoiceRepository = new InvoiceRepository();
        $this->pdfTemplateRepository = new PdfTemplateRepository();
        $this->invoiceProductRepository = new InvoiceProductRepository();
    }

    public function buy(User $user, array $data, $sync = null, $transactionData = null)
    {
        $tickers = $this->tickerRepository->findTickerArray($data);

        try {
            DB::beginTransaction();
            foreach ($tickers as $ticker) {
                $transaction = self::buyAsset($ticker, $user, $data, $sync ?? null, $transactionData ?? null);

                $user->attachTags($ticker->tags->pluck('name'));
                $user->attachTags($ticker->project->tags->pluck('name'));
            }
            DB::commit();

            return $transaction;
        } catch (Throwable $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }

    public function buyAsset(Ticker $ticker, User $user, array $data, $sync = null, $transactionData = null)
    {
        $wallet = (new CreateUserWallet)->execute($user, $ticker);

        $wallet->balance = $wallet->balance + number_format($data['shares'], 4, '.', '');
        $wallet->save();

        if ($sync) {
            if ($transactionData && $transactionData['type'] === 'deposit') {
                $transaction = $this->transactionRepository->storeSyncTransaction($sync, $wallet, $transactionData['amount'], TransactionType::Bought->value, $data['description'] ?? null, $data['transaction_date'] ?? null);
            } else {
                $transaction = $this->transactionRepository->storeSyncTransaction($sync, $wallet, $data['shares'], TransactionType::Bought->value, $data['description'] ?? null, $data['transaction_date'] ?? null);
            }
        } else {
            $transaction = $this->transactionRepository->storeWalletTransaction($wallet, $data['shares'], TransactionType::Bought->value, $data['description'] ?? null, $data['transaction_date'] ?? null);
        }

        return $transaction;
    }

    public function sell(array $data)
    {
        $wallet = $this->walletRepository->findWalletById($data['wallet_id']);

        if ($data['shares'] > $wallet->balance) {
            return false;
        }

        try {
            DB::beginTransaction();
            $wallet->balance = $wallet->balance - number_format($data['shares'], 4, '.', '');
            $wallet->save();

            $this->transactionRepository->storeWalletTransaction($wallet, -$data['shares'], TransactionType::Sold->value);
            DB::commit();

            return true;
        } catch (Throwable $e) {
            DB::rollBack();

            return false;
        }
    }

    public function dealTransfers($dealEntry, $walletIdFrom, $walletIdTo, $shares, $user, $ticker, $pendingTransactionStatus, $transactionDate = null)
    {
        try {
            DB::beginTransaction();
            $walletOrigin = $this->walletRepository->findWalletById($walletIdFrom);

            if ($pendingTransactionStatus == false) {
                if ($walletOrigin->balance > 0) {
                    $walletOrigin->balance = $walletOrigin->balance - number_format($shares, 4, '.', '');
                    $walletOrigin->save();
                    if (! $walletIdTo) {
                        $walletDestination = $this->walletRepository->store($user, $ticker, $shares);
                    } else {
                        $walletDestination = $this->walletRepository->findWalletById($walletIdTo);
                        $walletDestination->balance = $walletDestination->balance + number_format($shares, 4, '.', '');
                        $walletDestination->save();
                    }
                    $user->attachTags($ticker->tags->pluck('name'));
                    $user->attachTags($ticker->project->tags->pluck('name'));
                    $this->transactionRepository->storeZohoBooksTransaction($pendingTransactionStatus, $dealEntry, $walletOrigin, -$shares, TransactionType::Transferred->value, 'Deal transfer: '.$dealEntry->deal->name, $transactionDate);
                    $this->transactionRepository->storeZohoBooksTransaction($pendingTransactionStatus, $dealEntry, $walletDestination, $shares, TransactionType::Transferred->value, 'Deal transfer: '.$dealEntry->deal->name, $transactionDate);
                }
            } else {
                $this->transactionRepository->storeZohoBooksTransaction($pendingTransactionStatus, $dealEntry, $walletOrigin, -$shares, TransactionType::Transferred->value, 'Deal transfer: '.$dealEntry->deal->name, $transactionDate);
            }

            DB::commit();

            return true;
        } catch (Throwable $e) {
            DB::rollBack();

            Log::debug($e->getMessage());
        }
    }

    public function purchaseThroughRees(User $user, $payload)
    {
        try {
            DB::beginTransaction();
            $pdf = $this->pdfTemplateRepository->findDefaultTemplate();
            $ticker = $this->tickerRepository->findTickerById($payload->ticker_id);
            $salesOrder = $this->salesOrderRepository->storeSalesOrder($ticker, $user->id);
            $data = (object) [
                'sellable_type' => get_class($ticker),
                'sellable_id' => $ticker->id,
                'product_name' => $ticker->name,
                'price' => $ticker->price,
                'quantity' => $payload->quantity,
            ];
            $salesOrderProduct = $this->salesOrderProductRepository->storeSalesOrderProduct($data, $salesOrder);
            $wallet = $this->walletRepository->findWalletByHoldableAndBelongable($user, $ticker);
            if (! $wallet) {
                $wallet = $this->walletRepository->store($user, $ticker);
            }
            $this->transactionRepository->storeSalesOrderProductTransaction($salesOrderProduct, $wallet, $payload->quantity, TransactionType::Bought->value);
            $invoice = $this->invoiceRepository->storeSalesOrderInvoice($salesOrder, $pdf->id ?? null);
            $this->invoiceProductRepository->storeSalesOrderInvoiceProduct($salesOrderProduct, $invoice->id);
            $this->salesOrderRepository->updateStatusToInvoiced($salesOrder->id, $invoice->id);
            DB::commit();

            Mail::to($user->email)
                ->send(new SendInvoiceEmail($invoice));

            $data = (object) [
                'sales_order' => new SalesOrderResource($salesOrder),
                'sales_order_product' => new SalesOrderProductsResource($salesOrderProduct),
            ];

            return new ReesPurchaseResource($data);
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json($e->getMessage());
        }
    }

    public function validateData($data)
    {
        return Validator::make($data, [
            'shares' => 'required|numeric|min:1',
            'transaction_date' => 'date_format:Y-m-d H:i:s',
        ]);
    }
}
