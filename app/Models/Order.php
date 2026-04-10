<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'type',
        'payment_method',
        'status',
        'slip_image',
        'recipient_name',
        'phone',
        'address_line',
        'subdistrict',
        'district',
        'province',
        'postal_code',
        'order_note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
