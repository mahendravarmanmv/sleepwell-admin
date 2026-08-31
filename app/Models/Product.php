<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'badge_text',
        'badge_color',
        'title',
        'slug',
        'description',
        'key_features',
        'price',
        'emi_starting_price',
        'image_url',
        'stock_quantity',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'stock_quantity' => 'integer',
        'key_features' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function packages(): HasMany
    {
        return $this->hasMany(ProductPackage::class, 'product_id');
    }

    public function warranties(): HasMany
    {
        return $this->hasMany(ProductWarranty::class, 'product_id')
            ->orderBy('warranty_years');
    }

    public function galleryImages(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id')
            ->orderBy('sort_order', 'asc');
    }

    public function dealers(): BelongsToMany
    {
        return $this->belongsToMany(Dealer::class)
            ->withPivot('price')
            ->withTimestamps();
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}