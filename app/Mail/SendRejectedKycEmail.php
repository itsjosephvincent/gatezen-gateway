<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendRejectedKycEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $document;

    public function __construct($document)
    {
        $this->document = $document;
    }

    public function build()
    {
        return $this->subject('Re-submission Request for Verification Document')
            ->markdown('emails.rejected-kyc', [
                'document' => $this->document,
            ])
            ->bcc(env('ADMIN_EMAIL') ?? null);
    }
}
