@php
    $mediaUrl = fn (?string $path) => $path ? '/media/' . ltrim($path, '/') : null;
    $cartItems = $cartItems ?? [];
@endphp

@forelse($cartItems as $item)
    <div style="border:1px solid #e7edf3; border-radius:20px; padding:12px; display:grid; gap:12px;" data-cart-item-id="{{ $item['id'] ?? '' }}">
        <div style="display:flex; gap:12px; align-items:flex-start;">
            <div style="width:64px; height:64px; border-radius:14px; overflow:hidden; flex:0 0 auto; background:#f3f6fb;">
                @if(!empty($item['image']))
                    <img src="{{ $mediaUrl($item['image']) }}" alt="{{ $item['name'] ?? 'สินค้า' }}" style="width:100%; height:100%; object-fit:contain; padding:6px; mix-blend-mode:multiply;">
                @else
                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#94a3b8; font-size:0.7rem;">No image</div>
                @endif
            </div>
            <div style="min-width:0; flex:1;">
                <div style="font-weight:700; color:#152034; line-height:1.3; font-size:0.95rem;">{{ $item['name'] ?? 'สินค้า' }}</div>
                @if(!empty($item['variant_name']))
                    <div style="margin-top:4px; display:inline-flex; padding:3px 8px; border-radius:999px; background:#fff1f5; color:#e11d72; font-size:0.75rem; font-weight:700;">{{ $item['variant_name'] }}</div>
                @endif
                @if(!empty($item['uses_wholesale']))
                    <div style="margin-top:4px; display:inline-flex; padding:3px 8px; border-radius:999px; background:#e9faef; color:#15803d; font-size:0.75rem; font-weight:700;">ราคาส่ง {{ $item['wholesale_min_qty'] ?? 1 }} ชิ้น</div>
                @endif
                <div style="margin-top:8px; display:flex; align-items:center; gap:10px;">
                    <div style="color:#708198; font-size:0.88rem;">฿{{ number_format((float) ($item['unit_price'] ?? 0), 2) }}</div>
                    
                    {{-- Quantity Controls --}}
                    <div style="margin-left:auto; display:flex; align-items:center; background:#f3f6fb; border-radius:999px; padding:2px;">
                        <button type="button" 
                                class="cart-qty-btn" 
                                data-action="minus" 
                                data-id="{{ $item['id'] }}"
                                style="width:28px; height:28px; border:none; border-radius:50%; background:white; color:#152034; cursor:pointer; display:flex; align-items:center; justify-content:center; font-weight:700; box-shadow:0 2px 5px rgba(0,0,0,0.05);">-</button>
                        
                        <span style="min-width:30px; text-align:center; font-weight:700; font-size:0.88rem;">{{ $item['quantity'] }}</span>
                        
                        <button type="button" 
                                class="cart-qty-btn" 
                                data-action="plus" 
                                data-id="{{ $item['id'] }}"
                                style="width:28px; height:28px; border:none; border-radius:50%; background:white; color:#152034; cursor:pointer; display:flex; align-items:center; justify-content:center; font-weight:700; box-shadow:0 2px 5px rgba(0,0,0,0.05);">+</button>
                    </div>
                </div>
            </div>
        </div>
        <div style="display:flex; justify-content:space-between; align-items:center; gap:10px; border-top:1px solid #f1f5f9; pt:10px; margin-top:2px;">
            <div style="font-size:0.95rem; font-weight:700; color:#152034;">฿{{ number_format((float) ($item['subtotal'] ?? 0), 2) }}</div>
            <form action="{{ route('cart.remove') }}" method="POST" style="margin:0;" data-ajax-cart-remove>
                @csrf
                <input type="hidden" name="id" value="{{ $item['id'] ?? '' }}">
                <button type="submit" style="border:none; border-radius:999px; padding:7px 11px; background:#fff1f2; color:#dc2626; font-family:inherit; font-weight:700; cursor:pointer; font-size:0.78rem;">ลบออก</button>
            </form>
        </div>
    </div>
@empty
    <div style="padding:40px 24px; border:1px dashed #cbd5e1; border-radius:24px; text-align:center; color:#708198;">
        <div style="font-size:2rem; margin-bottom:14px;">🛒</div>
        <div>ยังไม่มีสินค้าในตะกร้า</div>
    </div>
@endforelse
