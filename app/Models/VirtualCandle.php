<?php

namespace App\Models;

use Database\Factories\VirtualCandleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualCandle extends Model
{
    /** @use HasFactory<VirtualCandleFactory> */
    use HasFactory;

    protected $fillable = ['memorial_page_id', 'visitor_name', 'visitor_ip', 'lit_at'];

    protected function casts(): array
    {
        return ['lit_at' => 'datetime'];
    }
}
