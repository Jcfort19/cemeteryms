<?php

namespace App\Models;

use Database\Factories\ClientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    /** @use HasFactory<ClientFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_number',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'address',
        'qr_token',
        'qr_issued_at',
        'portal_enabled',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'qr_issued_at' => 'datetime',
            'portal_enabled' => 'boolean',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return trim(collect([$this->first_name, $this->middle_name, $this->last_name])->filter()->implode(' '));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lots(): HasMany
    {
        return $this->hasMany(CemeteryLot::class);
    }

    public function deceasedRecords(): HasMany
    {
        return $this->hasMany(DeceasedRecord::class);
    }

    public function billings(): HasMany
    {
        return $this->hasMany(Billing::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function collectorAssignments(): HasMany
    {
        return $this->hasMany(CollectorAssignment::class);
    }
}
