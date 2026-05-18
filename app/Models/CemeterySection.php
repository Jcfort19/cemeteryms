<?php

namespace App\Models;

use Database\Factories\CemeterySectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CemeterySection extends Model
{
    /** @use HasFactory<CemeterySectionFactory> */
    use HasFactory;

    protected $fillable = ['code', 'name', 'description', 'boundary_polygon', 'color', 'is_active'];

    protected function casts(): array
    {
        return [
            'boundary_polygon' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function lots(): HasMany
    {
        return $this->hasMany(CemeteryLot::class);
    }
}
