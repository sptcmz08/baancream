<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Support\MediaPath;

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
