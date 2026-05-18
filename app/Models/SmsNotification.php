<?php

namespace App\Models;

use Database\Factories\SmsNotificationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsNotification extends Model
{
    /** @use HasFactory<SmsNotificationFactory> */
    use HasFactory;

    protected $fillable = ['client_id', 'recipient', 'type', 'message', 'provider', 'provider_reference', 'status', 'sent_at', 'response'];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
            'response' => 'array',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
