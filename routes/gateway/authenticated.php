<?php

use App\Http\Controllers\Api\Gateway\AuthController;
use App\Http\Controllers\Api\Gateway\CountryController;
use App\Http\Controllers\Api\Gateway\DealController;
use App\Http\Controllers\Api\Gateway\InvoiceController;
use App\Http\Controllers\Api\Gateway\KycApplicationController;
use App\Http\Controllers\Api\Gateway\LanguageController;
use App\Http\Controllers\Api\Gateway\NotificationController;
use App\Http\Controllers\Api\Gateway\PdfController;
use App\Http\Controllers\Api\Gateway\ProjectController;
use App\Http\Controllers\Api\Gateway\SalesOrderController;
use App\Http\Controllers\Api\Gateway\UserController;
use App\Http\Controllers\Api\Gateway\WalletController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'auth:sanctum',
], function (): void {

    Route::group(['prefix' => 'user'], function (): void {
        Route::get('/', [UserController::class, 'index']);
        Route::put('/', [UserController::class, 'update']);
        Route::put('/update-password', [UserController::class, 'updatePassword']);
    });

    Route::group(['prefix' => 'kyc'], function (): void {
        Route::get('/', [KycApplicationController::class, 'index']);
        Route::post('/document/upload', [KycApplicationController::class, 'store']);
    });

    Route::group(['prefix' => 'wallet'], function (): void {
        Route::get('/', [WalletController::class, 'index']);
        Route::get('/total-estimate', [WalletController::class, 'totalWalletEstimateValue']);
    });

    Route::group(['prefix' => 'projects'], function (): void {
        Route::get('/', [ProjectController::class, 'index']);
        Route::get('/{projectId}', [ProjectController::class, 'show']);
        Route::get('/{projectId}/wallet', [ProjectController::class, 'showProjectWalletById']);
    });

    Route::group(['prefix' => 'deals'], function (): void {
        Route::get('/', [DealController::class, 'index']);
    });

    Route::group(['prefix' => 'sales-orders'], function (): void {
        Route::get('/', [SalesOrderController::class, 'index']);
    });

    Route::group(['prefix' => 'invoice'], function (): void {
        Route::get('/', [InvoiceController::class, 'index']);
    });

    Route::group(['prefix' => 'notifications'], function (): void {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/total-unread', [NotificationController::class, 'totalUnreadNotification']);
        Route::put('/{notificationId}/read', [NotificationController::class, 'readNotification']);
    });

    Route::get('/projects-involved', [ProjectController::class, 'showProjectsByUserId']);
    Route::get('/download-portfolio', [PdfController::class, 'downloadPortfolio']);
    Route::get('/all-countries', [CountryController::class, 'index']);
    Route::get('/all-languages', [LanguageController::class, 'index']);

    Route::post('/logout', [AuthController::class, 'signout']);
    Route::post('/generate-token', [AuthController::class, 'authEncrypt']);
});
