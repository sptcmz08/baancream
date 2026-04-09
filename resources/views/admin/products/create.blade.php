@extends('layouts.admin')
@section('content')
<div class="header-actions">
    <h2>เพิ่มสินค้าใหม่</h2>
    <a href="{{ route('admin.products.index') }}" class="btn" style="background:var(--border-color); text-decoration:none;">กลับ</a>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">SKU รหัสสินค้า <span style="color:red;">*</span></label>
                <input type="text" name="sku" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">ชื่อสินค้า <span style="color:red;">*</span></label>
                <input type="text" name="name" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">หมวดหมู่ <span style="color:red;">*</span></label>
                <select name="category_id" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
                    <option value="">เลือกหมวดหมู่</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">รูปภาพ</label>
                <input type="file" name="image" accept="image/*" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">ราคาปลีก (Retail) <span style="color:red;">*</span></label>
                <input type="number" name="retail_price" step="0.01" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">ราคาส่ง (Wholesale) <span style="color:red;">*</span></label>
                <input type="number" name="wholesale_price" step="0.01" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div style="grid-column: 1 / -1;">
                <label style="display:block; margin-bottom:10px; font-weight:500;">รายละเอียดสินค้า</label>
                <textarea name="description" rows="4" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%; padding:14px; font-size:1.1rem;">บันทึกสินค้าใหม่</button>
    </form>
</div>
@endsection
