<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectorPaymentController extends Controller
{
    public function store(Request $request, PaymentService $payments): JsonResponse
    {
        $data = $request->validate([
            'billing_id' => ['required', 'exists:billings,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'notes' => ['nullable', 'string', 'max:500'],
            'device_id' => ['nullable', 'string', 'max:120'],
            'local_uuid' => ['nullable', 'string', 'max:120'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        $payment = $payments->record(Billing::findOrFail($data['billing_id']), (float) $data['amount'], $request->user(), [
            'channel' => 'collector',
            'payment_type' => 'cash',
            'notes' => $data['notes'] ?? null,
            'device_id' => $data['device_id'] ?? null,
            'local_uuid' => $data['local_uuid'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
        ])->load(['billing', 'client']);

        return response()->json([
            'message' => 'Payment successful.',
            'payment' => $payment,
            'remaining_balance' => $payment->billing->balance,
        ], 201);
    }
}
