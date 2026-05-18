<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\OfflineSyncQueue;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfflineSyncController extends Controller
{
    public function store(Request $request, PaymentService $payments): JsonResponse
    {
        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*.local_uuid' => ['required', 'string'],
            'items.*.device_id' => ['nullable', 'string'],
            'items.*.billing_id' => ['required', 'exists:billings,id'],
            'items.*.amount' => ['required', 'numeric', 'min:1'],
            'items.*.notes' => ['nullable', 'string'],
        ]);

        $synced = [];

        DB::transaction(function () use ($data, $request, $payments, &$synced) {
            foreach ($data['items'] as $item) {
                $queue = OfflineSyncQueue::firstOrCreate([
                    'local_uuid' => $item['local_uuid'],
                ], [
                    'collector_id' => $request->user()->id,
                    'device_id' => $item['device_id'] ?? null,
                    'payload' => $item,
                    'status' => 'pending',
                ]);

                if ($queue->status === 'synced') {
                    continue;
                }

                $payment = $payments->record(Billing::findOrFail($item['billing_id']), (float) $item['amount'], $request->user(), [
                    'channel' => 'collector-offline',
                    'payment_type' => 'cash',
                    'notes' => $item['notes'] ?? null,
                    'local_uuid' => $item['local_uuid'],
                ]);

                $queue->update(['status' => 'synced', 'synced_at' => now()]);
                $synced[] = $payment->reference_number;
            }
        });

        return response()->json(['synced' => $synced]);
    }
}
