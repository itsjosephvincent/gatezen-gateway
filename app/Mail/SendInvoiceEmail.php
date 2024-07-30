<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use App\Models\Invoice;
use App\Services\PdfService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendInvoiceEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $invoice;

    protected $pdfService;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
        $this->pdfService = new PdfService();
    }

    public function build()
    {
        $template = EmailTemplate::with(['email_type'])
            ->whereHas('email_type', function ($query): void {
                $query->where('name', 'invoice');
            })
            ->where('project_id', $this->invoice->project_id)
            ->first();

        if ($template) {
            return $this->subject($template->subject)
                ->view('emails.custom-invoice', [
                    'body' => $template->body_html,
                ])
                ->attachData($this->pdfService->createInvoiceAttachment($this->invoice), 'invoice-'.now()->format('d-m-Y').'.pdf', [
                    'mime' => 'application/pdf',
                ]);
        } else {
            return $this->subject('Payment document '.$this->invoice->invoice_number)
                ->markdown('emails.invoice', [
                    'invoice' => $this->invoice,
                ])
                ->attachData($this->pdfService->createInvoiceAttachment($this->invoice), 'invoice-'.now()->format('d-m-Y').'.pdf', [
                    'mime' => 'application/pdf',
                ]);
        }
    }
}
