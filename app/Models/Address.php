<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'label',
        'recipient_name',
        'phone',
        'address_line',
        'subdistrict',
        'district',
        'province',
        'postal_code',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark this address as primary and un-primary all others for the same user.
     */
    public function markAsPrimary(): void
    {
        self::where('user_id', $this->user_id)->update(['is_primary' => false]);
        $this->update(['is_primary' => true]);
    }

    public function fullAddress(): string
    {
        return collect([
            $this->address_line,
            $this->subdistrict,
            $this->district,
            $this->province,
            $this->postal_code,
        ])->filter()->implode(' ');
    }
}
