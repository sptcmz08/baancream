@extends('layouts.admin')
@section('content')
<div class="header-actions">
    <div>
        <h2>รายละเอียดออเดอร์ #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h2>
        <div style="color:var(--text-muted); font-size:0.88rem; margin-top:4px;">สั่งเมื่อ {{ $order->created_at->format('d/m/Y H:i น.') }}</div>
    </div>
    <a href="{{ route('admin.orders.index') }}" style="color:var(--text-muted); text-decoration:none;">← กลับรายการ</a>
</div>

<div style="display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:start;">
    {{-- Main Column --}}
    <div style="display:grid; gap:20px;">
        {{-- Quick Action Buttons --}}
        <div class="card" style="padding:18px 20px;">
            <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                <span style="font-weight:600; margin-right:8px;">สถานะปัจจุบัน:</span>
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
                <span style="{{ $statusStyles[$order->status] ?? '' }} padding:6px 14px; border-radius:8px; font-size:0.88rem; font-weight:600;">
                    {{ $statusLabels[$order->status] ?? $order->status }}
                </span>

                <div style="flex:1;"></div>

                @if($order->status === 'pending')
                    <form action="{{ route('admin.orders.quick-action', $order) }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="action" value="confirm">
                        <button type="submit" class="btn" style="background:#22c55e; color:white; padding:8px 16px; font-size:0.85rem;">✓ ยืนยันออเดอร์</button>
                    </form>
                    <form action="{{ route('admin.orders.quick-action', $order) }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="action" value="reject">
                        <button type="submit" class="btn" style="background:#ef4444; color:white; padding:8px 16px; font-size:0.85rem;" onclick="return confirm('ยืนยันยกเลิกออเดอร์?')">✕ ยกเลิก</button>
                    </form>
                @endif

                @if(in_array($order->status, ['confirmed', 'paid_wait_shipping']))
                    <form action="{{ route('admin.orders.quick-action', $order) }}" method="POST" style="display:inline-flex; gap:6px; align-items:center;">
                        @csrf
                        <input type="hidden" name="action" value="ship">
                        <input type="text" name="tracking_number" placeholder="เลขพัสดุ (ถ้ามี)" value="{{ $order->tracking_number }}" style="padding:8px 12px; border:1px solid var(--border-color); border-radius:8px; font-size:0.85rem; width:180px;">
                        <button type="submit" class="btn" style="background:#8b5cf6; color:white; padding:8px 16px; font-size:0.85rem;">🚚 จัดส่ง</button>
                    </form>
                @endif

                @if($order->status === 'shipped')
                    <form action="{{ route('admin.orders.quick-action', $order) }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="action" value="complete">
                        <button type="submit" class="btn" style="background:#10b981; color:white; padding:8px 16px; font-size:0.85rem;">✅ สำเร็จ</button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Order Items --}}
        <div class="card">
            <h3 style="margin-bottom:16px; font-weight:600;">รายการสินค้า</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:50px;"></th>
                        <th>สินค้า</th>
                        <th>จำนวน</th>
                        <th>ราคา/ชิ้น</th>
                        <th>รวม</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            @if($item->product?->displayImage())
                                <img src="{{ route('media.show', ['path' => $item->product->displayImage()]) }}" style="width:44px; height:44px; border-radius:8px; object-fit:cover;">
                            @else
                                <div style="width:44px; height:44px; border-radius:8px; background:#f3f4f6;"></div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:600;">{{ $item->product?->name ?? 'สินค้าถูกลบ' }}</div>
                            @if($item->variant_name)
                                <div style="color:var(--text-muted); font-size:0.82rem;">ตัวเลือก: {{ $item->variant_name }}</div>
                            @endif
                            @if($item->items_per_set > 1)
                                <div style="color:var(--text-muted); font-size:0.78rem;">ชุดละ {{ $item->items_per_set }} ชิ้น</div>
                            @endif
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>฿{{ number_format($item->price_per_unit, 2) }}</td>
                        <td style="font-weight:600;">฿{{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top:16px; padding-top:16px; border-top:2px solid var(--border-color);">
                <div style="display:flex; justify-content:space-between; padding:6px 0; font-size:0.92rem;">
                    <span>ค่าสินค้า</span>
                    <span>฿{{ number_format($order->total_amount - $order->shipping_cost, 2) }}</span>
                </div>
                @if($order->shipping_cost > 0)
                <div style="display:flex; justify-content:space-between; padding:6px 0; font-size:0.92rem;">
                    <span>ค่าจัดส่ง</span>
                    <span>฿{{ number_format($order->shipping_cost, 2) }}</span>
                </div>
                @endif
                <div style="display:flex; justify-content:space-between; padding:10px 0; font-size:1.1rem; font-weight:700; border-top:2px solid var(--border-color); margin-top:6px;">
                    <span>ยอดรวมทั้งหมด</span>
                    <span style="color:var(--primary-color);">฿{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Upload Verification Images --}}
        <div class="card">
            <h3 style="margin-bottom:16px; font-weight:600;">หลักฐานยืนยัน / อัปโหลดรูป</h3>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    {{-- Slip Image --}}
                    <div>
                        <label style="font-weight:500; display:block; margin-bottom:8px;">สลิปโอนเงิน</label>
                        @if($order->slip_image)
                            <a href="{{ route('media.show', ['path' => $order->slip_image]) }}" target="_blank">
                                <img src="{{ route('media.show', ['path' => $order->slip_image]) }}" style="width:100%; max-height:200px; object-fit:contain; border-radius:10px; border:1px solid var(--border-color);">
                            </a>
                        @else
                            <div style="padding:30px; text-align:center; background:#f9fafb; border-radius:10px; border:1px dashed var(--border-color); color:var(--text-muted); font-size:0.85rem;">ไม่มีสลิป</div>
                        @endif
                    </div>

                    {{-- Pickup Image --}}
                    <div>
                        <label style="font-weight:500; display:block; margin-bottom:8px;">รูปรับสินค้า / COD</label>
                        @if($order->pickup_image)
                            <a href="{{ route('media.show', ['path' => $order->pickup_image]) }}" target="_blank">
                                <img src="{{ route('media.show', ['path' => $order->pickup_image]) }}" style="width:100%; max-height:200px; object-fit:contain; border-radius:10px; border:1px solid var(--border-color);">
                            </a>
                            <div style="color:var(--text-muted); font-size:0.78rem; margin-top:4px;">อัปโหลดเมื่อ {{ $order->pickup_at?->format('d/m/Y H:i') }}</div>
                        @endif
                        <input type="file" name="pickup_image" accept="image/*" style="margin-top:8px; font-size:0.85rem;">
                    </div>

                    {{-- COD Image --}}
                    @if($order->payment_method === 'cod')
                    <div>
                        <label style="font-weight:500; display:block; margin-bottom:8px;">รูปกล่อง COD</label>
                        @if($order->cod_image)
                            <a href="{{ route('media.show', ['path' => $order->cod_image]) }}" target="_blank">
                                <img src="{{ route('media.show', ['path' => $order->cod_image]) }}" style="width:100%; max-height:200px; object-fit:contain; border-radius:10px; border:1px solid var(--border-color);">
                            </a>
                            <div style="color:var(--text-muted); font-size:0.78rem; margin-top:4px;">อัปโหลดเมื่อ {{ $order->cod_uploaded_at?->format('d/m/Y H:i') }}</div>
                        @endif
                        <input type="file" name="cod_image" accept="image/*" style="margin-top:8px; font-size:0.85rem;">
                    </div>
                    @endif
                </div>

                {{-- Edit fields --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-top:20px; padding-top:16px; border-top:1px solid var(--border-color);">
                    <div>
                        <label style="font-weight:500; display:block; margin-bottom:6px;">เลขพัสดุ</label>
                        <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" placeholder="กรอกเลขพัสดุ" style="width:100%; padding:10px 14px; border:1px solid var(--border-color); border-radius:8px; font-family:'Prompt';">
                    </div>
                    <div>
                        <label style="font-weight:500; display:block; margin-bottom:6px;">ค่าจัดส่ง (฿)</label>
                        <input type="number" name="shipping_cost" value="{{ $order->shipping_cost }}" step="0.01" style="width:100%; padding:10px 14px; border:1px solid var(--border-color); border-radius:8px; font-family:'Prompt';">
                        @if($order->payment_method === 'credit' || $order->type === 'credit')
                            <div style="margin-top:6px; color:var(--text-muted); font-size:0.8rem;">แก้ค่าส่งแล้วระบบจะปรับยอดเครดิตตามส่วนต่างให้อัตโนมัติ</div>
                        @endif
                    </div>
                    <div style="grid-column:1/-1;">
                        <label style="font-weight:500; display:block; margin-bottom:6px;">หมายเหตุจากแอดมิน</label>
                        <textarea name="customer_notes" rows="3" style="width:100%; padding:10px 14px; border:1px solid var(--border-color); border-radius:8px; font-family:'Prompt'; resize:vertical;" placeholder="หมายเหตุเพิ่มเติม...">{{ $order->customer_notes }}</textarea>
                    </div>
                </div>

                <div style="margin-top:16px; display:flex; justify-content:flex-end;">
                    <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Right Sidebar --}}
    <div style="display:grid; gap:20px;">
        {{-- Customer Info --}}
        <div class="card">
            <h4 style="margin-bottom:14px; font-weight:600;">ข้อมูลลูกค้า</h4>
            <div style="display:grid; gap:10px; font-size:0.9rem;">
                <div>
                    <div style="color:var(--text-muted); font-size:0.8rem;">ชื่อผู้สั่ง</div>
                    <div style="font-weight:500;">{{ $order->user->name ?? '-' }}</div>
                </div>
                <div>
                    <div style="color:var(--text-muted); font-size:0.8rem;">อีเมล</div>
                    <div>{{ $order->user->email ?? '-' }}</div>
                </div>
                <div>
                    <div style="color:var(--text-muted); font-size:0.8rem;">บทบาท</div>
                    <div>{{ $order->user->role ?? '-' }}</div>
                </div>
            </div>
        </div>

        {{-- Shipping Info --}}
        <div class="card">
            <h4 style="margin-bottom:14px; font-weight:600;">ข้อมูลจัดส่ง</h4>
            <div style="display:grid; gap:10px; font-size:0.9rem;">
                <div>
                    <div style="color:var(--text-muted); font-size:0.8rem;">ผู้รับ</div>
                    <div style="font-weight:500;">{{ $order->recipient_name ?: '-' }}</div>
                </div>
                <div>
                    <div style="color:var(--text-muted); font-size:0.8rem;">โทรศัพท์</div>
                    <div>{{ $order->phone ?: '-' }}</div>
                </div>
                <div>
                    <div style="color:var(--text-muted); font-size:0.8rem;">ที่อยู่</div>
                    <div style="line-height:1.6;">{{ $order->fullAddress() ?: '-' }}</div>
                </div>
                @if($order->tracking_number)
                <div>
                    <div style="color:var(--text-muted); font-size:0.8rem;">เลขพัสดุ</div>
                    <div style="font-weight:600; color:var(--primary-color);">{{ $order->tracking_number }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Payment Info --}}
        <div class="card">
            <h4 style="margin-bottom:14px; font-weight:600;">การชำระเงิน</h4>
            <div style="display:grid; gap:10px; font-size:0.9rem;">
                <div>
                    <div style="color:var(--text-muted); font-size:0.8rem;">วิธีชำระเงิน</div>
                    <div style="font-weight:500;">{{ $order->paymentLabel() }}</div>
                </div>
                <div>
                    <div style="color:var(--text-muted); font-size:0.8rem;">ประเภทออเดอร์</div>
                    <div>{{ $order->type === 'credit' ? 'เครดิต' : 'ปกติ' }}</div>
                </div>
            </div>
        </div>

        {{-- Order Note --}}
        @if($order->order_note)
        <div class="card">
            <h4 style="margin-bottom:14px; font-weight:600;">หมายเหตุจากลูกค้า</h4>
            <div style="font-size:0.9rem; line-height:1.7; color:var(--text-dark); background:#f9fafb; padding:12px; border-radius:8px;">
                {{ $order->order_note }}
            </div>
        </div>
        @endif

        {{-- Delete --}}
        <div class="card" style="border-color:#fee2e2;">
            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('ยืนยันลบออเดอร์นี้?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn" style="background:#fee2e2; color:#dc2626; width:100%; font-size:0.85rem;">🗑 ลบออเดอร์</button>
            </form>
        </div>
    </div>
</div>
@endsection
