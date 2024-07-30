<?php

namespace App\Http\Controllers\Api\Gateway;

use App\Http\Controllers\Controller;
use App\Interface\Services\DealServiceInterface;
use Illuminate\Http\JsonResponse;

class DealController extends Controller
{
    private $dealService;

    public function __construct(DealServiceInterface $dealService)
    {
        $this->dealService = $dealService;
    }

    public function index(): JsonResponse
    {
        $user = auth()->user();

        return $this->dealService->getAllUserDealsByUserId($user->id)->response();
    }
}
