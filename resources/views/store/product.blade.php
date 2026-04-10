<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | บ้านครีม สิงห์บุรี</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --green: #22c55e;
            --green-soft: #e9faef;
            --pink: #ef4f8b;
            --ink: #152034;
            --muted: #708198;
            --border: #e7edf3;
            --page: #f7fafc;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Prompt', sans-serif; background: var(--page); color: var(--ink); }
        a { color: inherit; text-decoration: none; }
        img { display: block; max-width: 100%; }
        .shell { max-width: 1280px; margin: 0 auto; padding: 24px 24px 72px; }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 22px;
        }
        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 1.9rem;
            font-weight: 700;
            color: #62bda2;
        }
        .brand-badge {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: linear-gradient(135deg, #59bb9a, #8dd2bc);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .top-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .nav-pill {
            padding: 12px 18px;
            border: 1px solid var(--border);
            border-radius: 999px;
            background: white;
            font-weight: 600;
        }
        .panel {
            background: white;
            border: 1px solid var(--border);
            border-radius: 36px;
            box-shadow: 0 24px 50px rgba(21, 32, 52, 0.08);
            overflow: hidden;
        }
        .product-layout {
            display: grid;
            grid-template-columns: minmax(360px, 540px) 1fr;
        }
        .gallery {
            background: linear-gradient(180deg, #fef0f6 0%, #f7fbff 100%);
            padding: 28px;
        }
        .gallery-main {
            background: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 14px 35px rgba(33, 57, 90, 0.1);
        }
        .gallery-main img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
        }
        .gallery-main .placeholder {
            width: 100%;
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ba7b7;
        }
        .thumb-row {
            margin-top: 16px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(88px, 1fr));
            gap: 12px;
        }
        .thumb {
            border-radius: 18px;
            overflow: hidden;
            border: 2px solid transparent;
            background: white;
            cursor: pointer;
            padding: 0;
        }
        .thumb.active { border-color: var(--pink); }
        .thumb img { width: 100%; aspect-ratio: 1 / 1; object-fit: cover; }
        .details { padding: 36px 34px; }
        .tag {
            display: inline-flex;
            padding: 7px 12px;
            border-radius: 999px;
            background: #edf9f4;
            color: #1f9d68;
            font-size: 0.8rem;
            font-weight: 700;
            margin-bottom: 12px;
        }
        h1 {
            font-size: clamp(2rem, 4vw, 3.5rem);
            line-height: 1.08;
            margin-bottom: 10px;
        }
        .sub-meta {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            color: var(--muted);
            margin-bottom: 14px;
        }
        .primary-price {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 12px;
        }
        .wholesale-box {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            padding: 16px 18px;
            border-radius: 20px;
            background: var(--green-soft);
            color: #11804d;
            font-weight: 700;
        }
        .variant-list {
            display: grid;
            gap: 10px;
            margin: 24px 0;
        }
        .variant-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            border: 1px solid var(--border);
            border-radius: 18px;
            background: white;
            padding: 16px 18px;
            cursor: pointer;
            transition: 0.2s ease;
        }
        .variant-option.active {
            border-color: #f4a2c4;
            background: #fff5fa;
            box-shadow: 0 10px 24px rgba(239, 79, 139, 0.08);
        }
        .variant-name { font-weight: 700; margin-bottom: 4px; }
        .variant-meta { color: var(--muted); font-size: 0.9rem; }
        .variant-price { text-align: right; font-weight: 700; }
        .description {
            color: var(--muted);
            line-height: 1.8;
            margin: 14px 0 26px;
        }
        .cta-stack { display: grid; gap: 12px; }
        .cta-button {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 18px 20px;
            font-family: inherit;
            font-size: 1.08rem;
            font-weight: 700;
            background: white;
            color: var(--pink);
            cursor: pointer;
        }
        .cta-button.primary {
            background: linear-gradient(135deg, #12c758, #10b34e);
            color: white;
            border-color: transparent;
        }
        .related { margin-top: 52px; }
        .related h2 { font-size: 2rem; margin-bottom: 18px; }
        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }
        .related-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 24px;
            overflow: hidden;
        }
        .related-card img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            background: #f4f7fb;
        }
        .related-card-body { padding: 16px; }
        .related-card-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 6px;
            min-height: 2.8em;
        }
        .related-card-price { font-weight: 700; }
        @media (max-width: 920px) {
            .shell { padding: 16px 16px 72px; }
            .product-layout { grid-template-columns: 1fr; }
            .topbar { flex-direction: column; align-items: stretch; }
            .top-actions { justify-content: flex-start; flex-wrap: wrap; }
        }
    </style>
