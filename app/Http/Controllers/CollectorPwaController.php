<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\CollectorAssignment;
use App\Models\Payment;
use Illuminate\View\View;

class CollectorPwaController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        return view('collector.app', [
            'stats' => [
                'today' => Payment::where('collected_by', $user->id)->whereDate('paid_at', today())->sum('amount'),
                'assigned' => CollectorAssignment::where('collector_id', $user->id)->whereDate('assigned_date', today())->count(),
                'pending' => Billing::whereHas('client', fn ($query) => $query->whereHas('collectorAssignments', fn ($q) => $q->where('collector_id', $user->id)))->where('balance', '>', 0)->count(),
            ],
            'recentPayments' => Payment::with('client')->where('collected_by', $user->id)->latest()->limit(8)->get(),
        ]);
    }
}
