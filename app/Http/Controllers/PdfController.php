<?php

namespace App\Http\Controllers;

use App\Mail\SendInvoiceEmail;
use App\Mail\SendUserPortfolioEmail;
use App\Models\Invoice;
use App\Models\User;
use App\Services\PdfService;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PdfController extends Controller
{
    /**
     * The pdf instance.
     *
     * @var \App\Services\Pdf
     */
    protected $pdf;

    protected $pdfService;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\Pdf  $pdf
     * @return void
     */
    public function __construct(PDF $pdf, PdfService $pdfService)
    {
        // $this->middleware('auth');

        $this->pdf = $pdf;
        $this->pdfService = $pdfService;
    }

    /**
     * Generate the PDF to inspect or download.
     */
    public function __invoke(Request $request, $data = null): \Illuminate\Http\Response
    {
        $pdf = PDF::loadView('pdf.portfolio');

        return $pdf->download('portfolio-test.pdf');
    }

    public function downloadPortfolio(User $user)
    {
        return $this->pdfService->downloadPortfolio($user);
    }

    public function sendPdf(User $user)
    {
        if ($user->wallets()->exists()) {
            Mail::to($user->email)
                ->send(new SendUserPortfolioEmail($user));
            Notification::make()
                ->title('User portfolio')
                ->body('The email was successfully sent!')
                ->color('success')
                ->send();
        } else {
            Notification::make()
                ->title('User portfolio')
                ->body('No wallet found for this user!')
                ->color('warning')
                ->send();
        }

        return redirect()->back();
    }

    public function downloadInvoice(Invoice $invoice)
    {
        return $this->pdfService->downloadInvoice($invoice);
    }

    public function sendInvoice(Invoice $invoice)
    {
        Mail::to($invoice->customer->email)
            ->send(new SendInvoiceEmail($invoice));
        Notification::make()
            ->title('Invoice')
            ->body('The email was successfully sent!')
            ->color('success')
            ->send();

        return redirect()->back();
    }
}
