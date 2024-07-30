<?php

namespace App\Http\Controllers\Api\Rees;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseTickerRequest;
use App\Interface\Services\ExchangeServiceInterface;
use App\Interface\Services\TickerServiceInterface;
use Illuminate\Http\JsonResponse;

class TickerController extends Controller
{
    private $tickerService;

    private $exchangeService;

    public function __construct(
        TickerServiceInterface $tickerService,
        ExchangeServiceInterface $exchangeService
    ) {
        $this->tickerService = $tickerService;
        $this->exchangeService = $exchangeService;
    }

    public function index(): JsonResponse
    {
        return $this->tickerService->getReesTickers()->response();
    }

    public function purchase(PurchaseTickerRequest $request)
    {
        $user = auth()->user();

        return $this->exchangeService->purchaseThroughRees($user, $request);
    }
}
