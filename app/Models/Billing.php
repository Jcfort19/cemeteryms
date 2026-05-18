<?php

namespace App\Models;

use Database\Factories\BillingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Billing extends Model
{
    /** @use HasFactory<BillingFactory> */
    use HasFactory;

    protected $fillable = [
        'client_id',
        'cemetery_lot_id',
        'billing_number',
        'type',
        'description',
        'amount',
        'paid_amount',
        'balance',
        'due_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'balance' => 'decimal:2',
            'due_date' => 'date',
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

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
