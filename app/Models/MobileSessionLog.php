<?php

namespace App\Models;

use Database\Factories\MobileSessionLogFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileSessionLog extends Model
{
    /** @use HasFactory<MobileSessionLogFactory> */
    use HasFactory;

    protected $fillable = ['collector_id', 'device_id', 'device_name', 'ip_address', 'user_agent', 'logged_in_at', 'logged_out_at', 'expires_at'];

    protected function casts(): array
    {
        return [
            'logged_in_at' => 'datetime',
            'logged_out_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }
}
