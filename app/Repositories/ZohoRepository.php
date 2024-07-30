<?php

namespace App\Repositories;

use App\Enum\PaymentType;
use App\Enum\Status;
use App\Interface\Repositories\ZohoRepositoryInterface;
use App\Services\ExchangeService;
use App\Zoho\GenerateAccessToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class ZohoRepository implements ZohoRepositoryInterface
{
    private $generateAccessToken;

    private $userRepository;

    private $tickerRepository;

    private $exchangeService;

    private $dealRepository;

    private $dealEntryRepository;

    private $walletRepository;

    private $syncRepository;

    private $externalDataRepository;

    private $externalDataTypeRepository;

    private $currencyRepository;

    private $invoiceRepository;

    private $pdfTemplateRepository;

    private $invoiceProductRepository;

    private $invoicePaymentRepository;

    private $transactionRepository;

    public function __construct()
    {
        $this->generateAccessToken = new GenerateAccessToken;
        $this->userRepository = new UserRepository;
        $this->tickerRepository = new TickerRepository;
        $this->exchangeService = new ExchangeService;
        $this->dealRepository = new DealRepository;
        $this->dealEntryRepository = new DealEntryRepository;
        $this->walletRepository = new WalletRepository;
        $this->syncRepository = new SyncRepository;
        $this->externalDataRepository = new ExternalDataRepository;
        $this->externalDataTypeRepository = new ExternalDataTypeRepository;
        $this->currencyRepository = new CurrencyRepository;
        $this->invoiceRepository = new InvoiceRepository;
        $this->pdfTemplateRepository = new PdfTemplateRepository;
        $this->invoiceProductRepository = new InvoiceProductRepository;
        $this->invoicePaymentRepository = new InvoicePaymentRepository;
        $this->transactionRepository = new TransactionRepository;
    }

    public function syncInvoices(): void
    {
        try {
            $page = 1;
            $per_page = 100;
            $hasMoreInvoices = true;
            $token = $this->generateAccessToken->accessToken();
            while ($hasMoreInvoices) {
                $response = Http::withHeaders([
                    'Authorization' => 'Zoho-oauthtoken '.$token,
                ])->get('https://www.zohoapis.eu/books/v3/invoices', [
                    'organization_id' => config('zoho.organization_id'),
                    'invoice_number_startswith' => 'PD',
                    'page' => $page,
                    'per_page' => $per_page,
                ]);

                $data = json_decode($response->getBody());

                foreach ($data->invoices as $invoice) {
                    $externalData = $this->externalDataRepository->showByExternalId($invoice->invoice_number);
                    $currency = $this->currencyRepository->showByCurrencyCode($invoice->currency_code);

                    if (! $externalData) {
                        $user = $this->userRepository->findUserByEmail($invoice->email);
                        $dealName = '';
                        $tickerFromName = '';
                        if ($user) {
                            if (substr($invoice->invoice_number, 0, 3) == 'PD7') {
                                $dealName = 'CWISC to REES Property Class A';
                                $tickerFromName = 'CWISC';

                                // Custom ticker for invoices related to Thesis 3% group.
                                if (in_array($invoice->invoice_number, config('projects.zoho_thesis_invoices'))) {
                                    $dealName = 'THESIS to REES Property Class A';
                                    $tickerFromName = 'THESIS';
                                }
                            } elseif (substr($invoice->invoice_number, 0, 3) == 'PD2') {
                                $dealName = 'GBMT CY to REES Property Class A';
                                $tickerFromName = 'GBMT-CY';
                            } elseif (substr($invoice->invoice_number, 0, 3) == 'PD1') {
                                $dealName = 'Odds Profitt to REES Property Class A';
                                $tickerFromName = 'ODDSPROFITT';
                            }

                            if ($dealName && $tickerFromName) {
                                $deal = $this->dealRepository->findDealByName($dealName);
                                $tickerFrom = $this->tickerRepository->findTickerByName($tickerFromName);
                                $tickerTo = $this->tickerRepository->findTickerByName('RPAH-A');
                                $walletFrom = $this->walletRepository->findWalletByHoldableAndBelongable($user, $tickerFrom);
                                $externalDataType = $this->externalDataTypeRepository->showByName('Zoho Books Invoice');
                                $pdf = $this->pdfTemplateRepository->findInvoicePdfTemplateByProjectId($tickerTo->project_id);
                                if ($walletFrom) {
                                    $dealEntrypayload = (object) [
                                        'user_id' => $user->id,
                                        'status' => ($invoice->status == Status::Accepted->value) ? Status::Accepted->value : Status::Sent->value,
                                        'billable_price' => $invoice->total,
                                        'billable_quantity' => 1,
                                        'dealable_quantity' => $walletFrom->balance,
                                        'invoice_status' => ($invoice->status == Status::Paid->value) ? Status::Paid->value : Status::Sent->value,
                                        'created_at' => $invoice->date,
                                    ];

                                    $pendingTransactionStatus = ($invoice->status == Status::Paid->value) ? false : true;

                                    // If partly paid, accept the transaction.
                                    if ($invoice->balance < $invoice->total) {
                                        $pendingTransactionStatus = false;
                                    }

                                    $transactionDate = isset($invoice->last_payment_date) ? $invoice->last_payment_date : $invoice->last_modified_time;

                                    if ($deal) {
                                        $dealEntry = $this->dealEntryRepository->storeSyncDealEntry($dealEntrypayload, $deal);
                                        if ($invoice->status == Status::Paid->value || ($invoice->balance < $invoice->total)) {
                                            $walletTo = $this->walletRepository->findWalletByHoldableAndBelongable($user, $tickerTo);
                                            $this->exchangeService->dealTransfers($dealEntry, $walletFrom->id, $walletTo->id ?? null, $walletFrom->balance, $user, $tickerTo, $pendingTransactionStatus, $transactionDate);
                                        }
                                    } else {
                                        $dealPayload = (object) [
                                            'name' => $dealName,
                                            'date' => $invoice->date,
                                        ];
                                        $deal = $this->dealRepository->create($dealPayload, $tickerTo);
                                        $dealEntry = $this->dealEntryRepository->storeSyncDealEntry($dealEntrypayload, $deal);
                                        if ($invoice->status == Status::Paid->value || ($invoice->balance < $invoice->total)) {
                                            $walletTo = $this->walletRepository->findWalletByHoldableAndBelongable($user, $tickerTo);
                                            $this->exchangeService->dealTransfers($dealEntry, $walletFrom->id, $walletTo->id ?? null, $walletFrom->balance, $user, $tickerTo, $pendingTransactionStatus, $transactionDate);
                                        }
                                    }
                                    $this->externalDataRepository->storeZohoBooksInvoice($invoice, $externalDataType->id, $user);
                                    $invoiceResult = $this->invoiceRepository->storeZohoBooksInvoice($invoice, $currency->id, $tickerTo->project_id, $user, $pdf ?? null, $dealEntrypayload->invoice_status);
                                    $this->dealEntryRepository->updateStatusToInvoiced($dealEntry->id, $invoiceResult->id);
                                    $this->invoiceProductRepository->storeDealInvoiceProduct($dealEntry, $invoiceResult->id);
                                } else {
                                    $this->syncRepository->store($tickerFrom->project_id, json_encode($invoice), json_encode('Wallet not found for user '.$user->id.' and ticker '.$tickerFromName));
                                }
                            }
                        } else {
                            $this->syncRepository->store(1, json_encode($invoice), json_encode('User not found for email: '.$invoice->email.', under invoice: '.$invoice->invoice_number));
                        }
                    }
                }

                $hasMoreInvoices = count($data->invoices) === $per_page;
                $page++;
            }
        } catch (Throwable $e) {
            Log::debug($e->getMessage());
        }
    }

    public function syncBulkZohoPayment($invoices): void
    {
        try {
            $token = $this->generateAccessToken->accessToken();
            foreach ($invoices as $invoice) {
                $invoicePayment = $this->invoicePaymentRepository->findOneByInvoiceId($invoice->id);
                if (! $invoicePayment) {
                    $response = Http::withHeaders([
                        'Authorization' => 'Zoho-oauthtoken '.$token,
                    ])->get('https://www.zohoapis.eu/books/v3/invoices/'.$invoice->reference.'/payments?organization_id='.config('zoho.organization_id'));

                    $data = json_decode($response);

                    if (count($data->payments) > 0) {
                        foreach ($data->payments as $payment) {
                            $paymentData = (object) [
                                'amount' => $payment->amount,
                                'description' => $payment->description,
                                'date' => $payment->date,
                                'reference' => $payment->invoice_payment_id,
                                'paymentType' => ($payment->payment_mode == PaymentType::Cash->value) ? PaymentType::Cash->value : PaymentType::Bank->value,
                            ];
                            $this->invoicePaymentRepository->storeZohoBooksInvoicePayment($paymentData, $invoice);
                            $transactions = $invoice->deal_entry->transactions;
                            foreach ($transactions as $transaction) {
                                $this->transactionRepository->updateTransactionCreatedAt($payment->date, $transaction->id);
                            }
                        }
                    }
                }
            }
        } catch (Throwable $e) {
            Log::debug($e->getMessage());
        }
    }
}
