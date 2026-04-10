@extends('layouts.admin')

@section('content')
<div class="header-actions">
    <h2>แบรนด์สินค้า</h2>
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">+ เพิ่มแบรนด์ใหม่</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th width="45%">ชื่อแบรนด์</th>
                <th width="25%">Slug</th>
                <th width="10%">สินค้า</th>
                <th width="20%">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($brands as $brand)
            <tr>
                <td style="font-size: 1.05rem; font-weight: 500;">{{ $brand->name }}</td>
                <td style="color: var(--text-muted);">/{{ $brand->slug }}</td>
                <td>{{ $brand->products_count }}</td>
                <td style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.brands.edit', $brand) }}" class="btn" style="background:#f3f4f6; padding: 6px 12px; font-size:0.8rem; text-decoration:none;">แก้ไข</a>
                    <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('ยืนยันลบแบรนด์: {{ $brand->name }} ?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn" style="background:#fee2e2; color:#dc2626; padding: 6px 12px; font-size:0.8rem;">ลบ</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center; padding: 30px; color:var(--text-muted);">ไม่มีรายการแบรนด์</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
