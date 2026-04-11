@extends('layouts.admin')
@section('content')
<div class="header-actions">
    <h2>จัดการแบนเนอร์หน้าร้าน (Banners)</h2>
</div>

{{-- Add Banner Form --}}
<div class="card">
    <h3 style="margin-bottom:16px; font-weight:600;">เพิ่มแบนเนอร์ใหม่</h3>
    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" style="display:grid; grid-template-columns:1fr 1fr 1fr auto; gap:14px; align-items:end;">
        @csrf
        <div>
            <label style="font-size:0.85rem; font-weight:500; display:block; margin-bottom:6px;">ชื่อแบนเนอร์</label>
            <input type="text" name="title" placeholder="เช่น โปรต้อนรับ" style="width:100%; padding:10px 14px; border:1px solid var(--border-color); border-radius:8px; font-family:'Prompt';">
        </div>
        <div>
            <label style="font-size:0.85rem; font-weight:500; display:block; margin-bottom:6px;">รูปภาพแบนเนอร์ *</label>
            <input type="file" name="image" accept="image/*" required style="font-size:0.85rem;">
        </div>
        <div>
            <label style="font-size:0.85rem; font-weight:500; display:block; margin-bottom:6px;">ลิงก์ (ถ้ามี)</label>
            <input type="text" name="link" placeholder="https://..." style="width:100%; padding:10px 14px; border:1px solid var(--border-color); border-radius:8px; font-family:'Prompt';">
        </div>
        <button type="submit" class="btn btn-primary" style="padding:10px 24px;">เพิ่ม</button>
    </form>
</div>

{{-- Banner List --}}
<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th style="width:80px;">ภาพ</th>
                <th>ชื่อ</th>
                <th>ลิงก์</th>
                <th>ลำดับ</th>
                <th>สถานะ</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($banners as $banner)
            <tr>
                <td>
                    @if($banner->image)
                        <img src="{{ route('media.show', ['path' => $banner->image]) }}" style="width:80px; height:40px; object-fit:cover; border-radius:6px;">
                    @endif
                </td>
                <td style="font-weight:500;">{{ $banner->title ?: '-' }}</td>
                <td style="font-size:0.82rem; color:var(--text-muted);">{{ $banner->link ?: '-' }}</td>
                <td>
                    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" style="display:inline;">
                        @csrf @method('PUT')
                        <input type="number" name="sort_order" value="{{ $banner->sort_order }}" style="width:60px; padding:4px 8px; border:1px solid var(--border-color); border-radius:4px; text-align:center;" onchange="this.form.submit()">
                    </form>
                </td>
                <td>
                    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" style="display:inline;">
                        @csrf @method('PUT')
                        <input type="hidden" name="is_active" value="{{ $banner->is_active ? '0' : '1' }}">
                        <button type="submit" style="padding:4px 10px; border-radius:6px; border:none; cursor:pointer; font-size:0.8rem; font-weight:500;
                            {{ $banner->is_active ? 'background:#22c55e15; color:#16a34a;' : 'background:#f3f4f6; color:#9ca3af;' }}">
                            {{ $banner->is_active ? '✓ เปิดใช้' : '✕ ปิดอยู่' }}
                        </button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" style="display:inline;" onsubmit="return confirm('ลบแบนเนอร์นี้?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn" style="background:#fee2e2; color:#dc2626; padding:6px 10px; font-size:0.8rem;">ลบ</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:30px; color:var(--text-muted);">ยังไม่มีแบนเนอร์</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
