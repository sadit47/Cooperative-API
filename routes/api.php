<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Public\CooperativeRequestController as PublicCooperativeRequestController;
use App\Http\Controllers\Api\Staff\CooperativeRequestController as StaffCooperativeRequestController;

Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'API is working'
    ]);
});

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

Route::middleware(['auth:sanctum', 'role:staff'])
    ->prefix('staff')
    ->group(function () {
        Route::get('/cooperative-requests', [StaffCooperativeRequestController::class, 'index']);
        Route::get('/cooperative-requests/{id}', [StaffCooperativeRequestController::class, 'show']);
        Route::patch('/cooperative-requests/{id}/approve', [StaffCooperativeRequestController::class, 'approve']);
        Route::patch('/cooperative-requests/{id}/reject', [StaffCooperativeRequestController::class, 'reject']);
    });