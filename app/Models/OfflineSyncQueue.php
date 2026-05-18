<?php

namespace App\Models;

use Database\Factories\OfflineSyncQueueFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflineSyncQueue extends Model
{
    /** @use HasFactory<OfflineSyncQueueFactory> */
    use HasFactory;

    protected $fillable = ['collector_id', 'device_id', 'local_uuid', 'type', 'payload', 'status', 'attempts', 'synced_at', 'last_error'];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'synced_at' => 'datetime',
        ];
    }
}
