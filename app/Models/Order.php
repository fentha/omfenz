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
    ];
}
