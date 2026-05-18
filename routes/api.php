<?php

use App\Http\Controllers\Api\CollectorAuthController;
use App\Http\Controllers\Api\CollectorDashboardController;
use App\Http\Controllers\Api\CollectorPaymentController;
use App\Http\Controllers\Api\CollectorQrController;
use App\Http\Controllers\Api\OfflineSyncController;
use Illuminate\Support\Facades\Route;

Route::post('/collector/login', [CollectorAuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->prefix('collector')->group(function () {
    Route::post('/logout', [CollectorAuthController::class, 'logout']);
    Route::get('/dashboard', CollectorDashboardController::class);
    Route::post('/qr/validate', [CollectorQrController::class, 'validatePayload']);
    Route::post('/payments', [CollectorPaymentController::class, 'store']);
    Route::post('/offline-sync', [OfflineSyncController::class, 'store']);
});
