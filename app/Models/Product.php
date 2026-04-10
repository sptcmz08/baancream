<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Support\MediaPath;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'description',
        'retail_price',
        'wholesale_price',
        'image',
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
        return (float) $this->retail_price;
    }

    public function displayWholesalePrice(): float
    {
        return (float) $this->wholesale_price;
    }

    public function displayWholesaleBundlePrice(): float
    {
        return $this->displayWholesalePrice();
    }

    public function displayWholesaleMinQty(): int
    {
        return max(1, (int) ($this->wholesale_min_qty ?? 1));
    }

    public function displayWholesaleUnitPrice(): float
    {
        $minQty = $this->displayWholesaleMinQty();

        return $minQty > 0 ? $this->displayWholesaleBundlePrice() / $minQty : $this->displayWholesaleBundlePrice();
    }

    public function galleryImages(): array
    {
        $images = collect((array) $this->images)
            ->map(fn ($path) => MediaPath::normalize($path))
            ->filter()
            ->values();

        if ($images->isEmpty() && !empty($this->image)) {
            $images->push(MediaPath::normalize($this->image));
        }

        return $images->unique()->values()->all();
    }

    public function displayImage(): ?string
    {
        return $this->galleryImages()[0] ?? null;
    }
}
