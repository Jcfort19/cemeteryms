<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\CollectorAssignment;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectorDashboardController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $collector = $request->user();
        $assignments = CollectorAssignment::with(['client.billings', 'client.lots.section'])
            ->where('collector_id', $collector->id)
            ->whereDate('assigned_date', today())
            ->get();

        return response()->json([
            'today_collections' => Payment::where('collected_by', $collector->id)->whereDate('paid_at', today())->sum('amount'),
            'assigned_clients' => $assignments,
            'recent_transactions' => Payment::with('client')->where('collected_by', $collector->id)->latest()->limit(10)->get(),
            'pending_billings' => Billing::whereIn('client_id', $assignments->pluck('client_id'))->where('balance', '>', 0)->get(),
        ]);
    }
}
