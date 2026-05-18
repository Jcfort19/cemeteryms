<?php

namespace App\Models;

use Database\Factories\CemeteryLotFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CemeteryLot extends Model
{
    /** @use HasFactory<CemeteryLotFactory> */
    use HasFactory;

    protected $fillable = [
        'cemetery_section_id',
        'client_id',
        'lot_number',
        'block',
        'area_sqm',
        'price',
        'status',
        'polygon',
        'latitude',
        'longitude',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'polygon' => 'array',
            'area_sqm' => 'decimal:2',
            'price' => 'decimal:2',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(CemeterySection::class, 'cemetery_section_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function billings(): HasMany
    {
        return $this->hasMany(Billing::class);
    }

    public function deceasedRecords(): HasMany
    {
        return $this->hasMany(DeceasedRecord::class);
    }
}
