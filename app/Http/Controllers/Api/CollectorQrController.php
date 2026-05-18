<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\QrCodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectorQrController extends Controller
{
    public function validatePayload(Request $request, QrCodeService $qrCode): JsonResponse
    {
        $data = $request->validate(['payload' => ['required', 'string']]);
        $client = $qrCode->validatePayload($data['payload']);

        if (! $client) {
            return response()->json(['message' => 'Invalid or expired QR code.'], 422);
        }

        return response()->json([
            'client' => $client->load(['lots.section', 'billings.payments', 'deceasedRecords']),
        ]);
    }
}
