<?php

namespace App\Http\Controllers\Api\Gateway;

use App\Http\Controllers\Controller;
use App\Interface\Services\CountryServiceInterface;
use Illuminate\Http\JsonResponse;

class CountryController extends Controller
{
    private $countryService;

    public function __construct(CountryServiceInterface $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index(): JsonResponse
    {
        return $this->countryService->countryList()->response();
    }
}
