<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'credit_cycle_id',
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
        'tracking_number',
        'pickup_image',
        'pickup_at',
        'cod_image',
        'cod_uploaded_at',
        'shipping_cost',
        'customer_notes',
        'user_read_status',
    ];

    protected $casts = [
        'shipping_cost' => 'float',
        'total_amount' => 'float',
        'user_read_status' => 'boolean',
        'pickup_at' => 'datetime',
        'cod_uploaded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creditCycle()
    {
        return $this->belongsTo(CreditCycle::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Mark this order as read by the customer.
     */
    public function markAsRead(): void
    {
        if (!$this->user_read_status) {
            $this->update(['user_read_status' => true]);
        }
    }

    /**
     * Thai status label for display.
     */
    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'รอตรวจสอบ',
            'confirmed' => 'ยืนยันแล้ว',
            'paid_wait_shipping' => 'เตรียมจัดส่ง',
            'shipped' => 'จัดส่งแล้ว',
            'completed' => 'สำเร็จ',
            'cancelled' => 'ยกเลิก',
            default => $this->status,
        };
    }

    /**
     * Payment method Thai label.
     */
    public function paymentLabel(): string
    {
        return match ($this->payment_method) {
            'promptpay' => 'โอนเงิน / PromptPay',
            'credit' => 'เครดิต',
            'cod' => 'เก็บเงินปลายทาง (COD)',
            'pickup' => 'รับหน้าร้าน',
            default => $this->payment_method ?? '-',
        };
    }

    /**
     * Full shipping address as a single string.
     */
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

    /**
     * Calculate the grand total including shipping.
     */
    public function grandTotal(): float
    {
        return $this->total_amount + ($this->shipping_cost ?? 0);
    }
}
