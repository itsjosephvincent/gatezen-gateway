<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendCustomKycEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject($this->data['subject'])
            ->markdown('emails.kyc-custom-email', [
                'data' => $this->data,
            ])
            ->bcc(env('ADMIN_EMAIL') ?? null);
    }
}
