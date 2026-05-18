<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\CemeteryLot;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'stats' => [
                'clients' => Client::count(),
                'lots' => CemeteryLot::count(),
                'vacant_lots' => CemeteryLot::where('status', 'vacant')->count(),
                'occupied_lots' => CemeteryLot::where('status', 'occupied')->count(),
                'pending_billings' => Billing::whereIn('status', ['pending', 'partial'])->sum('balance'),
                'today_collections' => Payment::whereDate('paid_at', today())->sum('amount'),
                'pending_reservations' => Reservation::where('status', 'pending')->count(),
            ],
            'recentPayments' => Payment::with(['client', 'billing', 'collector'])->latest()->limit(6)->get(),
            'reservations' => Reservation::with('cemeteryLot')->latest()->limit(6)->get(),
            'lots' => CemeteryLot::with(['section', 'client'])->latest()->limit(8)->get(),
        ]);
    }
}
