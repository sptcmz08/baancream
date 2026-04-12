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
                        <select
                            name="role"
                            onchange="this.form.submit()"
                            {{ $user->id === auth()->id() ? 'disabled' : '' }}
                            style="padding:5px 10px; border:1px solid var(--border-color); border-radius:6px; font-size:0.82rem; font-family:'Prompt';">
                            <option value="user" {{ in_array($user->role, ['customer', 'vip'], true) ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>แอดมิน</option>
                        </select>
                        @if($user->id === auth()->id())
                            <div style="color:var(--text-muted); font-size:0.76rem; margin-top:4px;">บัญชีที่ใช้งานอยู่</div>
                        @endif
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
                <td colspan="6" style="text-align:center; padding:30px; color:var(--text-muted);">ยังไม่มีผู้ใช้</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
