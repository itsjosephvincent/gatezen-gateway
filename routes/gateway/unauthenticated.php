<?php

use App\Http\Controllers\Api\Gateway\AuthController;
use App\Http\Middleware\AuthenticateGatewayAccess;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth',
], function (): void {
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::post('/forgot-password', [AuthController::class, 'sendForgotPasswordEmail']);
    Route::post('/reset-password', [AuthController::class, 'resetForgotPassword']);
});

Route::group([
    'prefix' => 'sso',
    'middleware' => AuthenticateGatewayAccess::class,
], function (): void {
    Route::post('/login', [AuthController::class, 'singleSignOn']);
});
