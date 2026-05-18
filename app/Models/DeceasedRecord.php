<?php

namespace App\Models;

use Database\Factories\DeceasedRecordFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DeceasedRecord extends Model
{
    /** @use HasFactory<DeceasedRecordFactory> */
    use HasFactory;

    protected $fillable = [
        'client_id',
        'cemetery_lot_id',
        'first_name',
        'middle_name',
        'last_name',
        'birth_date',
        'death_date',
        'interment_date',
        'burial_permit_number',
        'biography',
        'privacy',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'death_date' => 'date',
            'interment_date' => 'date',
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

    public function memorialPage(): HasOne
    {
        return $this->hasOne(MemorialPage::class);
    }
}
