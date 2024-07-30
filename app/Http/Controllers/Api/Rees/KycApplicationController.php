<?php

namespace App\Http\Controllers\Api\Rees;

use App\Http\Controllers\Controller;
use App\Http\Requests\KycApplicationStoreRequest;
use App\Services\KycApplicationService;
use Illuminate\Http\JsonResponse;

class KycApplicationController extends Controller
{
    private $kycApplicationService;

    public function __construct(KycApplicationService $kycApplicationService)
    {
        $this->kycApplicationService = $kycApplicationService;
    }

    public function index(): JsonResponse
    {
        $user = auth()->user();

        return $this->kycApplicationService->getKycApplication($user)->response();
    }

    public function store(KycApplicationStoreRequest $request)
    {
        $user = auth()->user();

        return $this->kycApplicationService->storeApplication($request, $user);
    }
}
