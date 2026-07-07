<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'midtrans_transaction_id',
        'midtrans_transaction_status',
        'payment_type',
        'raw_response',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'raw_response' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
