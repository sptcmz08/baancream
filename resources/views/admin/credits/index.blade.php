@extends('layouts.admin')
@section('content')
<div class="header-actions">
    <h2>ระบบโควตาเครดิตรายเดือน (Credit System)</h2>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">
    <!-- Form to assign credit -->
    <div class="card">
        <h3>+ อนุมัติสิทธิ์เครดิต</h3>
        <p style="color:var(--text-muted); font-size:0.8rem; margin-bottom:15px;">ระบุยอดโควตาให้ลูกค้าในแต่ละรอบเดือน (เว้นว่าง = ให้โควตาไม่จำกัดของลูกค้าระดับ VIP)</p>
        
        <form action="{{ route('admin.credits.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:8px;">เลือกลูกค้า</label>
                <select name="user_id" required style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--border-color);">
                    <option value="">-- เลือกลูกค้า --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ strtoupper($user->role) }})</option>
                    @endforeach
                </select>
            </div>
            <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                <div style="flex:1;">
                    <label style="display:block; margin-bottom:8px;">รอบเดือนที่</label>
                    <select name="month" required style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--border-color);">
                        @for($i=1; $i<=12; $i++)
                            <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>เดือน {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div style="flex:1;">
                    <label style="display:block; margin-bottom:8px;">ปี ค.ศ.</label>
                    <input type="number" name="year" value="{{ date('Y') }}" required style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--border-color);">
                </div>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:8px;">วงเงินอนุมัติ (บาท)</label>
                <input type="number" name="credit_limit" step="0.01" placeholder="เช่น 50000 (เว้นว่าง=ไม่อั้น)" style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--border-color);">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">บันทึกข้อมูลเครดิต</button>
        </form>
    </div>

    <!-- Credit Table -->
    <div class="card">
        <h3>รายการประวัติเครดิต</h3>
        <table class="table" style="margin-top: 15px;">
            <thead>
                <tr>
                    <th>รอบบิล</th>
                    <th>ลูกค้า</th>
                    <th>วงเงินโควตา</th>
                    <th>ยอดใช้ไป</th>
                    <th>สถานะจ่าย</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($credits as $credit)
                <tr>
                    <td>{{ $credit->month }}/{{ $credit->year }}</td>
                    <td>{{ $credit->user->name ?? 'Unknown' }}</td>
                    <td>{{ $credit->credit_limit ? '฿' . number_format($credit->credit_limit, 2) : 'VIP อนันต์' }}</td>
                    <td style="color:#dc2626; font-weight:500;">฿{{ number_format($credit->spent_amount, 2) }}</td>
                    <td>
                        @if($credit->status == 'paid') <span style="background:#22c55e15; color:#16a34a; padding:4px 8px; border-radius:4px; font-size:0.8rem;">ชำระแล้ว</span>
                        @else <span style="background:#f59e0b15; color:#d97706; padding:4px 8px; border-radius:4px; font-size:0.8rem;">ค้างชำระ</span> @endif
                    </td>
                    <td style="display: flex; gap:5px;">
                        <form action="{{ route('admin.credits.update', $credit) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="{{ $credit->status == 'paid' ? 'pending' : 'paid' }}">
                            <button type="submit" class="btn" style="background:#f3f4f6; padding: 6px 12px; font-size:0.8rem;">เปลี่ยนสถานะ</button>
                        </form>
                        <form action="{{ route('admin.credits.destroy', $credit) }}" method="POST" onsubmit="return confirm('ยืนยันระบบรอบบิลนี้?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn" style="background:#fee2e2; color:#dc2626; padding: 6px 12px; font-size:0.8rem;">ลบ</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center; padding:30px; color:var(--text-muted);">ยังไม่มีการกำหนดเครดิต</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
