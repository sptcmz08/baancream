@extends('layouts.admin')

@section('styles')
<style>
    .credit-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }
    .credit-note {
        color: var(--text-muted);
        font-size: 0.9rem;
        line-height: 1.7;
    }
    .credit-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 5px 12px;
        font-size: 0.8rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .credit-status.paid {
        background: #dcfce7;
        color: #15803d;
    }
    .credit-status.pending {
        background: #fff7ed;
        color: #c2410c;
    }
    .credit-role {
        display: inline-flex;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 0.78rem;
        font-weight: 700;
        background: #e0f2fe;
        color: #0369a1;
    }
    .credit-role.vip {
        background: #fef3c7;
        color: #92400e;
    }
    .credit-modal {
        position: fixed;
        inset: 0;
        z-index: 90;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(15, 23, 42, 0.52);
    }
    .credit-modal.is-open {
        display: flex;
    }
    .credit-modal-panel {
        width: min(1080px, 100%);
        max-height: calc(100vh - 40px);
        overflow: auto;
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 14px;
        box-shadow: 0 28px 80px rgba(15, 23, 42, 0.24);
        padding: 22px;
    }
    .credit-modal-small {
        width: min(580px, 100%);
    }
    .credit-modal-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 18px;
    }
    .credit-modal-title {
        font-size: 1.18rem;
        font-weight: 800;
    }
    .credit-modal-sub {
        margin-top: 4px;
        color: var(--text-muted);
        font-size: 0.88rem;
    }
    .credit-modal-close {
        width: 38px;
        height: 38px;
        border: none;
        border-radius: 999px;
        background: #f3f4f6;
        cursor: pointer;
        font-size: 1rem;
        flex: 0 0 auto;
    }
    .credit-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(120px, 1fr));
        gap: 10px;
        margin-bottom: 18px;
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
    .credit-modal-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.25fr) minmax(320px, 0.75fr);
        gap: 18px;
        align-items: start;
    }
    .credit-section {
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 14px;
        background: white;
    }
    .credit-section-title {
        font-weight: 800;
        margin-bottom: 10px;
    }
    .credit-order {
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 12px;
        background: #fafafa;
        margin-top: 10px;
    }
    .credit-item {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 8px 0;
        border-top: 1px solid #edf0f5;
        font-size: 0.88rem;
    }
    .shipping-adjust-form {
        display: grid;
        grid-template-columns: minmax(140px, 0.7fr) minmax(180px, 1fr) auto;
        gap: 8px;
        align-items: end;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px dashed #dbe3ef;
    }
    .shipping-adjust-form label {
        display: block;
        color: var(--text-muted);
        font-size: 0.78rem;
        margin-bottom: 5px;
    }
    .shipping-adjust-form input {
        width: 100%;
        padding: 9px 10px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-family: 'Prompt';
        background: white;
    }
    .credit-form-grid {
        display: grid;
        gap: 12px;
    }
    .credit-form-grid label {
        display: block;
        margin-bottom: 7px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .credit-form-grid input,
    .credit-form-grid select,
    .credit-form-grid textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-family: 'Prompt';
        background: white;
    }
    .credit-split {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .credit-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
        margin-top: 12px;
    }
    @media (max-width: 920px) {
        .credit-modal-grid,
        .credit-split {
            grid-template-columns: 1fr;
        }
        .credit-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (max-width: 640px) {
        .credit-modal {
            align-items: flex-end;
            padding: 0;
        }
        .credit-modal-panel {
            max-height: 90vh;
            border-radius: 18px 18px 0 0;
            padding: 18px;
        }
        .credit-stats {
            grid-template-columns: 1fr;
        }
        .credit-item {
            display: grid;
        }
        .shipping-adjust-form {
            grid-template-columns: 1fr;
        }
        .credit-toolbar .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="header-actions">
    <div>
        <h2>ระบบเครดิต / รอบชำระ</h2>
        <p style="margin-top:8px; color:var(--text-muted);">ดูรอบบิลเครดิตเป็นตาราง แล้วกดจัดการเพื่อดูรายละเอียดสินค้า สลิป และปิดรอบชำระ</p>
    </div>
</div>

<div class="card">
    <div class="credit-toolbar">
        <div class="credit-note">
            หากรอบเก่ายังไม่ปิด ระบบสั่งซื้อเครดิตจะรวมยอดเข้ารอบเก่าก่อน แม้จะสร้างรอบเดือนถัดไปไว้ล่วงหน้าแล้ว
        </div>
        <button type="button" class="btn btn-primary" data-open-credit-modal="createCreditModal">+ เปิดรอบเครดิต</button>
    </div>

    <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
        <table class="table" style="min-width:1120px;">
            <thead>
                <tr>
                    <th>ลูกค้า</th>
                    <th>ประเภท</th>
                    <th>รอบบิล</th>
                    <th>กำหนดชำระ</th>
                    <th>ออเดอร์</th>
                    <th>ค่าสินค้า</th>
                    <th>ค่าส่ง</th>
                    <th>ยอดรวม</th>
                    <th>สถานะ</th>
                    <th style="width:120px;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($credits as $credit)
                    @php
                        $orders = $credit->orders;
                        $productTotal = $credit->productTotal();
                        $shippingTotal = $credit->shippingTotal();
                        $grandTotal = $credit->totalAmount();
                        $isVip = $credit->user?->role === 'vip';
                    @endphp
                    <tr>
                        <td>
                            <div style="font-weight:700;">{{ $credit->user->name ?? 'Unknown' }}</div>
                            <div style="color:var(--text-muted); font-size:0.82rem;">วงเงิน {{ $credit->credit_limit !== null ? '฿' . number_format($credit->credit_limit, 2) : 'ไม่จำกัด' }}</div>
                        </td>
                        <td><span class="credit-role {{ $isVip ? 'vip' : '' }}">{{ $isVip ? 'VIP' : 'User' }}</span></td>
                        <td>{{ $credit->month }}/{{ $credit->year }}</td>
                        <td>{{ $credit->due_date?->format('d/m/Y') ?? '-' }}</td>
                        <td>{{ $orders->count() }}</td>
                        <td>฿{{ number_format($productTotal, 2) }}</td>
                        <td>฿{{ number_format($shippingTotal, 2) }}</td>
                        <td style="font-weight:800;">฿{{ number_format($grandTotal, 2) }}</td>
                        <td>
                            <span class="credit-status {{ $credit->status === 'paid' ? 'paid' : 'pending' }}">
                                {{ $credit->status === 'paid' ? 'ปิดรอบแล้ว' : 'ค้างชำระ' }}
                            </span>
                            @if($credit->payment_slip && $credit->status !== 'paid')
                                <div style="color:#0369a1; font-size:0.78rem; margin-top:5px;">มีสลิปรอตรวจ</div>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn" data-open-credit-modal="creditModal{{ $credit->id }}" style="background:#e0f2fe; color:#0369a1; padding:7px 12px; font-size:0.82rem;">จัดการ</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align:center; padding:34px; color:var(--text-muted);">ยังไม่มีการกำหนดเครดิต</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $credits->links('vendor.pagination.admin') }}
</div>

<div class="credit-modal" id="createCreditModal" aria-hidden="true">
    <div class="credit-modal-panel credit-modal-small">
        <div class="credit-modal-head">
            <div>
                <div class="credit-modal-title">เปิดรอบเครดิต</div>
                <div class="credit-modal-sub">สร้างรอบบิลล่วงหน้าได้ ระบบจะใช้รอบค้างชำระเก่าที่สุดตอนลูกค้าสั่งซื้อ</div>
            </div>
            <button type="button" class="credit-modal-close" data-close-credit-modal aria-label="ปิด">x</button>
        </div>

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

            <div class="credit-actions" style="justify-content:flex-end;">
                <button type="button" class="btn" data-close-credit-modal>ยกเลิก</button>
                <button type="submit" class="btn btn-primary">บันทึกรอบเครดิต</button>
            </div>
        </form>
    </div>
</div>

@foreach($credits as $credit)
    @php
        $orders = $credit->orders;
        $productTotal = $credit->productTotal();
        $shippingTotal = $credit->shippingTotal();
        $grandTotal = $credit->totalAmount();
        $isVip = $credit->user?->role === 'vip';
    @endphp
    <div class="credit-modal" id="creditModal{{ $credit->id }}" aria-hidden="true">
        <div class="credit-modal-panel">
            <div class="credit-modal-head">
                <div>
                    <div class="credit-modal-title">{{ $credit->user->name ?? 'Unknown' }} - รอบ {{ $credit->month }}/{{ $credit->year }}</div>
                    <div class="credit-modal-sub">
                        {{ $isVip ? 'VIP' : 'ลูกค้าธรรมดา' }}
                        · กำหนดชำระ {{ $credit->due_date?->format('d/m/Y') ?? '-' }}
                        · {{ $orders->count() }} ออเดอร์
                    </div>
                </div>
                <button type="button" class="credit-modal-close" data-close-credit-modal aria-label="ปิด">x</button>
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
                    <div class="credit-stat-label">ค่าส่ง / ตามน้ำหนักจริง</div>
                    <div class="credit-stat-value">฿{{ number_format($shippingTotal, 2) }}</div>
                </div>
                <div class="credit-stat">
                    <div class="credit-stat-label">ยอดรวมรอบนี้</div>
                    <div class="credit-stat-value">฿{{ number_format($grandTotal, 2) }}</div>
                </div>
            </div>

            <div class="credit-modal-grid">
                <div class="credit-section">
                    <div class="credit-section-title">รายการในรอบนี้</div>
                    @forelse($orders as $order)
                        <div class="credit-order">
                            <div style="display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; font-weight:800;">
                                <span>ออเดอร์ #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                <span>฿{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                            <div style="color:var(--text-muted); font-size:0.82rem; margin:4px 0 8px;">
                                ค่าสินค้า ฿{{ number_format(max(0, $order->total_amount - ($order->shipping_cost ?? 0)), 2) }}
                                · ค่าส่ง/น้ำหนักจริง ฿{{ number_format($order->shipping_cost ?? 0, 2) }}
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
                                    <div style="font-weight:800;">฿{{ number_format($item->total, 2) }}</div>
                                </div>
                            @endforeach

                            @if($credit->status !== 'paid')
                                <form action="{{ route('admin.orders.shipping-adjustment', $order) }}" method="POST" class="shipping-adjust-form">
                                    @csrf
                                    <div>
                                        <label>เพิ่มค่าส่งจริง (บาท)</label>
                                        <input type="number" name="shipping_adjustment" step="0.01" min="0.01" placeholder="เช่น 25" required>
                                    </div>
                                    <div>
                                        <label>หมายเหตุ</label>
                                        <input type="text" name="shipping_note" placeholder="เช่น ส่วนต่างน้ำหนักจริง">
                                    </div>
                                    <button type="submit" class="btn" style="background:#fef3c7; color:#92400e; padding:9px 12px;">+ เพิ่มยอด</button>
                                </form>
                            @else
                                <div style="margin-top:10px; color:var(--text-muted); font-size:0.8rem;">รอบนี้ปิดแล้ว หากต้องแก้ยอดให้เปิดจากหน้าออเดอร์โดยตรง</div>
                            @endif
                        </div>
                    @empty
                        <div style="padding:24px; color:var(--text-muted); text-align:center; border:1px dashed var(--border-color); border-radius:12px;">
                            ยังไม่มีออเดอร์ในรอบนี้
                        </div>
                    @endforelse
                </div>

                <div class="credit-section">
                    <div class="credit-section-title">จัดการรอบบิล</div>

                    @if($credit->payment_slip)
                        <div style="margin-bottom:12px; font-size:0.88rem; line-height:1.7;">
                            <strong>สลิปชำระเงิน:</strong>
                            <a href="{{ route('media.show', ['path' => $credit->payment_slip]) }}" target="_blank" style="color:#0369a1; font-weight:800;">เปิดดูสลิป</a>
                            @if($credit->payment_submitted_at)
                                <div style="color:var(--text-muted);">ส่งเมื่อ {{ $credit->payment_submitted_at->format('d/m/Y H:i') }}</div>
                            @endif
                        </div>
                    @else
                        <div style="margin-bottom:12px; color:var(--text-muted); font-size:0.88rem;">ยังไม่มีสลิปชำระเงิน</div>
                    @endif

                    <form action="{{ route('admin.credits.update', $credit) }}" method="POST" enctype="multipart/form-data" class="credit-form-grid">
                        @csrf
                        @method('PUT')
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
                        <div>
                            <label>วงเงิน</label>
                            <input type="number" name="credit_limit" step="0.01" value="{{ $credit->credit_limit }}">
                        </div>
                        <div>
                            <label>แนบ/เปลี่ยนสลิป</label>
                            <input type="file" name="payment_slip" accept="image/*">
                        </div>
                        <div>
                            <label>หมายเหตุการชำระ</label>
                            <textarea name="payment_note" rows="3">{{ $credit->payment_note }}</textarea>
                        </div>
                        <div class="credit-actions">
                            <button type="submit" class="btn btn-primary">บันทึก / ตรวจสอบแล้ว</button>
                            <button type="button" class="btn" data-close-credit-modal>ปิด</button>
                            <button type="submit" form="delete-credit-{{ $credit->id }}" class="btn" style="background:#fee2e2; color:#dc2626;" onclick="return confirm('ลบรอบบิลเครดิตนี้?');">ลบรอบ</button>
                        </div>
                    </form>
                    <form id="delete-credit-{{ $credit->id }}" action="{{ route('admin.credits.destroy', $credit) }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection

@section('scripts')
<script>
    const creditModals = document.querySelectorAll('.credit-modal');

    function openCreditModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeCreditModals() {
        creditModals.forEach((modal) => {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
        });
        document.body.style.overflow = '';
    }

    document.querySelectorAll('[data-open-credit-modal]').forEach((button) => {
        button.addEventListener('click', () => openCreditModal(button.dataset.openCreditModal));
    });

    document.querySelectorAll('[data-close-credit-modal]').forEach((button) => {
        button.addEventListener('click', closeCreditModals);
    });

    creditModals.forEach((modal) => {
        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeCreditModals();
            }
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeCreditModals();
        }
    });
</script>
@endsection
