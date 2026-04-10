<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'description',
        'image',
        'images',
        'retail_price',
        'wholesale_price',
        'wholesale_min_qty',
        'stock',
        'sort_order',
    ];

    protected $casts = [
        'images' => 'array',
        'wholesale_min_qty' => 'integer',
        'stock' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function galleryImages(): array
    {
        $images = collect((array) $this->images)
            ->filter()
            ->values();

        if ($images->isEmpty() && !empty($this->image)) {
            $images->push($this->image);
        }

        return $images->unique()->values()->all();
    }

    public function displayImage(): ?string
    {
        return $this->galleryImages()[0] ?? null;
    }

    public function wholesaleBundlePrice(): float
    {
        return (float) $this->wholesale_price;
    }

    public function wholesaleMinQty(): int
    {
        return max(1, (int) ($this->wholesale_min_qty ?: 1));
    }

    public function wholesaleUnitPrice(): float
    {
        $minQty = $this->wholesaleMinQty();

        return $minQty > 0 ? $this->wholesaleBundlePrice() / $minQty : $this->wholesaleBundlePrice();
    }
}
