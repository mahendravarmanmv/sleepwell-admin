<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderAddress extends Model
{
    protected $table = 'order_addresses';

    protected $fillable = [
        'order_id',
        'name',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'pincode',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}