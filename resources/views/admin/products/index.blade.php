@extends('layouts.admin')

@section('content')
<div class="header-actions">
    <h2>จัดการรายการสินค้า (SKU)</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ เพิ่มสินค้าใหม่</a>
</div>

<div class="card" style="margin-bottom: 20px; padding: 15px;">
    <form action="{{ route('admin.products.index') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาสินค้าจากชื่อ หรือ SKU..." class="form-control" style="flex: 1; max-width: 400px; margin-bottom: 0;">
        <button type="submit" class="btn btn-primary" style="background: var(--primary-color);">🔍 ค้นหา</button>
        @if(request('search'))
            <a href="{{ route('admin.products.index') }}" class="btn" style="background: #f3f4f6; color: #4b5563; text-decoration: none; display: flex; align-items: center;">ล้างการค้นหา</a>
        @endif
    </form>
</div>

<div class="card">
    <div style="overflow-x: auto;">
        <table class="table" style="min-width: 900px;">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">ลำดับ</th>
                    <th style="width: 70px;">รูปภาพ</th>
                    <th style="width: 120px;">SKU</th>
                    <th>ชื่อสินค้า</th>
                    <th style="width: 60px;">สูตร</th>
                    <th style="width: 100px;">ราคาปลีก</th>
                    <th style="width: 150px;">ราคาส่ง</th>
                    <th>หมวดหมู่</th>
                    <th style="width: 80px;">ใหม่</th>
                    <th style="width: 200px;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products ?? [] as $product)
                <tr>
                    <td style="text-align: center; color: var(--text-muted);">{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                    <td>
                        @php($displayImage = $product->displayImage())
                        @if($displayImage)
                            <img src="{{ route('media.show', ['path' => $displayImage]) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                        @else
                            <div style="width: 50px; height: 50px; background: #eee; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: #aaa;">No Img</div>
                        @endif
                    </td>
                    <td style="font-weight: 500; font-size: 0.9rem;">{{ $product->sku }}</td>
                    <td style="font-size: 0.9rem;">{{ $product->name }}</td>
                    <td style="text-align: center;">{{ $product->variants->count() ?: '-' }}</td>
                    <td style="color: var(--primary-color); font-weight: 500;">฿{{ number_format($product->displayRetailPrice(), 2) }}</td>
                    <td style="color: #16a34a; font-size: 0.85rem;">{{ $product->displayWholesaleMinQty() }} ชิ้น<br>฿{{ number_format($product->displayWholesaleBundlePrice(), 2) }}</td>
                    <td style="font-size: 0.85rem;">{{ $product->categories->pluck('name')->join(', ') ?: '-' }}</td>
                    <td style="text-align: center;">
                        @if($product->is_new_arrival)
                            <span style="background: #fef08a; color: #854d0e; padding: 2px 6px; border-radius: 4px; font-size: 0.75rem; font-weight: bold;">NEW</span>
                        @else
                            -
                        @endif
                    </td>
                    <td style="display: flex; gap: 6px; flex-wrap: wrap;">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn" style="background:#f3f4f6; color: #4b5563; padding: 6px 10px; font-size:0.8rem; text-decoration:none;">แก้ไข</a>
                        <form action="{{ route('admin.products.copy', $product) }}" method="POST" onsubmit="return confirm('คัดลอกสินค้า {{ $product->sku }}?');" style="margin: 0;">
                            @csrf
                            <button type="submit" class="btn" style="background:#e0f2fe; color:#0369a1; padding: 6px 10px; font-size:0.8rem;">Copy</button>
                        </form>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('ยืนยันการลบสินค้า {{ $product->sku }}?');" style="margin: 0;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn" style="background:#fee2e2; color:#dc2626; padding: 6px 10px; font-size:0.8rem;">ลบ</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align: center; color: var(--text-muted); padding: 50px;">
                        <div style="font-size: 3rem; margin-bottom: 10px;">📦</div>
                        <div>{{ request('search') ? 'ไม่พบสินค้าที่ค้นหา' : 'ยังไม่มีรายการสินค้าในระบบ' }}</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages())
    <div style="padding: 15px; border-top: 1px solid #eee; display: flex; justify-content: center;">
        {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>
@endsection
