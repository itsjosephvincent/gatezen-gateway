<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'rees'], function (): void {
    require 'rees/authenticated.php';
    require 'rees/unauthenticated.php';
});

Route::group(['prefix' => 'gateway'], function (): void {
    require 'gateway/authenticated.php';
    require 'gateway/unauthenticated.php';
});
