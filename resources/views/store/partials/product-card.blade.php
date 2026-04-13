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

    <form method="POST" action="{{ route('cart.add') }}" class="product-add-form" data-ajax-cart-form>
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="quantity" value="1">
        <button type="submit" class="product-add-button" aria-label="เพิ่ม {{ $product->name }} ลงตะกร้า">+</button>
    </form>
</article>
