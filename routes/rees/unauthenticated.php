<?php

use App\Http\Controllers\Api\Rees\AuthController;
use App\Http\Middleware\AuthenticateReesAccess;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth',
    'middleware' => AuthenticateReesAccess::class,
], function (): void {
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::group([
    'prefix' => 'auth',
], function (): void {
    Route::post('/register', [AuthController::class, 'register']);
});
