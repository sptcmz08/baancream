@extends('layouts.admin')
@section('content')
<div class="header-actions">
    <h2>หมวดหมู่สินค้า</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ เพิ่มหมวดหมู่ใหม่</a>
</div>
<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th width="80%">ชื่อหมวดหมู่</th>
                <th width="20%">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $cat)
            <tr>
                <td style="font-size: 1.1rem;">{{ $cat->name }}</td>
                <td style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.categories.edit', $cat) }}" class="btn" style="background:#f3f4f6; padding: 6px 12px; font-size:0.8rem; text-decoration:none;">แก้ไข</a>
                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('ยืนยันลบหมวดหมู่: {{ $cat->name }} ?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn" style="background:#fee2e2; color:#dc2626; padding: 6px 12px; font-size:0.8rem;">ลบ</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2" style="text-align:center; padding: 30px; color:var(--text-muted);">ไม่มีรายการหมวดหมู่</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
