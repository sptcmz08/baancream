@extends('layouts.admin')
@section('content')
<div class="header-actions">
    <h2>แก้ไขสินค้า: {{ $product->sku }}</h2>
    <a href="{{ route('admin.products.index') }}" class="btn" style="background:var(--border-color); text-decoration:none;">กลับ</a>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div style="grid-column: 1 / -1;">
                @if($product->image)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 150px; border-radius: 8px;">
                    </div>
                @endif
                <label style="display:block; margin-bottom:10px; font-weight:500;">เปลี่ยนรูปภาพ</label>
                <input type="file" name="image" accept="image/*" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">SKU รหัสสินค้า <span style="color:red;">*</span></label>
                <input type="text" name="sku" value="{{ $product->sku }}" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">ชื่อสินค้า <span style="color:red;">*</span></label>
                <input type="text" name="name" value="{{ $product->name }}" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">หมวดหมู่ <span style="color:red;">*</span></label>
                <select name="category_id" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
             <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">ราคาปลีก (Retail) <span style="color:red;">*</span></label>
                <input type="number" name="retail_price" value="{{ $product->retail_price }}" step="0.01" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">ราคาส่ง (Wholesale) <span style="color:red;">*</span></label>
                <input type="number" name="wholesale_price" value="{{ $product->wholesale_price }}" step="0.01" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div style="grid-column: 1 / -1;">
                <label style="display:block; margin-bottom:10px; font-weight:500;">รายละเอียดสินค้า</label>
                <textarea name="description" rows="4" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">{{ $product->description }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%; padding:14px; font-size:1.1rem;">บันทึกการแก้ไข</button>
    </form>
</div>
@endsection
