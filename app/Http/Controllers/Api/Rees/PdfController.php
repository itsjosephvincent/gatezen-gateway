<?php

namespace App\Http\Controllers\Api\Rees;

use App\Http\Controllers\Controller;
use App\Services\PdfService;

class PdfController extends Controller
{
    private $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function downloadPortfolio()
    {
        $user = auth()->user();

        return $this->pdfService->downloadPortfolioAPI($user);
    }
}
