@extends('layouts.admin')

@section('content')
<div class="header-actions">
    <div>
        <h2>ตั้งค่าเว็บ / โลโก้</h2>
        <p style="margin-top:8px; color:var(--text-muted);">อัปโหลดโลโก้เพื่อใช้บนหน้าแรก หน้าสินค้า และ popup เข้าสู่ระบบ</p>
    </div>
</div>

<div class="card" style="max-width: 860px;">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display:grid; gap:24px; grid-template-columns:minmax(260px, 320px) minmax(0, 1fr); align-items:start;">
            <div>
                <div style="font-weight:500; margin-bottom:12px;">ตัวอย่างโลโก้ปัจจุบัน</div>
                <div style="border:1px solid var(--border-color); border-radius:16px; min-height:220px; background:#fafafa; display:flex; align-items:center; justify-content:center; padding:24px;">
                    @if($storefrontLogoUrl)
                        <img src="{{ $storefrontLogoUrl }}" alt="โลโก้เว็บไซต์" style="max-width:100%; max-height:160px; object-fit:contain;">
                    @else
                        <div style="text-align:center; color:var(--text-muted);">ยังไม่ได้อัปโหลดโลโก้<br>ระบบจะใช้ข้อความแทนให้อัตโนมัติ</div>
                    @endif
                </div>
            </div>

            <div>
                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:10px; font-weight:500;">อัปโหลดโลโก้ใหม่</label>
                    <input type="file" name="storefront_logo" accept="image/*" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:10px; background:white;">
                    <div style="margin-top:8px; color:var(--text-muted); font-size:0.9rem;">แนะนำไฟล์พื้นหลังโปร่งใส เช่น PNG หรือ WebP</div>
                    @error('storefront_logo')
                        <div style="margin-top:8px; color:#dc2626; font-size:0.9rem;">{{ $message }}</div>
                    @enderror
                </div>

                <label style="display:flex; gap:10px; align-items:flex-start; margin-bottom:24px; color:var(--text-dark);">
                    <input type="checkbox" name="remove_storefront_logo" value="1" style="margin-top:4px;">
                    <span>ลบโลโก้ปัจจุบันและกลับไปใช้ข้อความแทน</span>
                </label>

                <div style="padding:16px 18px; border:1px solid var(--border-color); border-radius:14px; background:#fcfaf6; color:var(--text-muted); margin-bottom:24px;">
                    <div style="font-weight:500; color:var(--text-dark); margin-bottom:6px;">ตำแหน่งที่นำโลโก้นี้ไปใช้</div>
                    <div>หน้าแรกของร้าน</div>
                    <div>หน้ารายละเอียดสินค้า</div>
                    <div>popup เข้าสู่ระบบ / สมัครสมาชิก</div>
                </div>

                <button type="submit" class="btn btn-primary">บันทึกการตั้งค่า</button>
            </div>
        </div>
    </form>
</div>
@endsection
