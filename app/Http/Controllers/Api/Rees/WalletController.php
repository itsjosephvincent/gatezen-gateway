<?php

namespace App\Http\Controllers\Api\Rees;

use App\Http\Controllers\Controller;
use App\Interface\Services\TransactionServiceInterface;
use App\Interface\Services\WalletServiceInterface;
use Illuminate\Http\JsonResponse;

class WalletController extends Controller
{
    private $walletService;

    private $transactionService;

    public function __construct(
        WalletServiceInterface $walletService,
        TransactionServiceInterface $transactionService
    ) {
        $this->walletService = $walletService;
        $this->transactionService = $transactionService;
    }

    public function index(): JsonResponse
    {
        $user = auth()->user();

        return $this->walletService->getUserReesWallet($user)->response();
    }

    public function showTransactions(int $walletId): JsonResponse
    {
        return $this->transactionService->findTransactionByWalletId($walletId)->response();
    }

    public function totalWalletEstimate(): JsonResponse
    {
        $user = auth()->user();

        return $this->walletService->getUserReesWalletTotalEstimate($user)->response();
    }
}
