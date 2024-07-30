<?php

namespace App\Http\Controllers\Api\Gateway;

use App\Http\Controllers\Controller;
use App\Interface\Services\WalletServiceInterface;
use Illuminate\Http\JsonResponse;

class WalletController extends Controller
{
    private $walletService;

    public function __construct(WalletServiceInterface $walletService)
    {
        $this->walletService = $walletService;
    }

    public function index(): JsonResponse
    {
        $user = auth()->user();

        return $this->walletService->getUserWallet($user->id)->response();
    }

    public function totalWalletEstimateValue(): JsonResponse
    {
        $user = auth()->user();

        return $this->walletService->getUserWalletTotalEstimate($user)->response();
    }
}
