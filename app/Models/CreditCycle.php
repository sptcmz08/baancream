<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CreditCycle extends Model
{
    protected $fillable = [
        'user_id',
        'month',
        'year',
        'due_date',
        'credit_limit',
        'spent_amount',
        'status',
        'payment_slip',
        'payment_note',
        'payment_submitted_at',
        'paid_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'credit_limit' => 'float',
        'spent_amount' => 'float',
        'payment_submitted_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('status', '!=', 'paid');
    }

    public static function activeForUser(int $userId): ?self
    {
        return static::query()
            ->where('user_id', $userId)
            ->open()
            ->orderBy('year')
            ->orderBy('month')
            ->orderBy('id')
            ->first();
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function recalculateSpentAmount(): void
    {
        $this->forceFill([
            'spent_amount' => (float) $this->orders()->sum('total_amount'),
        ])->save();
    }

    public function productTotal(): float
    {
        return (float) $this->orders
            ->sum(fn (Order $order) => max(0, (float) $order->total_amount - (float) ($order->shipping_cost ?? 0)));
    }

    public function shippingTotal(): float
    {
        return (float) $this->orders->sum(fn (Order $order) => (float) ($order->shipping_cost ?? 0));
    }

    public function totalAmount(): float
    {
        return (float) $this->orders->sum(fn (Order $order) => (float) $order->total_amount);
    }
}
