<?php

namespace App\Models;

use Database\Factories\MemorialPageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MemorialPage extends Model
{
    /** @use HasFactory<MemorialPageFactory> */
    use HasFactory;

    protected $fillable = ['deceased_record_id', 'slug', 'title', 'biography', 'privacy', 'is_published', 'published_at'];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function deceasedRecord(): BelongsTo
    {
        return $this->belongsTo(DeceasedRecord::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(MemorialPhoto::class);
    }

    public function tributes(): HasMany
    {
        return $this->hasMany(TributeMessage::class);
    }

    public function candles(): HasMany
    {
        return $this->hasMany(VirtualCandle::class);
    }
}
