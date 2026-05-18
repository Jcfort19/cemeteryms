<?php

namespace App\Http\Controllers;

use App\Models\CemeteryLot;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('modules.reports', [
            'dailyCollections' => Payment::whereDate('paid_at', today())->sum('amount'),
            'monthlyIncome' => Payment::whereMonth('paid_at', now()->month)->whereYear('paid_at', now()->year)->sum('amount'),
            'occupancy' => CemeteryLot::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
        ]);
    }

    public function collectionsPdf(Request $request): Response
    {
        $payments = Payment::with(['client', 'billing', 'collector'])->latest()->limit(100)->get();

        return Pdf::loadView('pdf.collections', compact('payments'))->stream('collections.pdf');
    }
}
