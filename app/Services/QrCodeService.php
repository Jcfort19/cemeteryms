<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Support\Str;

class QrCodeService
{
    public function issue(Client $client): Client
    {
        if (! $client->qr_token) {
            $client->forceFill([
                'qr_token' => Str::random(48),
                'qr_issued_at' => now(),
            ])->save();
        }

        return $client;
    }

    public function signedPayload(Client $client): string
    {
        $this->issue($client);

        return encrypt([
            'client_number' => $client->client_number,
            'qr_token' => $client->qr_token,
            'issued_at' => optional($client->qr_issued_at)->toIso8601String(),
        ]);
    }

    public function validatePayload(string $payload): ?Client
    {
        try {
            $data = decrypt($payload);
        } catch (\Throwable) {
            return null;
        }

        return Client::query()
            ->where('client_number', $data['client_number'] ?? null)
            ->where('qr_token', $data['qr_token'] ?? null)
            ->where('status', 'active')
            ->first();
    }
}
