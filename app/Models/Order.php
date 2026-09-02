<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'subtotal',
        'gst_amount',
        'delivery_charge',
        'installation_charges',
        'discount_amount',
        'total_amount',
        'payment_method',
        'payment_status',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'gst_amount' => 'decimal:2',
        'delivery_charge' => 'decimal:2',
        'installation_charges' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function address(): HasOne
    {
        return $this->hasOne(OrderAddress::class, 'order_id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(OrderPayment::class, 'order_id');
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class, 'order_id')
            ->latest('id');
    }

    public function notificationLogs(): HasMany
    {
        return $this->hasMany(OrderNotificationLog::class, 'order_id')
            ->latest('id');
    }
}