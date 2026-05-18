<?php

namespace App\Models;

use Database\Factories\CollectorAssignmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectorAssignment extends Model
{
    /** @use HasFactory<CollectorAssignmentFactory> */
    use HasFactory;

    protected $fillable = ['collector_id', 'client_id', 'assigned_date', 'status', 'notes'];

    protected function casts(): array
    {
        return ['assigned_date' => 'date'];
    }

    public function collector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
