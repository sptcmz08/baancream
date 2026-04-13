@extends('layouts.admin')
@section('content')
<div class="header-actions">
    <h2>รายการสั่งซื้อทั้งหมด (Orders)</h2>
</div>

{{-- Payment Method Tabs --}}
<div style="display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap;">
    @php
        $tabs = [
            'all' => ['label' => 'ทั้งหมด', 'icon' => '📋'],
            'transfer' => ['label' => 'โอนเงิน', 'icon' => '💳'],
            'cod' => ['label' => 'COD', 'icon' => '📦'],
            'pickup' => ['label' => 'รับหน้าร้าน', 'icon' => '🏪'],
            'credit' => ['label' => 'เครดิต', 'icon' => '💰'],
        ];
    @endphp
    @foreach($tabs as $key => $t)
        <a href="{{ route('admin.orders.index', ['tab' => $key]) }}"
           style="display:inline-flex; align-items:center; gap:6px; padding:10px 18px; border-radius:10px; font-size:0.9rem; font-weight:500; text-decoration:none; transition:all 0.2s;
                  {{ $tab === $key ? 'background:var(--primary-color); color:white; box-shadow:0 4px 12px rgba(204,163,94,0.3);' : 'background:var(--surface-color); color:var(--text-dark); border:1px solid var(--border-color);' }}">
            <span>{{ $t['icon'] }}</span>
            <span>{{ $t['label'] }}</span>
            <span style="background:{{ $tab === $key ? 'rgba(255,255,255,0.25)' : '#f3f4f6' }}; padding:2px 8px; border-radius:99px; font-size:0.78rem;">{{ $counts[$key] ?? 0 }}</span>
        </a>
    @endforeach
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
                <th>สถานะ</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}" style="font-weight:600; color:var(--primary-color); text-decoration:none;">
                        #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                    </a>
                </td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $order->user->name ?? 'Unknown' }}</td>
                <td style="min-width:200px;">
                    <div style="font-weight:600;">{{ $order->recipient_name ?: '-' }}</div>
                    @if($order->phone)
                        <div style="color:var(--text-muted); font-size:0.85rem;">{{ $order->phone }}</div>
                    @endif
                    @if($order->address_line)
                        <div style="color:var(--text-muted); font-size:0.82rem; margin-top:4px; line-height:1.55;">
                            {{ Str::limit($order->fullAddress(), 80) }}
                        </div>
                    @endif
                </td>
                <td style="color:var(--primary-color); font-weight:600;">฿{{ number_format($order->total_amount, 2) }}</td>
                <td>
                    @if($order->payment_method === 'credit' || $order->type == 'credit')
                        <span style="background:#3b82f615; color:#2563eb; padding:4px 10px; border-radius:6px; font-size:0.8rem; font-weight:500;">💰 เครดิต</span>
                    @elseif($order->payment_method === 'cod')
                        <span style="background:#f59e0b15; color:#d97706; padding:4px 10px; border-radius:6px; font-size:0.8rem; font-weight:500;">📦 COD</span>
                    @elseif($order->payment_method === 'pickup')
                        <span style="background:#10b98115; color:#059669; padding:4px 10px; border-radius:6px; font-size:0.8rem; font-weight:500;">🏪 รับหน้าร้าน</span>
                    @else
                        <span style="background:#f3f4f6; color:#4b5563; padding:4px 10px; border-radius:6px; font-size:0.8rem; font-weight:500;">💳 โอนเงิน</span>
                    @endif
                    @if($order->slip_image)
                        <div style="margin-top:6px;">
                            <a href="{{ route('media.show', ['path' => $order->slip_image]) }}" target="_blank" style="font-size:0.82rem; color:var(--primary-color); text-decoration:none;">
                                📄 ดูสลิป
                            </a>
                        </div>
                    @endif
                </td>
                <td>
                    @php
                        $statusStyles = [
                            'pending' => 'background:#f59e0b15; color:#d97706;',
                            'confirmed' => 'background:#06b6d415; color:#0891b2;',
                            'paid_wait_shipping' => 'background:#3b82f615; color:#2563eb;',
                            'shipped' => 'background:#22c55e15; color:#16a34a;',
                            'completed' => 'background:#10b98115; color:#059669;',
                            'cancelled' => 'background:#fee2e2; color:#dc2626;',
                        ];
                        $statusLabels = [
                            'pending' => 'รอตรวจสอบ',
                            'confirmed' => 'ยืนยันแล้ว',
                            'paid_wait_shipping' => 'เตรียมจัดส่ง',
                            'shipped' => 'จัดส่งแล้ว',
                            'completed' => 'สำเร็จ',
                            'cancelled' => 'ยกเลิก',
                        ];
                    @endphp
                    <span style="{{ $statusStyles[$order->status] ?? '' }} padding:4px 10px; border-radius:6px; font-size:0.8rem; font-weight:500;">
                        {{ $statusLabels[$order->status] ?? $order->status }}
                    </span>
                    @if($order->tracking_number)
                        <div style="margin-top:4px; font-size:0.78rem; color:var(--text-muted);">
                            🚚 {{ $order->tracking_number }}
                        </div>
                    @endif
                </td>
                <td>
                    <div style="display:flex; gap:5px; flex-wrap:wrap;">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-primary" style="padding:6px 12px; font-size:0.8rem;">ดูรายละเอียด</a>
                        @if($order->status === 'pending')
                            <form action="{{ route('admin.orders.quick-action', $order) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="action" value="confirm">
                                <button type="submit" style="padding:6px 10px; font-size:0.78rem; background:#22c55e; color:white; border:none; border-radius:6px; cursor:pointer;">✓ ยืนยัน</button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; padding:30px; color:var(--text-muted);">ยังไม่มีรายการออเดอร์</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $orders->links('vendor.pagination.admin') }}
</div>
@endsection
