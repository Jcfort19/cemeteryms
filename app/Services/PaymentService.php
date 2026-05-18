<?php

namespace App\Services;

use App\Models\Billing;
use App\Models\Payment;
use App\Models\TransactionLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function record(Billing $billing, float $amount, ?User $collector, array $context = []): Payment
    {
        return DB::transaction(function () use ($billing, $amount, $collector, $context) {
            $billing->refresh();

            $amount = min(round($amount, 2), (float) $billing->balance);

            $payment = Payment::create([
                'billing_id' => $billing->id,
                'client_id' => $billing->client_id,
                'collected_by' => $collector?->id,
                'reference_number' => 'PAY-'.now()->format('YmdHis').'-'.str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT),
                'amount' => $amount,
                'payment_type' => $context['payment_type'] ?? 'cash',
                'channel' => $context['channel'] ?? 'cashier',
                'status' => 'posted',
                'notes' => $context['notes'] ?? null,
                'metadata' => $context,
                'paid_at' => now(),
            ]);

            $paid = (float) $billing->paid_amount + $amount;
            $balance = max((float) $billing->amount - $paid, 0);

            $billing->update([
                'paid_amount' => $paid,
                'balance' => $balance,
                'status' => $balance <= 0 ? 'paid' : 'partial',
            ]);

            TransactionLog::create([
                'user_id' => $collector?->id,
                'client_id' => $billing->client_id,
                'billing_id' => $billing->id,
                'payment_id' => $payment->id,
                'type' => 'payment.posted',
                'reference' => $payment->reference_number,
                'amount' => $amount,
                'payload' => $context,
            ]);

            return $payment;
        });
    }
}
