@extends('layouts.admin')
@section('content')
<div class="header-actions">
    <h2>รายการสั่งซื้อทั้งหมด (Orders)</h2>
</div>
<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>รหัส Order</th>
                <th>วันที่สั่งซื้อ</th>
                <th>ลูกค้า</th>
                <th>จัดส่งถึง</th>
                <th>ยอดรวม</th>
                <th>วิธีชำระเงิน</th>
                <th>สถานะการจัดส่ง</th>
                <th>จัดการสถานะ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td style="font-weight:500;">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $order->user->name ?? 'Unknown' }}</td>
                <td style="min-width:220px;">
                    <div style="font-weight:600;">{{ $order->recipient_name ?: '-' }}</div>
                    @if($order->phone)
                        <div style="color:var(--text-muted); font-size:0.85rem;">{{ $order->phone }}</div>
                    @endif
                    @if($order->address_line)
                        <div style="color:var(--text-muted); font-size:0.82rem; margin-top:4px; line-height:1.55;">
                            {{ $order->address_line }}
                            @if($order->subdistrict || $order->district || $order->province || $order->postal_code)
                                <br>
                                {{ collect([$order->subdistrict, $order->district, $order->province, $order->postal_code])->filter()->implode(' ') }}
                            @endif
                        </div>
                    @endif
                </td>
                <td style="color:var(--primary-color);">฿{{ number_format($order->total_amount, 2) }}</td>
                <td>
                    @if($order->payment_method === 'credit' || $order->type == 'credit')
                        <span style="background:#3b82f615; color:#2563eb; padding:4px 8px; border-radius:4px; font-size:0.8rem;">เครดิต</span>
                    @else 
                        <span style="background:#f3f4f6; color:#4b5563; padding:4px 8px; border-radius:4px; font-size:0.8rem;">PromptPay / โอนเงิน</span>
                    @endif
                    @if($order->slip_image)
                        <div style="margin-top:6px;">
                            <a href="{{ route('media.show', ['path' => $order->slip_image]) }}" target="_blank" style="font-size:0.82rem; color:var(--primary-color); text-decoration:none;">
                                ดูสลิป
                            </a>
                        </div>
                    @endif
                </td>
                <td>
                    <!-- Status display logic -->
                    @if($order->status == 'pending') <span style="background:#f59e0b15; color:#d97706; padding:4px 8px; border-radius:4px; font-size:0.8rem;">รอตรวจสอบ</span>
                    @elseif($order->status == 'paid_wait_shipping') <span style="background:#3b82f615; color:#2563eb; padding:4px 8px; border-radius:4px; font-size:0.8rem;">เตรียมจัดส่ง</span>
                    @elseif($order->status == 'shipped') <span style="background:#22c55e15; color:#16a34a; padding:4px 8px; border-radius:4px; font-size:0.8rem;">จัดส่งสำเร็จ</span>
                    @else <span style="background:#fee2e2; color:#dc2626; padding:4px 8px; border-radius:4px; font-size:0.8rem;">ยกเลิก</span> @endif
                </td>
                <td>
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" style="display:flex; gap:5px;">
                        @csrf @method('PUT')
                        <select name="status" style="padding:6px; border-radius:4px; border:1px solid var(--border-color); font-size:0.8rem;">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>รอตรวจสอบ</option>
                            <option value="paid_wait_shipping" {{ $order->status == 'paid_wait_shipping' ? 'selected' : '' }}>เตรียมจัดส่ง</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>จัดส่งแล้ว</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>ยกเลิก</option>
                        </select>
                        <button type="submit" class="btn btn-primary" style="padding:6px 10px; font-size:0.8rem;">อัปเดต</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; padding:30px; color:var(--text-muted);">ยังไม่มีรายการออเดอร์</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
