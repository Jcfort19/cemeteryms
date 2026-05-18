<?php

namespace App\Models;

use Database\Factories\VisitorLogFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitorLog extends Model
{
    /** @use HasFactory<VisitorLogFactory> */
    use HasFactory;

    protected $fillable = [
        'client_id',
        'cemetery_lot_id',
        'logged_by',
        'visitor_name',
        'visitor_phone',
        'purpose',
        'entered_at',
        'exited_at',
        'verification_snapshot',
    ];

    protected function casts(): array
    {
        return [
            'entered_at' => 'datetime',
            'exited_at' => 'datetime',
            'verification_snapshot' => 'array',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function lot(): BelongsTo
    {
        return $this->belongsTo(CemeteryLot::class, 'cemetery_lot_id');
    }

    public function guard(): BelongsTo
    {
        return $this->belongsTo(User::class, 'logged_by');
    }
}
