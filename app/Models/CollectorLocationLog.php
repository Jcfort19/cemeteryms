<?php

namespace App\Models;

use Database\Factories\CollectorLocationLogFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectorLocationLog extends Model
{
    /** @use HasFactory<CollectorLocationLogFactory> */
    use HasFactory;

    protected $fillable = ['collector_id', 'latitude', 'longitude', 'accuracy', 'recorded_at'];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'accuracy' => 'decimal:2',
            'recorded_at' => 'datetime',
        ];
    }
}
