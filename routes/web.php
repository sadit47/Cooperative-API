<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'success' => true,
        'message' => 'Cooperative API is running',
        'endpoints' => [
            'POST /api/login',
            'POST /api/register',
            'GET /api/public/cooperative-requests'
        ]
    ]);
});
