<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Public\CooperativeRequestController as PublicCooperativeRequestController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum', 'role:public'])
    ->prefix('public')
    ->group(function () {
        Route::get('/cooperative-requests', [PublicCooperativeRequestController::class, 'index']);
        Route::post('/cooperative-requests', [PublicCooperativeRequestController::class, 'store']);
        Route::get('/cooperative-requests/{id}', [PublicCooperativeRequestController::class, 'show']);
    });