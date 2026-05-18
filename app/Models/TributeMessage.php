<?php

namespace App\Models;

use Database\Factories\TributeMessageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TributeMessage extends Model
{
    /** @use HasFactory<TributeMessageFactory> */
    use HasFactory;

    protected $fillable = ['memorial_page_id', 'author_name', 'author_email', 'message', 'status', 'approved_at'];

    protected function casts(): array
    {
        return ['approved_at' => 'datetime'];
    }
}
