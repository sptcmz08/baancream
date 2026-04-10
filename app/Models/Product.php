<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'description',
        'retail_price',
        'wholesale_price',
        'stock',
        'wholesale_min_qty',
        'images',
        'is_new_arrival',
    ];

    protected $casts = [
        'is_new_arrival' => 'boolean',
        'images' => 'array',
        'wholesale_min_qty' => 'integer',
        'stock' => 'integer',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
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
        if ($this->hasVariants() && $this->defaultVariant()->image) {
            return $this->defaultVariant()->image;
        }

        if (is_array($this->images) && count($this->images) > 0) {
            return $this->images[0];
        }

        return null;
    }
}
