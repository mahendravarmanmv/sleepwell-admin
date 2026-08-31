<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Dealer extends Model
{
    protected $table = 'dealers';

    protected $fillable = [
        'dealer_name',
        'city',
        'is_verified',
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
        ];
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'dealer_product')
            ->withPivot('price')
            ->withTimestamps();
    }
}