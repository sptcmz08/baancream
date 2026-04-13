@extends('layouts.admin')

@section('content')
<div class="header-actions">
    <h2>จัดการผู้ใช้งาน (Users)</h2>
</div>

<div class="card" style="margin-bottom:20px;">
    <h3 style="margin-bottom:16px;">เพิ่มผู้ใช้งานใหม่</h3>
    <form action="{{ route('admin.users.store') }}" method="POST" style="display:grid; grid-template-columns:1.2fr 1fr 1fr 1fr 130px 90px; gap:12px; align-items:end;">
        @csrf
        <div>
            <label style="display:block; margin-bottom:8px; font-weight:500;">ชื่อ</label>
            <input type="text" name="name" value="{{ old('name') }}" required style="width:100%; padding:10px 12px; border:1px solid var(--border-color); border-radius:8px;">
        </div>
        <div>
            <label style="display:block; margin-bottom:8px; font-weight:500;">Username</label>
            <input type="text" name="username" value="{{ old('username') }}" required style="width:100%; padding:10px 12px; border:1px solid var(--border-color); border-radius:8px;">
        </div>
        <div>
            <label style="display:block; margin-bottom:8px; font-weight:500;">รหัสผ่าน</label>
            <input type="password" name="password" required style="width:100%; padding:10px 12px; border:1px solid var(--border-color); border-radius:8px;">
        </div>
        <div>
            <label style="display:block; margin-bottom:8px; font-weight:500;">ยืนยันรหัสผ่าน</label>
            <input type="password" name="password_confirmation" required style="width:100%; padding:10px 12px; border:1px solid var(--border-color); border-radius:8px;">
        </div>
        <div>
            <label style="display:block; margin-bottom:8px; font-weight:500;">บทบาท</label>
            <select name="role" required style="width:100%; min-width:120px; padding:10px 12px; border:1px solid var(--border-color); border-radius:8px; font-family:'Prompt';">
                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>แอดมิน</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">เพิ่ม</button>
    </form>
</div>

<div class="card">
    <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
        <table class="table" style="min-width:980px;">
            <thead>
                <tr>
                    <th style="width:70px;">ID</th>
                    <th>ชื่อ</th>
                    <th>Username</th>
                    <th style="width:160px;">รหัสผ่านใหม่</th>
                    <th style="width:130px;">บทบาท</th>
                    <th style="width:90px; text-align:center;">ออเดอร์</th>
                    <th style="width:170px;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td style="font-weight:500;">#{{ $user->id }}</td>
                        <td>
                            <input type="text" name="name" form="updateUser{{ $user->id }}" value="{{ old("users.{$user->id}.name", $user->name) }}" required style="width:100%; min-width:180px; padding:9px 10px; border:1px solid var(--border-color); border-radius:8px;">
                        </td>
                        <td>
                            <input type="text" name="username" form="updateUser{{ $user->id }}" value="{{ old("users.{$user->id}.username", $user->username) }}" required style="width:100%; min-width:150px; padding:9px 10px; border:1px solid var(--border-color); border-radius:8px;">
                        </td>
                        <td>
                            <input type="password" name="password" form="updateUser{{ $user->id }}" placeholder="ไม่เปลี่ยนรหัส" style="width:100%; padding:9px 10px; border:1px solid var(--border-color); border-radius:8px;">
                            <input type="password" name="password_confirmation" form="updateUser{{ $user->id }}" placeholder="ยืนยันรหัสใหม่" style="width:100%; padding:9px 10px; border:1px solid var(--border-color); border-radius:8px; margin-top:8px;">
                        </td>
                        <td>
                            <select
                                name="role"
                                form="updateUser{{ $user->id }}"
                                {{ $user->id === auth()->id() ? 'disabled' : '' }}
                                style="width:100%; padding:9px 10px; border:1px solid var(--border-color); border-radius:8px; font-size:0.86rem; font-family:'Prompt';">
                                <option value="user" {{ in_array($user->role, ['customer', 'vip'], true) ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>แอดมิน</option>
                            </select>
                            @if($user->id === auth()->id())
                                <input type="hidden" name="role" form="updateUser{{ $user->id }}" value="admin">
                                <div style="color:var(--text-muted); font-size:0.76rem; margin-top:4px;">บัญชีที่ใช้งานอยู่</div>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            <span style="background:#f3f4f6; padding:4px 10px; border-radius:6px; font-size:0.82rem; font-weight:500;">
                                {{ $user->orders_count }}
                            </span>
                        </td>
                        <td>
                            <form id="updateUser{{ $user->id }}" action="{{ route('admin.users.update', $user) }}" method="POST" style="display:none;">
                                @csrf
                                @method('PUT')
                            </form>
                            <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                                <button type="submit" form="updateUser{{ $user->id }}" class="btn" style="background:#e0f2fe; color:#0369a1; padding:7px 10px; font-size:0.82rem;">บันทึก</button>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('ลบผู้ใช้ {{ $user->name }}?');" style="margin:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn" style="background:#fee2e2; color:#dc2626; padding:7px 10px; font-size:0.82rem;">ลบ</button>
                                    </form>
                                @else
                                    <span style="color:var(--text-muted); font-size:0.82rem;">ตัวเอง</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:30px; color:var(--text-muted);">ยังไม่มีผู้ใช้</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links('vendor.pagination.admin') }}
</div>
@endsection
