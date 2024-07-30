<?php

use App\Http\Controllers\Api\Rees\AuthController;
use App\Http\Controllers\Api\Rees\InvoiceController;
use App\Http\Controllers\Api\Rees\KycApplicationController;
use App\Http\Controllers\Api\Rees\PdfController;
use App\Http\Controllers\Api\Rees\TickerController;
use App\Http\Controllers\Api\Rees\TransactionController;
use App\Http\Controllers\Api\Rees\UserController;
use App\Http\Controllers\Api\Rees\WalletController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function (): void {
    Route::group(['prefix' => 'tickers'], function (): void {
        Route::get('/', [TickerController::class, 'index']);
        Route::post('/purchase', [TickerController::class, 'purchase']);
    });

    Route::group(['prefix' => 'user'], function (): void {
        Route::get('/profile', [UserController::class, 'index']);
        Route::put('/update-profile', [UserController::class, 'update']);
    });

    Route::group(['prefix' => 'invoice'], function (): void {
        Route::get('/', [InvoiceController::class, 'index']);
    });

    Route::group(['prefix' => 'kyc'], function (): void {
        Route::get('/', [KycApplicationController::class, 'index']);
        Route::post('/document/upload', [KycApplicationController::class, 'store']);
    });

    Route::group(['prefix' => 'wallet'], function (): void {
        Route::get('/', [WalletController::class, 'index']);
        Route::get('/{walletId}/transactions', [WalletController::class, 'showTransactions']);
        Route::get('/total-estimate', [WalletController::class, 'totalWalletEstimate']);
    });

    Route::group(['prefix' => 'transactions'], function (): void {
        Route::get('/{transactionId}/invoice', [TransactionController::class, 'downloadInvoice']);
    });

    Route::get('/portfolio/download', [PdfController::class, 'downloadPortfolio']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
