<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\CemeteryMapController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CollectorPwaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuardTerminalController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('auth.login');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified', 'session.timeout'])->name('dashboard');

Route::middleware(['auth', 'session.timeout', 'audit'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:Semi Admin|Cashier|Staff')->group(function () {
        Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
        Route::post('/clients', [ClientController::class, 'store'])->middleware('role:Semi Admin|Staff')->name('clients.store');
        Route::get('/clients/{client}/id', [QrController::class, 'clientId'])->name('clients.id');

        Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
        Route::post('/billing', [BillingController::class, 'store'])->middleware('role:Semi Admin|Cashier')->name('billing.store');

        Route::get('/payments', [PaymentController::class, 'index'])->middleware('role:Semi Admin|Cashier|Staff')->name('payments.index');
        Route::post('/payments', [PaymentController::class, 'store'])->middleware('role:Semi Admin|Cashier')->name('payments.store');
        Route::get('/payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');
    });

    Route::middleware('role:Semi Admin|Staff|Cashier|Guard')->group(function () {
        Route::get('/cemetery-map', [CemeteryMapController::class, 'index'])->name('map.index');
        Route::get('/cemetery-map/lots', [CemeteryMapController::class, 'lots'])->name('map.lots');
        Route::patch('/cemetery-map/lots/{lot}', [CemeteryMapController::class, 'updateLot'])->middleware('role:Semi Admin')->name('map.lots.update');
        Route::post('/qr/validate', [QrController::class, 'validatePayload'])->name('qr.validate');
    });

    Route::middleware('role:Semi Admin|Guard')->group(function () {
        Route::get('/guard-terminal', [GuardTerminalController::class, 'index'])->name('guard.index');
        Route::post('/guard-terminal', [GuardTerminalController::class, 'store'])->name('guard.store');
    });

    Route::middleware('role:Semi Admin|Cashier|Staff')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/collections.pdf', [ReportController::class, 'collectionsPdf'])->name('reports.collections.pdf');
    });

    Route::middleware('role:Collector')->group(function () {
        Route::get('/collector', [CollectorPwaController::class, 'index'])->name('collector.app');
    });
});

require __DIR__.'/auth.php';
