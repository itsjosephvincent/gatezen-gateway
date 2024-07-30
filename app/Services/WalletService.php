<?php

namespace App\Services;

use App\Http\Resources\WalletResource;
use App\Http\Resources\WalletTotalEstimateResource;
use App\Interface\Repositories\ProjectRepositoryInterface;
use App\Interface\Repositories\TickerRepositoryInterface;
use App\Interface\Repositories\WalletRepositoryInterface;
use App\Interface\Services\WalletServiceInterface;

class WalletService implements WalletServiceInterface
{
    private $walletRepository;

    private $tickerRepository;

    private $projectRepository;

    public function __construct(
        WalletRepositoryInterface $walletRepository,
        TickerRepositoryInterface $tickerRepository,
        ProjectRepositoryInterface $projectRepository
    ) {
        $this->walletRepository = $walletRepository;
        $this->tickerRepository = $tickerRepository;
        $this->projectRepository = $projectRepository;
    }

    public function getUserReesWallet($user)
    {
        $reesProjectIds = $this->projectRepository->findReesProjectIds();
        $reesTickerIds = $this->tickerRepository->findReesIdList($reesProjectIds);
        $wallet = $this->walletRepository->findReesWalletByUserId($user->id, $reesTickerIds);

        return WalletResource::collection($wallet);
    }

    public function getUserWallet($userId)
    {
        $wallet = $this->walletRepository->findWalletByHoldableId($userId);

        return WalletResource::collection($wallet);
    }

    public function getUserWalletTotalEstimate($user)
    {
        $wallets = $this->walletRepository->findManyWalletsByUser($user);

        $total = null;
        foreach ($wallets as $wallet) {
            $total += floatval($wallet->balance) * floatval($wallet->belongable->price);
        }

        $data = (object) [
            'total' => number_format($total, 2, '.', ''),
        ];

        return new WalletTotalEstimateResource($data);
    }

    public function getUserReesWalletTotalEstimate($user)
    {
        $reesProjectIds = $this->projectRepository->findReesProjectIds();
        $reesTickerIds = $this->tickerRepository->findReesIdList($reesProjectIds);
        $wallets = $this->walletRepository->findReesWalletByUserId($user->id, $reesTickerIds);

        $total = null;
        foreach ($wallets as $wallet) {
            $total += floatval($wallet->balance) * floatval($wallet->belongable->price);
        }

        $data = (object) [
            'total' => number_format($total, 2, '.', ''),
        ];

        return new WalletTotalEstimateResource($data);
    }

    public function getWalletByHoldableAndBelongable($user, $ticker)
    {
        $wallet = $this->walletRepository->findWalletByHoldableAndBelongable($user, $ticker);

        return new WalletResource($wallet);
    }

    public function editWalletBalance($shares, $walletId)
    {
        $wallet = $this->walletRepository->updateWalletBalance($shares, $walletId);

        return new WalletResource($wallet);
    }

    public function createWallet($user, $ticker, $shares)
    {
        $wallet = $this->walletRepository->store($user, $ticker, $shares);

        return new WalletResource($wallet);
    }
}
