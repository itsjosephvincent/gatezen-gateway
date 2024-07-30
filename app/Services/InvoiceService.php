<?php

namespace App\Services;

use App\Enum\Status;
use App\Http\Resources\InvoiceResource;
use App\Interface\Repositories\DealEntryRepositoryInterface;
use App\Interface\Repositories\InvoiceProductRepositoryInterface;
use App\Interface\Repositories\InvoiceRepositoryInterface;
use App\Interface\Repositories\NotificationRepositoryInterface;
use App\Interface\Repositories\PdfTemplateRepositoryInterface;
use App\Interface\Repositories\ProjectRepositoryInterface;
use App\Interface\Repositories\SalesOrderRepositoryInterface;
use App\Interface\Services\InvoiceServiceInterface;
use App\Mail\SendInvoiceEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;

class InvoiceService implements InvoiceServiceInterface
{
    protected $pdfTemplateService;

    protected $invoiceProductRepository;

    protected $notificationRepository;

    protected $dealEntryRepository;

    protected $invoiceRepository;

    protected $pdfTemplateRepository;

    private $projectRepository;

    private $salesOrderRepository;

    public function __construct(
        InvoiceProductRepositoryInterface $invoiceProductRepository,
        NotificationRepositoryInterface $notificationRepository,
        DealEntryRepositoryInterface $dealEntryRepository,
        InvoiceRepositoryInterface $invoiceRepository,
        PdfTemplateRepositoryInterface $pdfTemplateRepository,
        ProjectRepositoryInterface $projectRepository,
        SalesOrderRepositoryInterface $salesOrderRepository
    ) {
        $this->invoiceProductRepository = $invoiceProductRepository;
        $this->notificationRepository = $notificationRepository;
        $this->dealEntryRepository = $dealEntryRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->pdfTemplateRepository = $pdfTemplateRepository;
        $this->projectRepository = $projectRepository;
        $this->salesOrderRepository = $salesOrderRepository;
    }

    public function createSalesOrderInvoice($salesOrder, $user)
    {
        try {
            DB::beginTransaction();
            $pdf = $this->pdfTemplateRepository->findDefaultTemplate();
            $invoice = $this->invoiceRepository->storeSalesOrderInvoice($salesOrder, $pdf->id ?? null);
            $this->salesOrderRepository->updateStatusToInvoiced($salesOrder->id, $invoice->id);
            foreach ($salesOrder->sales_order_products as $product) {
                $this->invoiceProductRepository->storeSalesOrderInvoiceProduct($product, $invoice->id);
            }
            DB::commit();

            Mail::to($user->email)
                ->send(new SendInvoiceEmail($invoice));

            return $this->notificationRepository->showNotification('Success', 'Successfully created an invoice.', 'success');
        } catch (Throwable $e) {
            DB::rollBack();

            return $this->notificationRepository->showNotification('Error', 'An error occurred while creating an invoice', 'error');
        }
    }

    public function createDealInvoice($deal)
    {
        try {
            DB::beginTransaction();
            $pdf = $this->pdfTemplateRepository->findDefaultTemplate();
            $entries = $deal->deal_entries;
            foreach ($entries as $entry) {
                if ($entry->status === Status::Accepted->value && $entry->billable_price > 0 && $entry->billable_quantity > 0) {
                    $invoice = $this->invoiceRepository->storeDealInvoice($entry, $pdf);
                    $this->invoiceProductRepository->storeDealInvoiceProduct($entry, $invoice->id);
                    $this->dealEntryRepository->updateStatusToInvoiced($entry->id, $invoice->id);
                }
            }
            DB::commit();

            return $this->notificationRepository->showNotification('Success', 'Successfully created an invoice.', 'success');
        } catch (Throwable $e) {
            DB::rollBack();

            return $this->notificationRepository->showNotification('Error', 'An error occurred while creating an invoice', 'error');
        }
    }

    public function createDealInvoiceForSingleEntry($dealEntry)
    {
        try {
            DB::beginTransaction();
            $pdf = $this->pdfTemplateRepository->findDefaultTemplate();
            $invoice = $this->invoiceRepository->storeDealInvoice($dealEntry, $pdf->id);
            $this->invoiceProductRepository->storeDealInvoiceProduct($dealEntry, $invoice->id);
            $this->dealEntryRepository->updateStatusToInvoiced($dealEntry->id, $invoice->id);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json($e->getMessage());
        }
    }

    public function getReesInvoice($user)
    {
        $projectIds = $this->projectRepository->findReesProjectIds();
        $invoice = $this->invoiceRepository->findReesInvoiceByUserId($projectIds, $user->id);

        return InvoiceResource::collection($invoice);
    }

    public function getInvoiceByUserId($userId)
    {
        $invoice = $this->invoiceRepository->findInvoiceByUserId($userId);

        return InvoiceResource::collection($invoice);
    }
}
