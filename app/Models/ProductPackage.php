<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPackage extends Model
{
    protected $table = 'product_packages';

    protected $fillable = [
        'product_id',
        'package_name',
        'price',
        'emi_starting_price',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'emi_starting_price' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}