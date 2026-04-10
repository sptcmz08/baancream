@extends('layouts.admin')

@section('content')
<div class="header-actions">
    <h2>จัดการรายการสินค้า (SKU)</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ เพิ่มสินค้าใหม่</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>รูปภาพ</th>
                <th>SKU</th>
                <th>ชื่อสินค้า</th>
                <th>สูตร</th>
                <th>ราคาปลีก</th>
                <th>ราคาส่ง</th>
                <th>หมวดหมู่</th>
                <th>สินค้าใหม่</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products ?? [] as $product)
            <tr>
                <td>
                    @php($displayImage = $product->displayImage())
                    @if($displayImage)
                        <img src="{{ route('media.show', ['path' => $displayImage]) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                    @else
                        <div style="width: 50px; height: 50px; background: #eee; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: #aaa;">No Img</div>
                    @endif
                </td>
                <td style="font-weight: 500;">{{ $product->sku }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->variants->count() ?: '-' }}</td>
                <td style="color: var(--primary-color);">฿{{ number_format($product->displayRetailPrice(), 2) }}</td>
                <td style="color: #16a34a;">{{ $product->displayWholesaleMinQty() }} ชิ้น / ฿{{ number_format($product->displayWholesaleBundlePrice(), 2) }}</td>
                <td>{{ $product->categories->pluck('name')->join(', ') ?: '-' }}</td>
                <td>{{ $product->is_new_arrival ? 'ใช่' : '-' }}</td>
                <td style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn" style="background:#f3f4f6; color: #4b5563; padding: 6px 12px; font-size:0.8rem; text-decoration:none;">แก้ไข</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('ยืนยันการลบสินค้า {{ $product->sku }}?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn" style="background:#fee2e2; color:#dc2626; padding: 6px 12px; font-size:0.8rem;">ลบ</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center; color: var(--text-muted); padding: 50px;">
                    <div style="font-size: 3rem; margin-bottom: 10px;">📦</div>
                    <div>ยังไม่มีรายการสินค้าในระบบ</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
