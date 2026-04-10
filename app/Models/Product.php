<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'description',
        'retail_price',
        'wholesale_price',
        'image',
        'category_id',
        'brand_id',
        'is_new_arrival',
    ];

    protected $casts = [
        'is_new_arrival' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->orderBy('sort_order')->orderBy('id');
    }

    public function defaultVariant(): ?ProductVariant
    {
        return $this->variants->first();
    }

    public function hasVariants(): bool
    {
        return $this->variants->isNotEmpty();
    }

    public function displayRetailPrice(): float
    {
        $variant = $this->defaultVariant();

        return $variant ? (float) $variant->retail_price : (float) $this->retail_price;
    }

    public function displayWholesalePrice(): float
    {
        $variant = $this->defaultVariant();

        return $variant ? (float) $variant->wholesale_price : (float) $this->wholesale_price;
    }

    public function displayImage(): ?string
    {
        return optional($this->defaultVariant())->image ?: $this->image;
    }
}
