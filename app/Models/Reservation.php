<?php

namespace App\Models;

use Database\Factories\ReservationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    /** @use HasFactory<ReservationFactory> */
    use HasFactory;

    protected $fillable = [
        'client_id',
        'cemetery_lot_id',
        'approved_by',
        'reservation_number',
        'applicant_name',
        'applicant_email',
        'applicant_phone',
        'requirements',
        'scheduled_at',
        'status',
        'approved_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'requirements' => 'array',
            'scheduled_at' => 'date',
            'approved_at' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function cemeteryLot(): BelongsTo
    {
        return $this->belongsTo(CemeteryLot::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
