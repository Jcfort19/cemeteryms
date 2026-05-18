<?php

namespace App\Models;

use Database\Factories\MemorialPhotoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemorialPhoto extends Model
{
    /** @use HasFactory<MemorialPhotoFactory> */
    use HasFactory;

    protected $fillable = ['memorial_page_id', 'path', 'caption', 'sort_order'];
}
