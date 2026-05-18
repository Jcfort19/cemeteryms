<?php

namespace App\Services;

use App\Models\Client;
use App\Models\SmsNotification;
use Illuminate\Support\Facades\Http;

class SemaphoreSmsService
{
    public function queue(Client $client, string $type, string $message): SmsNotification
    {
        return SmsNotification::create([
            'client_id' => $client->id,
            'recipient' => $client->phone ?? '',
            'type' => $type,
            'message' => $message,
            'status' => $client->phone ? 'queued' : 'skipped',
        ]);
    }

    public function send(SmsNotification $notification): SmsNotification
    {
        $apiKey = config('services.semaphore.key');

        if (! $apiKey || $notification->status === 'skipped') {
            return $notification;
        }

        $response = Http::asForm()->post('https://api.semaphore.co/api/v4/messages', [
            'apikey' => $apiKey,
            'number' => $notification->recipient,
            'message' => $notification->message,
            'sendername' => config('services.semaphore.sender', 'CemeteryMS'),
        ]);

        $notification->update([
            'status' => $response->successful() ? 'sent' : 'failed',
            'sent_at' => $response->successful() ? now() : null,
            'response' => $response->json() ?? ['body' => $response->body()],
        ]);

        return $notification;
    }
}