</head>
<body>
    <div class="shell">
        <div class="topbar">
            <a href="{{ route('home') }}" class="brand">
                <span class="brand-badge">บ</span>
                <span>บ้านครีม</span>
            </a>
            <div class="top-actions">
                <a href="{{ route('home') }}" class="nav-pill">กลับไปหน้าสินค้า</a>
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="nav-pill">บัญชีของฉัน</a>
                @else
                    <a href="{{ route('login') }}" class="nav-pill">เข้าสู่ระบบ</a>
                @endauth
            </div>
        </div>

        <section class="panel">
            <div class="product-layout">
                <div class="gallery">
                    <div class="gallery-main" id="galleryMain">
                        @php $mainImage = $selectedVariant?->image ?: $product->image; @endphp
                        @if($mainImage)
                            <img id="mainImage" src="{{ asset('storage/' . $mainImage) }}" alt="{{ $product->name }}">
                        @else
                            <div class="placeholder" id="mainImage">No Image</div>
                        @endif
                    </div>

                    @if($product->variants->isNotEmpty())
                        <div class="thumb-row">
                            @foreach($product->variants as $variant)
                                @php $imagePath = $variant->image ?: $product->image; @endphp
                                <button type="button" class="thumb {{ $selectedVariant && $selectedVariant->id === $variant->id ? 'active' : '' }}"
                                    data-variant-thumb
                                    data-variant-id="{{ $variant->id }}"
                                    data-variant-image="{{ $imagePath ? asset('storage/' . $imagePath) : '' }}"
                                    data-variant-retail="{{ number_format($variant->retail_price, 2, '.', '') }}"
                                    data-variant-wholesale="{{ number_format($variant->wholesale_price, 2, '.', '') }}"
                                    data-variant-stock="{{ $variant->stock }}">
                                    @if($imagePath)
                                        <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $variant->name }}">
                                    @else
                                        <img src="https://placehold.co/400x400/f4f7fb/99a4b5?text=No+Image" alt="No Image">
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="details">
                    @if($product->category)
                        <div class="tag">{{ $product->category->name }}</div>
                    @endif
                    <h1>{{ $product->name }}</h1>
                    <div class="sub-meta">
                        @if($product->brand)<span>แบรนด์ {{ $product->brand->name }}</span>@endif
                        @if($product->hasVariants())<span>มี {{ $product->variants->count() }} สูตร</span>@endif
                    </div>

                    <div class="primary-price" id="retailPrice">฿{{ number_format($selectedVariant?->retail_price ?? $product->retail_price, 2) }}</div>
                    <div class="wholesale-box">
                        <span>ส่ง 10 ชิ้น</span>
                        <strong id="wholesalePrice">฿{{ number_format($selectedVariant?->wholesale_price ?? $product->wholesale_price, 2) }}</strong>
                        <span id="stockText">มีสินค้า {{ $selectedVariant?->stock ?? 'พร้อมขาย' }} ชิ้น</span>
                    </div>

                    @if($product->variants->isNotEmpty())
                        <div class="variant-list">
                            @foreach($product->variants as $variant)
                                @php $imagePath = $variant->image ?: $product->image; @endphp
                                <button type="button" class="variant-option {{ $selectedVariant && $selectedVariant->id === $variant->id ? 'active' : '' }}"
                                    data-variant-option
                                    data-variant-id="{{ $variant->id }}"
                                    data-variant-image="{{ $imagePath ? asset('storage/' . $imagePath) : '' }}"
                                    data-variant-retail="{{ number_format($variant->retail_price, 2, '.', '') }}"
                                    data-variant-wholesale="{{ number_format($variant->wholesale_price, 2, '.', '') }}"
                                    data-variant-stock="{{ $variant->stock }}">
                                    <div>
                                        <div class="variant-name">{{ $variant->name }}</div>
                                        <div class="variant-meta">{{ $variant->sku ?: 'สูตรสินค้า' }} · คงเหลือ {{ $variant->stock }} ชิ้น</div>
                                    </div>
                                    <div class="variant-price">
                                        <div>ปลีก ฿{{ number_format($variant->retail_price, 2) }}</div>
                                        <div style="color:#16a34a;">ส่ง ฿{{ number_format($variant->wholesale_price, 2) }}</div>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <p class="description">{{ $product->description ?: 'ไม่มีรายละเอียดสินค้าเพิ่มเติมสำหรับรายการนี้' }}</p>

                    <div class="cta-stack">
                        <form method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="variant_id" id="singleVariantId" value="{{ $selectedVariant?->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="cta-button">เพิ่ม (สั่ง 1 ชิ้น) <span id="singlePriceText">฿{{ number_format($selectedVariant?->retail_price ?? $product->retail_price, 2) }}</span></button>
                        </form>

                        <form method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="variant_id" id="bulkVariantId" value="{{ $selectedVariant?->id }}">
                            <input type="hidden" name="quantity" value="10">
                            <button type="submit" class="cta-button primary">เพิ่ม (สั่ง 10 ชิ้น) <span id="bulkPriceText">฿{{ number_format(($selectedVariant?->wholesale_price ?? $product->wholesale_price) * 10, 2) }}</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="related">
            <h2>สินค้าที่คุณอาจชอบ</h2>
            <div class="related-grid">
                @foreach($relatedProducts as $item)
                    <a href="{{ route('products.show', $item) }}" class="related-card">
                        @if($item->displayImage())
                            <img src="{{ asset('storage/' . $item->displayImage()) }}" alt="{{ $item->name }}">
                        @else
                            <img src="https://placehold.co/500x500/f4f7fb/99a4b5?text=No+Image" alt="No Image">
                        @endif
                        <div class="related-card-body">
                            <div class="related-card-title">{{ $item->name }}</div>
                            <div class="related-card-price">เริ่มต้น ฿{{ number_format($item->displayRetailPrice(), 2) }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    </div>

    @include('store.partials.floating-cart', [
        'cartCount' => $cartCount,
        'cartItems' => $cartSummary['items'],
        'cartTotal' => $cartSummary['total'],
    ])

    <script>
        const variantOptions = Array.from(document.querySelectorAll('[data-variant-option]'));
        const variantThumbs = Array.from(document.querySelectorAll('[data-variant-thumb]'));
        const galleryMain = document.getElementById('galleryMain');
        const retailPrice = document.getElementById('retailPrice');
        const wholesalePrice = document.getElementById('wholesalePrice');
        const stockText = document.getElementById('stockText');
        const singleVariantId = document.getElementById('singleVariantId');
        const bulkVariantId = document.getElementById('bulkVariantId');
        const singlePriceText = document.getElementById('singlePriceText');
        const bulkPriceText = document.getElementById('bulkPriceText');

        function activateVariant(dataset) {
            if (!dataset) return;
            const currentMainImage = document.getElementById('mainImage');
            if (dataset.variantImage && galleryMain) {
                if (currentMainImage && currentMainImage.tagName === 'IMG') {
                    currentMainImage.src = dataset.variantImage;
                } else {
                    galleryMain.innerHTML = `<img id="mainImage" src="${dataset.variantImage}" alt="{{ addslashes($product->name) }}">`;
                }
            }
            retailPrice.textContent = `฿${Number(dataset.variantRetail).toFixed(2)}`;
            wholesalePrice.textContent = `฿${Number(dataset.variantWholesale).toFixed(2)}`;
            stockText.textContent = `มีสินค้า ${dataset.variantStock} ชิ้น`;
            singlePriceText.textContent = `฿${Number(dataset.variantRetail).toFixed(2)}`;
            bulkPriceText.textContent = `฿${(Number(dataset.variantWholesale) * 10).toFixed(2)}`;
            if (singleVariantId) singleVariantId.value = dataset.variantId;
            if (bulkVariantId) bulkVariantId.value = dataset.variantId;
            variantOptions.forEach((option) => option.classList.toggle('active', option.dataset.variantId === dataset.variantId));
            variantThumbs.forEach((thumb) => thumb.classList.toggle('active', thumb.dataset.variantId === dataset.variantId));
        }

        variantOptions.forEach((option) => option.addEventListener('click', () => activateVariant(option.dataset)));
        variantThumbs.forEach((thumb) => thumb.addEventListener('click', () => activateVariant(thumb.dataset)));
    </script>
</body>
</html>
