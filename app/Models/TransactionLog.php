<?php

namespace App\Models;

use Database\Factories\TransactionLogFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    /** @use HasFactory<TransactionLogFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'client_id', 'billing_id', 'payment_id', 'type', 'reference', 'amount', 'payload'];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'payload' => 'array',
        ];
    }
}
