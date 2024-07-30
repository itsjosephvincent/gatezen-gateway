<?php

namespace App\Http\Controllers;

use App\Services\KycDocumentService;

class KycDocumentController extends Controller
{
    private $kycDocumentService;

    public function __construct(KycDocumentService $kycDocumentService)
    {
        $this->kycDocumentService = $kycDocumentService;
    }

    public function download(int $kycDocumentId)
    {
        return $this->kycDocumentService->downloadKycDocument($kycDocumentId);
    }
}
