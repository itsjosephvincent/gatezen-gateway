<?php

namespace App\Repositories;

use App\Enum\Status;
use App\Interface\Repositories\InvoiceRepositoryInterface;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function storeDealInvoice($payload, $pdfId = null)
    {
        $invoice = new Invoice();
        $invoice->project_id = $payload->deal->dealable->project_id;
        $invoice->customer_id = $payload->user_id;
        $invoice->currency_id = $payload->deal->dealable->currency_id;
        $invoice->language_id = $payload->user->language_id ?? 1;
        $invoice->template_id = $pdfId;
        $invoice->status = Status::Draft->value;
        $invoice->invoice_date = Carbon::now();
        $invoice->due_date = Carbon::now()->addDays(5);
        $invoice->save();

        return $invoice->fresh();
    }

    public function storeZohoBooksInvoice($invoiceData, $currencyId, $projectId, User $user, $pdfId, $status)
    {
        $invoice = new Invoice();
        $invoice->project_id = $projectId;
        $invoice->customer_id = $user->id;
        $invoice->currency_id = $currencyId;
        $invoice->language_id = $user->language_id ?? 1;
        $invoice->template_id = $pdfId;
        $invoice->status = $status;
        $invoice->invoice_number = $invoiceData->invoice_number;
        $invoice->invoice_date = $invoiceData->date;
        $invoice->due_date = $invoiceData->due_date;
        $invoice->reference = $invoiceData->invoice_id;
        $invoice->save();

        return $invoice->fresh();
    }

    public function storeSalesOrderInvoice($salesOrder, $pdfId = null)
    {
        $invoice = new Invoice();
        $invoice->project_id = $salesOrder->project_id ?? null;
        $invoice->customer_id = $salesOrder->customer_id;
        $invoice->currency_id = $salesOrder->currency_id;
        $invoice->language_id = $salesOrder->customer->language_id ?? 1;
        $invoice->template_id = $pdfId ?? null;
        $invoice->status = Status::Draft->value;
        $invoice->invoice_date = Carbon::now();
        $invoice->due_date = Carbon::now()->addDays(5);
        $invoice->save();

        return $invoice->fresh();
    }

    public function findInvoiceByUserId($userId)
    {
        return Invoice::with(['invoice_products'])
            ->where('customer_id', $userId)
            ->get();
    }

    public function findReesInvoiceByUserId($projectIds, $customerId)
    {
        return Invoice::with(['invoice_products'])->where('customer_id', $customerId)
            ->whereIn('project_id', $projectIds)
            ->get();
    }

    public function findInvoiceById($invoiceId)
    {
        return Invoice::findOrFail($invoiceId);
    }
}
