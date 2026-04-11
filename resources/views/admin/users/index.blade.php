@extends('layouts.admin')
@section('content')
<div class="header-actions">
    <h2>จัดการผู้ใช้งาน (Users)</h2>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>ชื่อ</th>
                <th>อีเมล</th>
                <th>บทบาท</th>
                <th>เครดิต</th>
                <th>วันครบกำหนด</th>
                <th>ออเดอร์</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td style="font-weight:500;">#{{ $user->id }}</td>
                <td>
                    <div style="font-weight:600;">{{ $user->name }}</div>
                    @if($user->username)
                        <div style="color:var(--text-muted); font-size:0.82rem;">@{{ $user->username }}</div>
                    @endif
                </td>
                <td style="font-size:0.88rem;">{{ $user->email }}</td>
                <td>
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" style="display:inline;">
                        @csrf @method('PUT')
                        <select name="role" onchange="this.form.submit()" style="padding:5px 10px; border:1px solid var(--border-color); border-radius:6px; font-size:0.82rem; font-family:'Prompt';">
                            <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>ลูกค้า</option>
                            <option value="vip" {{ $user->role === 'vip' ? 'selected' : '' }}>VIP</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>แอดมิน</option>
                        </select>
                    </form>
                </td>
                <td>
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" style="display:inline-flex; gap:6px; align-items:center;">
                        @csrf @method('PUT')
                        <label style="display:flex; align-items:center; gap:4px; cursor:pointer;">
                            <input type="hidden" name="is_credit_enabled" value="0">
                            <input type="checkbox" name="is_credit_enabled" value="1" {{ $user->is_credit_enabled ? 'checked' : '' }} onchange="this.form.submit()" style="accent-color:var(--primary-color);">
                            <span style="font-size:0.82rem;">{{ $user->is_credit_enabled ? 'เปิด' : 'ปิด' }}</span>
                        </label>
                        @if($user->default_credit_limit)
                            <span style="font-size:0.78rem; color:var(--text-muted);">
                                ฿{{ number_format($user->default_credit_limit, 0) }}
                            </span>
                        @endif
                    </form>
                </td>
                <td>
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" style="display:inline;">
                        @csrf @method('PUT')
                        <input type="date" name="credit_due_date" value="{{ $user->credit_due_date?->format('Y-m-d') }}" onchange="this.form.submit()" style="padding:5px 8px; border:1px solid var(--border-color); border-radius:6px; font-size:0.82rem; font-family:'Prompt';">
                    </form>
                </td>
                <td style="text-align:center;">
                    <span style="background:#f3f4f6; padding:4px 10px; border-radius:6px; font-size:0.82rem; font-weight:500;">
                        {{ $user->orders_count }}
                    </span>
                </td>
                <td>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('ลบผู้ใช้ {{ $user->name }}?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn" style="background:#fee2e2; color:#dc2626; padding:6px 10px; font-size:0.8rem;">ลบ</button>
                    </form>
                    @else
                        <span style="color:var(--text-muted); font-size:0.82rem;">ตัวเอง</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; padding:30px; color:var(--text-muted);">ยังไม่มีผู้ใช้</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Bulk Credit Confirmation --}}
@php
    $creditUsers = $users->where('is_credit_enabled', true)->values();
@endphp
@if($creditUsers->isNotEmpty())
<div class="card" style="border-color:#3b82f640;">
    <h3 style="margin-bottom:16px; font-weight:600; color:#2563eb;">💰 ยืนยันออเดอร์เครดิตทั้งหมด (Bulk)</h3>
    <p style="color:var(--text-muted); font-size:0.88rem; margin-bottom:16px;">กดปุ่มด้านล่างเพื่อยืนยันออเดอร์เครดิตที่ยังรอตรวจสอบทั้งหมดของลูกค้าแต่ละคน</p>
    <div style="display:flex; gap:8px; flex-wrap:wrap;">
        @foreach($creditUsers as $cu)
            <form action="{{ route('admin.orders.confirm-all-credit') }}" method="POST" style="display:inline;">
                @csrf
                <input type="hidden" name="user_id" value="{{ $cu->id }}">
                <button type="submit" class="btn" style="background:#eff6ff; color:#2563eb; padding:8px 16px; font-size:0.85rem; border:1px solid #bfdbfe;">
                    ✓ {{ $cu->name }}
                </button>
            </form>
        @endforeach
    </div>
</div>
@endif
@endsection
