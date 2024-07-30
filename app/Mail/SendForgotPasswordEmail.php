<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendForgotPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;

    private $token;

    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Reset Password')
            ->markdown('emails.reset-password', [
                'user' => $this->user,
                'token' => $this->token,
            ])
            ->bcc(env('ADMIN_EMAIL') ?? null);
    }
}
