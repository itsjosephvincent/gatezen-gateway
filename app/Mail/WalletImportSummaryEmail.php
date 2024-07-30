<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WalletImportSummaryEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $successfulTransactions;

    protected $user;

    protected $failedTransactions;

    public function __construct($successfulTransactions, $user, $failedTransactions)
    {
        $this->successfulTransactions = $successfulTransactions;
        $this->user = $user;
        $this->failedTransactions = $failedTransactions;
    }

    public function build()
    {
        return $this->subject('Wallet Import Summary - '.now()->format('d-m-Y'))
            ->view('emails.wallet-import-summary', [
                'successfulTransactions' => $this->successfulTransactions,
                'failedTransactions' => $this->failedTransactions,
                'user' => $this->user,
            ]);
    }
}
