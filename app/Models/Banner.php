<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\MediaPath;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'image',
        'link',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function displayImage(): ?string
    {
        return $this->image ? MediaPath::normalize($this->image) : null;
    }
}
