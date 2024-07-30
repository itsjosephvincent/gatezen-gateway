<?php

namespace App\Mail;

use App\Models\User;
use App\Services\PdfService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUserPortfolioEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdfService;

    protected $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->pdfService = new PdfService();
        $this->user = $user;
    }

    public function build()
    {
        if ($this->user->language_id) {
            app()->setLocale($this->user->language->code);
        }

        return $this->subject(trans('pdf.email_subject'))
            ->markdown('emails.userPortfolio')
            ->attachData($this->pdfService->createPortfolioFileAttachment($this->user), 'portfolio-estimation-'.now()->format('d-m-Y').'.pdf', [
                'mime' => 'application/pdf',
            ])
            ->bcc(env('ADMIN_EMAIL') ?? null);
    }
}
