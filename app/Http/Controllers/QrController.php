<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\QrCodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function clientId(Client $client, QrCodeService $qrCode): View
    {
        $payload = $qrCode->signedPayload($client);

        return view('modules.client-id', [
            'client' => $client,
            'qrSvg' => QrCode::format('svg')->size(220)->generate($payload),
        ]);
    }

    public function validatePayload(Request $request, QrCodeService $qrCode): JsonResponse
    {
        $data = $request->validate(['payload' => ['required', 'string']]);
        $client = $qrCode->validatePayload($data['payload']);

        return response()->json([
            'valid' => (bool) $client,
            'client' => $client?->load(['billings', 'lots.section']),
        ], $client ? 200 : 422);
    }
}
