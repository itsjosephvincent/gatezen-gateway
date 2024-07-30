<?php

namespace App\Repositories;

use App\Interface\Repositories\InvoicePaymentRepositoryInterface;
use App\Models\Invoice;
use App\Models\InvoicePayment;

class InvoicePaymentRepository implements InvoicePaymentRepositoryInterface
{
    public function storeZohoBooksInvoicePayment($paymentData, Invoice $invoice)
    {
        $payment = new InvoicePayment();
        $payment->invoice_id = $invoice->id;
        $payment->amount = $paymentData->amount;
        $payment->currency_id = $invoice->currency_id;
        $payment->description = $paymentData->description ?? null;
        $payment->payment_date = ($paymentData->date != '') ? $paymentData->date : null;
        $payment->reference = $paymentData->reference;
        $payment->payment_type = $paymentData->paymentType;
        $payment->save();

        return $payment->fresh();
    }

    public function store($data, $invoiceId)
    {
        $payment = new InvoicePayment();
        $payment->invoice_id = $invoiceId;
        $payment->amount = $data['amount'];
        $payment->currency_id = $data['currency_id'];
        $payment->description = $data['description'];
        $payment->payment_date = $data['payment_date'];
        $payment->reference = $data['reference'];
        $payment->payment_type = $data['payment_type'];
        $payment->save();

        return $payment->fresh();
    }

    public function findOneByInvoiceId(int $invoiceId)
    {
        return InvoicePayment::where('invoice_id', $invoiceId)->first();
    }
}
