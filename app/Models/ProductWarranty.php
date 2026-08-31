<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductWarranty extends Model
{
    protected $table = 'product_warranties';

    protected $fillable = [
        'product_id',
        'warranty_years',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'warranty_years' => 'integer',
            'price' => 'decimal:2',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}