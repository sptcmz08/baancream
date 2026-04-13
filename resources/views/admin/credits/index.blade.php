@extends('layouts.admin')

@section('styles')
<style>
    .credit-layout {
        display: grid;
        grid-template-columns: minmax(280px, 420px) 1fr;
        gap: 20px;
        align-items: start;
    }
    .credit-form-grid,
    .credit-edit-grid {
        display: grid;
        gap: 12px;
    }
    .credit-form-grid label,
    .credit-edit-grid label {
        display: block;
        margin-bottom: 7px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .credit-form-grid input,
    .credit-form-grid select,
    .credit-edit-grid input,
    .credit-edit-grid select,
    .credit-edit-grid textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-family: 'Prompt';
        background: white;
    }
    .credit-card {
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 16px;
        margin-top: 14px;
        background: white;
    }
    .credit-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        flex-wrap: wrap;
    }
    .credit-title {
        font-weight: 700;
        font-size: 1.05rem;
    }
    .credit-sub {
        color: var(--text-muted);
        font-size: 0.86rem;
        margin-top: 4px;
    }
    .credit-status {
        border-radius: 999px;
        padding: 5px 12px;
        font-size: 0.8rem;
        font-weight: 700;
    }
    .credit-status.paid {
        background: #dcfce7;
        color: #15803d;
    }
    .credit-status.pending {
        background: #fff7ed;
        color: #c2410c;
    }
    .credit-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(120px, 1fr));
        gap: 10px;
        margin: 14px 0;
    }
    .credit-stat {
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 12px;
        background: #fbfcff;
    }
    .credit-stat-label {
        color: var(--text-muted);
        font-size: 0.78rem;
        margin-bottom: 4px;
    }
    .credit-stat-value {
        font-weight: 800;
        color: var(--text-dark);
    }
    .credit-orders {
        display: grid;
        gap: 10px;
        margin-top: 12px;
    }
    .credit-order {
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 12px;
        background: #fafafa;
    }
    .credit-item {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 8px 0;
        border-top: 1px solid #edf0f5;
        font-size: 0.88rem;
    }
    .credit-item:first-of-type {
        border-top: none;
    }
    .credit-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
        margin-top: 12px;
    }
    .credit-split {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    @media (max-width: 900px) {
        .credit-layout {
            grid-template-columns: 1fr;
        }
        .credit-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .credit-split {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 560px) {
        .credit-stats {
            grid-template-columns: 1fr;
        }
        .credit-item {
            display: grid;
        }
    }
</style>
@endsection

@section('content')
<div class="header-actions">
    <div>
        <h2>ระบบเครดิต / รอบชำระ</h2>
        <p style="margin-top:8px; color:var(--text-muted);">ตั้งรอบเครดิต กำหนดวันครบกำหนด และตรวจสลิปปิดรอบบิล</p>
    </div>
</div>

<div class="credit-layout">
    <div class="card">
        <h3>+ เปิดรอบเครดิต</h3>
        <p style="color:var(--text-muted); font-size:0.86rem; margin:8px 0 16px; line-height:1.7;">
            หากมีรอบเดิมที่ยังไม่ปิด ระบบสั่งซื้อจะยังรวมยอดเข้ารอบเดิมก่อน แม้จะสร้างรอบเดือนถัดไปไว้ล่วงหน้าแล้ว
        </p>

        <form action="{{ route('admin.credits.store') }}" method="POST" class="credit-form-grid">
            @csrf
            <div>
                <label>เลือกลูกค้า</label>
                <select name="user_id" required>
                    <option value="">-- เลือกลูกค้า --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->role === 'vip' ? 'VIP' : 'User' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>ประเภทลูกค้าเครดิต</label>
                <select name="member_role" required>
                    <option value="customer" {{ old('member_role') === 'customer' ? 'selected' : '' }}>ลูกค้าธรรมดา</option>
                    <option value="vip" {{ old('member_role') === 'vip' ? 'selected' : '' }}>VIP</option>
                </select>
            </div>

            <div class="credit-split">
                <div>
                    <label>รอบเดือน</label>
                    <select name="month" required>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ (int) old('month', date('n')) === $i ? 'selected' : '' }}>เดือน {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label>ปี ค.ศ.</label>
                    <input type="number" name="year" value="{{ old('year', date('Y')) }}" required>
                </div>
            </div>

            <div>
                <label>กำหนดชำระ</label>
                <input type="date" name="due_date" value="{{ old('due_date', now()->endOfMonth()->toDateString()) }}" required>
            </div>

            <div>
                <label>วงเงินอนุมัติ (บาท)</label>
                <input type="number" name="credit_limit" step="0.01" value="{{ old('credit_limit') }}" placeholder="เว้นว่าง = ไม่จำกัด / VIP">
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">บันทึกรอบเครดิต</button>
        </form>
    </div>

    <div class="card">
        <h3>รายการรอบเครดิต</h3>

        @forelse($credits as $credit)
            @php
                $orders = $credit->orders;
                $productTotal = $credit->productTotal();
                $shippingTotal = $credit->shippingTotal();
                $grandTotal = $credit->totalAmount();
            @endphp

            <div class="credit-card">
                <div class="credit-head">
                    <div>
                        <div class="credit-title">{{ $credit->user->name ?? 'Unknown' }} - รอบ {{ $credit->month }}/{{ $credit->year }}</div>
                        <div class="credit-sub">
                            ประเภท {{ $credit->user?->role === 'vip' ? 'VIP' : 'ลูกค้าธรรมดา' }}
                            · กำหนดชำระ {{ $credit->due_date?->format('d/m/Y') ?? '-' }}
                            · {{ $orders->count() }} ออเดอร์
                        </div>
                    </div>
                    <span class="credit-status {{ $credit->status === 'paid' ? 'paid' : 'pending' }}">
                        {{ $credit->status === 'paid' ? 'ปิดรอบแล้ว' : 'ค้างชำระ' }}
                    </span>
                </div>

                <div class="credit-stats">
                    <div class="credit-stat">
                        <div class="credit-stat-label">วงเงิน</div>
                        <div class="credit-stat-value">{{ $credit->credit_limit !== null ? '฿' . number_format($credit->credit_limit, 2) : 'ไม่จำกัด' }}</div>
                    </div>
                    <div class="credit-stat">
                        <div class="credit-stat-label">ค่าสินค้า</div>
                        <div class="credit-stat-value">฿{{ number_format($productTotal, 2) }}</div>
                    </div>
                    <div class="credit-stat">
                        <div class="credit-stat-label">ค่าส่งรวม/ตามน้ำหนักจริง</div>
                        <div class="credit-stat-value">฿{{ number_format($shippingTotal, 2) }}</div>
                    </div>
                    <div class="credit-stat">
                        <div class="credit-stat-label">ยอดรวมรอบนี้</div>
                        <div class="credit-stat-value">฿{{ number_format($grandTotal, 2) }}</div>
                    </div>
                </div>

                @if($credit->payment_slip)
                    <div style="margin:10px 0; font-size:0.88rem;">
                        สลิปชำระเงิน:
                        <a href="{{ route('media.show', ['path' => $credit->payment_slip]) }}" target="_blank" style="color:#0369a1; font-weight:700;">เปิดดูสลิป</a>
                        @if($credit->payment_submitted_at)
                            <span style="color:var(--text-muted);">· ส่งเมื่อ {{ $credit->payment_submitted_at->format('d/m/Y H:i') }}</span>
                        @endif
                    </div>
                @endif

                @if($orders->isNotEmpty())
                    <div class="credit-orders">
                        @foreach($orders as $order)
                            <div class="credit-order">
                                <div style="display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; font-weight:700;">
                                    <span>ออเดอร์ #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    <span>฿{{ number_format($order->total_amount, 2) }}</span>
                                </div>
                                <div style="color:var(--text-muted); font-size:0.82rem; margin:4px 0 8px;">
                                    ค่าสินค้า ฿{{ number_format(max(0, $order->total_amount - ($order->shipping_cost ?? 0)), 2) }}
                                    · ค่าส่ง ฿{{ number_format($order->shipping_cost ?? 0, 2) }}
                                </div>

                                @foreach($order->items as $item)
                                    @php
                                        $isWholesale = (int) $item->items_per_set > 1 && (int) $item->quantity >= (int) $item->items_per_set;
                                    @endphp
                                    <div class="credit-item">
                                        <div>
                                            <strong>{{ $item->product?->name ?? 'สินค้าถูกลบ' }}</strong>
                                            @if($item->variant_name)
                                                <span style="color:var(--text-muted);">({{ $item->variant_name }})</span>
                                            @endif
                                            <div style="color:var(--text-muted); font-size:0.8rem;">
                                                {{ $isWholesale ? 'ราคาส่ง' : 'ราคาปลีก' }}
                                                @if($isWholesale)
                                                    · ชุดละ {{ $item->items_per_set }} ชิ้น
                                                @endif
                                                · จำนวน {{ $item->quantity }} ชิ้น
                                            </div>
                                        </div>
                                        <div style="font-weight:700;">฿{{ number_format($item->total, 2) }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="padding:16px; color:var(--text-muted); text-align:center; border:1px dashed var(--border-color); border-radius:12px;">
                        ยังไม่มีออเดอร์ในรอบนี้
                    </div>
                @endif

                <form action="{{ route('admin.credits.update', $credit) }}" method="POST" enctype="multipart/form-data" class="credit-edit-grid" style="margin-top:14px;">
                    @csrf
                    @method('PUT')
                    <div class="credit-split">
                        <div>
                            <label>สถานะรอบบิล</label>
                            <select name="status">
                                <option value="pending" {{ $credit->status !== 'paid' ? 'selected' : '' }}>ค้างชำระ</option>
                                <option value="paid" {{ $credit->status === 'paid' ? 'selected' : '' }}>ชำระแล้ว / ปิดรอบ</option>
                            </select>
                        </div>
                        <div>
                            <label>กำหนดชำระ</label>
                            <input type="date" name="due_date" value="{{ old('due_date', $credit->due_date?->toDateString()) }}">
                        </div>
                    </div>
                    <div class="credit-split">
                        <div>
                            <label>วงเงิน</label>
                            <input type="number" name="credit_limit" step="0.01" value="{{ $credit->credit_limit }}">
                        </div>
                        <div>
                            <label>แนบ/เปลี่ยนสลิป</label>
                            <input type="file" name="payment_slip" accept="image/*">
                        </div>
                    </div>
                    <div>
                        <label>หมายเหตุการชำระ</label>
                        <textarea name="payment_note" rows="2">{{ $credit->payment_note }}</textarea>
                    </div>
                    <div class="credit-actions">
                        <button type="submit" class="btn btn-primary">บันทึก / ตรวจสอบแล้ว</button>
                        <button type="submit" form="delete-credit-{{ $credit->id }}" class="btn" style="background:#fee2e2; color:#dc2626;" onclick="return confirm('ลบรอบบิลเครดิตนี้?');">ลบรอบ</button>
                    </div>
                </form>
                <form id="delete-credit-{{ $credit->id }}" action="{{ route('admin.credits.destroy', $credit) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        @empty
            <div style="text-align:center; padding:30px; color:var(--text-muted);">ยังไม่มีการกำหนดเครดิต</div>
        @endforelse
    </div>
</div>
@endsection
