<?php

namespace App\Http\Controllers\Api\Gateway;

use App\Http\Controllers\Controller;
use App\Interface\Services\LanguageServiceInterface;
use Illuminate\Http\JsonResponse;

class LanguageController extends Controller
{
    private $languageService;

    public function __construct(LanguageServiceInterface $languageService)
    {
        $this->languageService = $languageService;
    }

    public function index(): JsonResponse
    {
        return $this->languageService->getLanguageList()->response();
    }
}
