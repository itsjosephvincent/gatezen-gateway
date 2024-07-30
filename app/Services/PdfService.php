<?php

namespace App\Services;

use App\Exceptions\Portfolio\InvalidDownloadPortfolioException;
use App\Models\Invoice;
use App\Models\User;
use App\Repositories\PdfTemplateRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\TickerRepository;
use App\Repositories\WalletRepository;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class PdfService
{
    protected $pdfTemplateRepository;

    private $walletRepository;

    private $tickerRepository;

    private $projectRepository;

    public function __construct()
    {
        $this->pdfTemplateRepository = new PdfTemplateRepository();
        $this->walletRepository = new WalletRepository();
        $this->tickerRepository = new TickerRepository();
        $this->projectRepository = new ProjectRepository();
    }

    public function downloadPortfolio(User $user)
    {
        $pdf = $this->createPortfolioTemplate($user);

        return $pdf->stream('portfolio-estimation-'.now()->format('d-m-Y').'.pdf');
    }

    public function downloadPortfolioAPI(User $user)
    {
        if ($user->wallets()->exists()) {
            return $this->downloadPortfolio($user);
        }

        throw new InvalidDownloadPortfolioException();
    }

    public function createPortfolioFileAttachment(User $user)
    {
        $pdf = $this->createPortfolioTemplate($user);

        return $pdf->output();
    }

    public function createPortfolioTemplate(User $user)
    {
        $wallets = $this->walletRepository->findWalletByHoldableId($user->id);

        $tickers = [];
        foreach ($wallets as $wallet) {
            if ($wallet->balance == 0) {
                continue;
            }

            $ticker = $this->tickerRepository->findTickerById($wallet->belongable_id);

            $found = false;
            foreach ($tickers as &$t) {
                if ($t['project_id'] === $ticker->project_id) {
                    $t['data'][] = [
                        'type' => $ticker->type,
                        'balance' => $wallet->balance,
                        'price' => $ticker->price,
                        'currency' => $ticker->currency->symbol,
                    ];
                    $found = true;
                    break;
                }
            }

            if (! $found) {
                $tickers[] = [
                    'project_id' => $ticker->project_id,
                    'data' => [
                        [
                            'type' => $ticker->type,
                            'balance' => $wallet->balance,
                            'price' => $ticker->price,
                            'currency' => $ticker->currency->symbol,
                        ],
                    ],
                ];
            }
        }

        $projects = [];
        foreach ($tickers as $ticker) {
            $project = $this->projectRepository->findProjectById($ticker['project_id']);

            $projects[] = [
                'id' => $project->id,
                'name' => $project->name,
                'public_name' => $project->public_name,
            ];
        }

        if ($user->language_id) {
            app()->setLocale($user->language->code);
        }

        return PDF::loadView('pdf.portfolio', [
            'tickers' => $tickers,
            'projects' => $projects,
            'user' => $user,
        ]);
    }

    public function downloadInvoice(Invoice $invoice)
    {
        $pdf = $this->createInvoice($invoice);

        return $pdf->download('invoice-'.now()->format('d-m-Y').'.pdf');
    }

    public function createInvoiceAttachment(Invoice $invoice)
    {
        $pdf = $this->createInvoice($invoice);

        return $pdf->output();
    }

    public function createInvoice(Invoice $invoice)
    {
        if ($invoice->language_id) {
            app()->setLocale($invoice->language->code);
        }

        $pdf_template = $this->pdfTemplateRepository->findInvoicePdfTemplateByProjectId($invoice->project_id);

        if ($pdf_template) {

            $item_lines = $invoice->invoice_products;
            foreach ($item_lines as $item) {
                $items = [
                    'product_name' => $item->product_name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                ];
            }

            $data = [
                '{{ $invoice->currency->symbol }}' => $invoice->currency->symbol,
                '{{ $customerName }}' => $invoice->customer->firstname,
                '{{ $totalPrice }}' => number_format($invoice->calculateTotalGross(), 2, '.', ','),
                '{{ $item->product_name }}' => $items['product_name'],
                '{{ $item->price }}' => $items['price'],
                '{{ $item->quantity }}' => $items['quantity'],
            ];

            $template = str_replace(array_keys($data), array_values($data), $pdf_template->html_template);

            return PDF::loadView('pdf.custom-invoice', [
                'template' => $template,
            ]);
        } else {
            return PDF::loadView('pdf.invoice', [
                'invoice' => $invoice,
            ]);
        }
    }
}
