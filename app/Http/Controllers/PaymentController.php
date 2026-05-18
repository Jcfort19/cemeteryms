<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Payment;
use App\Services\PaymentService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        return view('modules.payments', [
            'billings' => Billing::with('client')->where('balance', '>', 0)->latest()->get(),
            'payments' => Payment::with(['client', 'billing', 'collector'])->latest()->paginate(20),
        ]);
    }

    public function store(Request $request, PaymentService $payments): RedirectResponse
    {
        $data = $request->validate([
            'billing_id' => ['required', 'exists:billings,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $payment = $payments->record(Billing::findOrFail($data['billing_id']), (float) $data['amount'], $request->user(), [
            'channel' => $request->user()->hasRole('Collector') ? 'collector' : 'cashier',
            'payment_type' => 'cash',
            'notes' => $data['notes'] ?? null,
        ]);

        return back()->with('status', 'Payment posted: '.$payment->reference_number);
    }

    public function receipt(Payment $payment): Response
    {
        $payment->load(['client', 'billing', 'collector']);

        return Pdf::loadView('pdf.receipt', ['payment' => $payment])
            ->stream($payment->reference_number.'.pdf');
    }
}
