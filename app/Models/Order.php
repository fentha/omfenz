<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'amount',
        'status',
        'ipaymu_session_id',
        'ipaymu_trx_id',
        'payment_url',
        'payment_method',
        'fee',
        'net_amount',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
    ];
}
