@php
    $categoryName = $product->categories->first()?->name ?? 'สินค้า';
    $imagePath = $product->displayImage();
    $retailPrice = $product->displayRetailPrice();
    $wholesaleBundlePrice = $product->displayWholesaleBundlePrice();
    $wholesaleMinQty = $product->displayWholesaleMinQty();
    $stockQty = max(0, (int) ($product->stock ?? 0));
@endphp

<article
    class="product-card {{ $cardClass ?? '' }}"
    @foreach(($cardAttributes ?? []) as $attribute => $value)
        {!! $attribute !!}="{{ e($value) }}"
    @endforeach
>
    <a class="product-card-link" href="{{ route('products.show', $product) }}" aria-label="{{ $product->name }}">
        <div class="product-image">
            @if($imagePath)
                <img src="{{ $mediaUrl($imagePath) }}" alt="{{ $product->name }}">
            @else
                <span>No Image</span>
            @endif
        </div>
        <div class="product-body">
            <span class="product-category-badge">{{ $categoryName }}</span>
            <h3 class="product-name">{{ $product->name }}</h3>
            <div class="product-price">
                <div class="price-row">
                    <span>ปลีก</span>
                    <strong>฿{{ number_format($retailPrice, 2) }}</strong>
                </div>
                <div class="price-row price-row-wholesale">
                    <span>ส่ง {{ $wholesaleMinQty }} ชิ้น</span>
                    <strong>฿{{ number_format($wholesaleBundlePrice, 2) }}</strong>
                </div>
            </div>
            <div class="product-stock">คงเหลือ: <strong>{{ number_format($stockQty) }}</strong> ชิ้น</div>
        </div>
    </a>

    <div class="product-add-context" style="position: absolute; right: 14px; bottom: 14px; z-index: 10;">
        <button type="button" class="product-add-button" data-toggle-selection aria-label="เพิ่ม {{ $product->name }} ลงตะกร้า">+</button>
        
        <div class="selection-popover" style="display:none; position:absolute; bottom:calc(100% + 10px); right:0; background:white; border-radius:18px; box-shadow:0 15px 40px rgba(15, 23, 42, 0.18); width:196px; padding:10px; border:1px solid #e7ebf3; overflow:hidden;">
            <div style="font-size:0.75rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em; padding:4px 8px 8px;">เลือกประเภทการขาย</div>
            
            {{-- Retail Option --}}
            <form method="POST" action="{{ route('cart.add') }}" data-ajax-cart-form style="margin:0;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="popover-item" style="width:100%; display:flex; align-items:center; justify-content:space-between; padding:11px 12px; border:none; background:none; cursor:pointer; font-family:inherit; border-radius:12px; transition:0.2s;">
                    <span style="font-weight:600; font-size:0.88rem; color:#152034;">🛒 ปลีก (1)</span>
                    <span style="font-size:0.8rem; color:#62708a;">฿{{ number_format($retailPrice, 0) }}</span>
                </button>
            </form>

            <div style="height:1px; background:#f1f5f9; margin:6px 8px;"></div>
            
            {{-- Wholesale Option --}}
            <form method="POST" action="{{ route('cart.add') }}" data-ajax-cart-form style="margin:0;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="{{ $wholesaleMinQty }}">
                <button type="submit" class="popover-item" style="width:100%; display:flex; align-items:center; justify-content:space-between; padding:11px 12px; border:none; background:none; cursor:pointer; font-family:inherit; border-radius:12px; transition:0.2s;">
                    <span style="font-weight:600; font-size:0.88rem; color:#06a45f;">📦 ส่ง ({{ $wholesaleMinQty }})</span>
                    <span style="font-size:0.8rem; color:#06a45f;">฿{{ number_format($wholesaleBundlePrice, 0) }}</span>
                </button>
            </form>
        </div>
    </div>

    <style>
        .popover-item:hover { background: #f8fafc; }
    </style>
</article>
