<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | บ้านครีม สิงห์บุรี</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ff4f87;
            --primary-dark: #e93574;
            --accent-color: #1fbad6;
            --gold-color: #f8c64f;
            --text-dark: #1a2233;
            --text-soft: #62708a;
            --border-color: #e7ebf3;
            --surface-color: #ffffff;
            --page-color: #f6f8fc;
            --success-soft: #e9fff5;
            --success-text: #117a4d;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Prompt', sans-serif; background: var(--page-color); color: var(--text-dark); }
        a { color: inherit; text-decoration: none; }
        img { display: block; max-width: 100%; }
        button, input { font: inherit; }

        .top-strip {
            background: linear-gradient(90deg, #8b5cf6 0%, #ff2d76 35%, #ff5f6d 68%, #35c98b 100%);
            color: white;
            padding: 10px 24px;
            font-size: 0.95rem;
        }
        .top-strip-inner {
            max-width: 1440px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .top-strip-badges {
            display: flex;
            gap: 22px;
            flex-wrap: wrap;
        }

        .header-shell {
            position: sticky;
            top: 0;
            z-index: 20;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(16px);
            box-shadow: 0 12px 30px rgba(40, 58, 100, 0.06);
        }
        .header-main {
            max-width: 1440px;
            min-height: 82px;
            margin: 0 auto;
            padding: 0 24px;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 24px;
        }
        .brand-logo {
            display: inline-flex;
            align-items: center;
            font-size: 2.35rem;
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: -0.04em;
        }
        .brand-logo-image {
            height: 56px;
            width: auto;
            object-fit: contain;
        }
        .brand-logo span:nth-child(2) { color: #6a67ff; }
        .brand-logo span:nth-child(3) { color: #22c1dc; }
        .brand-logo span:nth-child(4) { color: #f8c64f; }
        .brand-logo span:nth-child(5) { color: #35c98b; }
        .main-links {
            display: flex;
            gap: 28px;
            align-items: center;
            font-weight: 500;
            overflow-x: auto;
            white-space: nowrap;
        }
        .main-links a:hover { color: var(--primary-color); }
        .header-tools {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .search-box {
            width: min(340px, 36vw);
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f7f8fb;
            border: 1px solid var(--border-color);
            border-radius: 999px;
            padding: 12px 18px;
            color: var(--text-soft);
        }
        .search-box input {
            width: 100%;
            border: none;
            background: transparent;
            outline: none;
            color: var(--text-dark);
        }
        .user-action,
        .pill-link {
            border: 1px solid var(--border-color);
            border-radius: 999px;
            padding: 10px 18px;
            font-weight: 500;
            background: white;
        }
        .user-action:hover,
        .pill-link:hover {
            border-color: rgba(255, 79, 135, 0.35);
            color: var(--primary-color);
        }

        .notice {
            max-width: 1440px;
            margin: 24px auto 0;
            padding: 0 24px;
        }
        .notice-box {
            background: var(--success-soft);
            color: var(--success-text);
            border: 1px solid #b8f0d6;
            padding: 14px 18px;
            border-radius: 18px;
        }

        .page-section {
            max-width: 1440px;
            margin: 0 auto;
            padding: 28px 24px 56px;
        }
        .product-shell {
            display: grid;
            grid-template-columns: minmax(360px, 620px) minmax(340px, 1fr);
            gap: 28px;
            align-items: start;
        }
        .surface-card {
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 32px;
            box-shadow: 0 18px 50px rgba(29, 41, 76, 0.08);
        }
        .gallery-card {
            padding: 22px;
            background: linear-gradient(135deg, #fff2f6 0%, #f2f9ff 100%);
        }
        .gallery-main {
            background: white;
            border-radius: 28px;
            overflow: hidden;
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 16px 44px rgba(29, 41, 76, 0.08);
            cursor: zoom-in;
        }
        .gallery-main img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .gallery-main .placeholder {
            color: #9aa7bd;
            font-size: 1rem;
        }
        .thumb-row {
            margin-top: 16px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(92px, 1fr));
            gap: 12px;
        }
        .thumb {
            border-radius: 18px;
            overflow: hidden;
            border: 2px solid transparent;
            background: white;
            padding: 0;
            cursor: pointer;
            box-shadow: 0 10px 26px rgba(29, 41, 76, 0.06);
        }
        .thumb.active { border-color: var(--primary-color); }
        .thumb img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
        }
        .lightbox {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: rgba(17, 24, 39, 0.72);
            z-index: 80;
        }
        .lightbox.is-open {
            display: flex;
        }
        .lightbox-dialog {
            width: min(1120px, 100%);
            max-height: calc(100vh - 48px);
            background: white;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 30px 90px rgba(15, 23, 42, 0.35);
            display: grid;
            grid-template-columns: minmax(0, 1fr) 180px;
        }
        .lightbox-stage {
            min-height: 0;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .lightbox-stage img {
            width: 100%;
            height: auto;
            max-height: calc(100vh - 120px);
            object-fit: contain;
        }
        .lightbox-sidebar {
            border-left: 1px solid var(--border-color);
            padding: 18px;
            display: grid;
            grid-template-rows: auto 1fr;
            gap: 16px;
            background: white;
        }
        .lightbox-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .lightbox-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
        }
        .lightbox-close {
            width: 38px;
            height: 38px;
            border: none;
            border-radius: 999px;
            background: #f3f6fb;
            color: var(--text-dark);
            cursor: pointer;
        }
        .lightbox-thumbs {
            display: grid;
            gap: 10px;
            align-content: start;
            overflow: auto;
        }
        .lightbox-thumb {
            border: 2px solid transparent;
            border-radius: 16px;
            overflow: hidden;
            padding: 0;
            background: #f8fafc;
            cursor: pointer;
        }
        .lightbox-thumb.active {
            border-color: var(--primary-color);
        }
        .lightbox-thumb img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
        }

        .detail-card {
            padding: 30px;
        }
        .breadcrumb {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            color: var(--text-soft);
            font-size: 0.92rem;
            margin-bottom: 18px;
        }
        .breadcrumb a:hover { color: var(--primary-color); }
        .product-meta {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 14px;
        }
        .product-badge {
            background: #fff4f8;
            color: var(--primary-color);
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 0.78rem;
            font-weight: 600;
        }
        .product-badge.brand {
            background: #eef8ff;
            color: var(--accent-color);
        }
        .product-badge.success {
            background: #edf9f4;
            color: #1f9d68;
        }
        .product-title {
            font-size: clamp(2.2rem, 4.5vw, 4rem);
            line-height: 1.05;
            margin-bottom: 12px;
        }
        .product-subtitle {
            color: var(--text-soft);
            line-height: 1.7;
            margin-bottom: 22px;
        }
        .price-panel {
            display: grid;
            gap: 14px;
            padding: 20px 22px;
            border: 1px solid var(--border-color);
            border-radius: 24px;
            background: linear-gradient(135deg, #fff8ee 0%, #ffffff 55%);
            margin-bottom: 22px;
        }
        .price-main {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 16px;
            flex-wrap: wrap;
        }
        .price-label {
            color: var(--text-soft);
            font-size: 0.92rem;
        }
        .price-retail {
            font-size: 3rem;
            line-height: 1;
            font-weight: 800;
            color: var(--text-dark);
        }
        .price-wholesale {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            color: #1f9d68;
            background: #edf9f4;
            border-radius: 999px;
            padding: 10px 16px;
            font-weight: 700;
        }
        .variant-panel-title {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 14px;
        }
        .variant-select-shell {
            display: grid;
            gap: 14px;
            margin-bottom: 22px;
        }
        .variant-current {
            border: 1px solid var(--border-color);
            border-radius: 22px;
            padding: 16px 18px;
            background: #fbfcff;
        }
        .variant-current-label {
            color: var(--text-soft);
            font-size: 0.88rem;
            margin-bottom: 6px;
        }
        .variant-current-name {
            font-size: 1.02rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }
        .variant-current-meta {
            color: var(--text-soft);
            font-size: 0.92rem;
        }
        .variant-picker {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 4px;
        }
        .variant-option {
            width: 76px;
            min-width: 76px;
            border: 2px solid transparent;
            border-radius: 18px;
            background: white;
            padding: 0;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 10px 24px rgba(29, 41, 76, 0.08);
            transition: 0.2s ease;
        }
        .variant-option:hover {
            transform: translateY(-1px);
        }
        .variant-option.active {
            border-color: var(--primary-color);
            box-shadow: 0 14px 28px rgba(233, 53, 116, 0.12);
        }
        .variant-option img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            background: #f8fafc;
        }
        .variant-option span {
            display: block;
            padding: 8px 6px;
            font-size: 0.72rem;
            line-height: 1.3;
            font-weight: 600;
            color: var(--text-soft);
            text-align: center;
        }
        .description-card {
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 20px 22px;
            background: #fbfcff;
            color: var(--text-soft);
            line-height: 1.9;
            margin-bottom: 22px;
        }
        .cta-stack {
            display: grid;
            gap: 12px;
        }
        .cta-button {
            width: 100%;
            border: 1px solid var(--border-color);
            background: white;
            color: var(--primary-color);
            border-radius: 999px;
            padding: 16px 20px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s ease;
        }
        .cta-button:hover {
            border-color: rgba(255, 79, 135, 0.35);
            transform: translateY(-1px);
        }
        .cta-button.primary {
            border: none;
            background: linear-gradient(135deg, var(--gold-color), #ffb340);
            color: #46260a;
        }

        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 20px;
            margin-bottom: 24px;
        }
        .section-title {
            font-size: 2rem;
            line-height: 1.15;
        }
        .section-subtitle {
            color: var(--text-soft);
            margin-top: 8px;
        }
        .section-pill {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 999px;
            padding: 10px 18px;
            color: var(--text-soft);
        }
        .section-pill:hover {
            color: var(--primary-color);
            border-color: rgba(255, 79, 135, 0.3);
        }
        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 22px;
        }
        .product-card {
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 26px;
            overflow: hidden;
            box-shadow: 0 18px 50px rgba(29, 41, 76, 0.08);
        }
        .product-image {
            aspect-ratio: 1 / 1;
            background: linear-gradient(135deg, #f8f0f3 0%, #eef7ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .product-image span {
            color: #9aa7bd;
            font-size: 0.95rem;
        }
        .product-body {
            padding: 18px;
        }
        .product-name {
            font-size: 1.06rem;
            font-weight: 600;
            margin-bottom: 8px;
            min-height: 3.2em;
        }
        .product-desc {
            color: var(--text-soft);
            font-size: 0.92rem;
            min-height: 3.9em;
            margin-bottom: 16px;
        }
        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 12px;
        }
        .buy-button {
            border: none;
            background: linear-gradient(135deg, var(--gold-color), #ffb340);
            color: #46260a;
            border-radius: 999px;
            padding: 10px 16px;
            font-family: inherit;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 1080px) {
            .header-main {
                grid-template-columns: 1fr;
                padding-top: 16px;
                padding-bottom: 16px;
            }
            .header-tools {
                flex-wrap: wrap;
                justify-content: flex-start;
            }
            .search-box { width: 100%; }
            .product-shell {
                grid-template-columns: 1fr;
            }
            .lightbox-dialog {
                grid-template-columns: 1fr;
            }
            .lightbox-sidebar {
                border-left: none;
                border-top: 1px solid var(--border-color);
            }
            .lightbox-thumbs {
                grid-template-columns: repeat(auto-fit, minmax(72px, 1fr));
            }
        }

        @media (max-width: 720px) {
            .top-strip { padding: 10px 16px; }
            .header-main,
            .notice,
            .page-section { padding-left: 16px; padding-right: 16px; }
            .brand-logo { font-size: 2rem; }
            .detail-card,
            .gallery-card { padding: 18px; }
            .product-title { font-size: 2.3rem; }
            .section-title { font-size: 1.6rem; }
            .price-main,
            .product-footer,
            .section-head { flex-direction: column; align-items: stretch; }
        }
    </style>
</head>
<body>
    @php
        $productName = (string) data_get($product, 'name', 'สินค้า');
        $productDescription = (string) data_get($product, 'description', '');
        $firstCategory = $product->categories->first();
        $categoryName = $firstCategory ? $firstCategory->name : null;
        $categorySlug = $firstCategory ? $firstCategory->slug : null;
        $selectedRetailPrice = (float) (data_get($selectedVariant, 'retail_price') ?? data_get($product, 'retail_price', 0));
        $selectedWholesalePrice = (float) (data_get($selectedVariant, 'wholesale_price') ?? data_get($product, 'wholesale_price', 0));
        $selectedStock = data_get($selectedVariant, 'stock');
        $mainImage = data_get($selectedVariant, 'image') ?: data_get($product, 'image');
        $selectedVariantName = (string) data_get($selectedVariant, 'name', 'สูตรเริ่มต้น');
        $selectedVariantSku = (string) (data_get($selectedVariant, 'sku') ?: 'สูตรสินค้า');
    @endphp
    <div class="top-strip">
        <div class="top-strip-inner">
            <div class="top-strip-badges">
                <span>ซื้อครบตามเงื่อนไข รับโปรพิเศษ</span>
                <span>อัปเดตสินค้าใหม่จากหลังบ้านได้ตลอด</span>
                <span>เลือกสูตรและดูรูปสินค้าได้จากหน้านี้</span>
            </div>
            <span>บ้านครีม สิงห์บุรี</span>
        </div>
    </div>

    <header class="header-shell">
        <div class="header-main">
            <a href="{{ route('home') }}" class="brand-logo" aria-label="บ้านครีม สิงห์บุรี">
                @include('store.partials.site-logo-markup')
            </a>

            <nav class="main-links" aria-label="เมนูหลัก">
                <a href="{{ route('home') }}#catalog">หมวดหมู่</a>
                <a href="{{ route('home') }}#catalog">สินค้าใหม่</a>
                <a href="{{ route('home') }}#catalog">สินค้าแนะนำ</a>
                <a href="{{ route('home') }}#catalog">สินค้าทั้งหมด</a>
            </nav>

            <div class="header-tools">
                <label class="search-box" for="searchDisplay">
                    <span>🔍</span>
                    <input type="text" id="searchDisplay" value="{{ $product->name }}" readonly>
                </label>
                <a href="{{ route('home') }}" class="pill-link">กลับไปหน้าสินค้า</a>
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="user-action">บัญชีของฉัน</a>
                @else
                    <button type="button" class="user-action" data-open-auth data-auth-mode="login" style="font-family: inherit; cursor: pointer;">เข้าสู่ระบบ</button>
                @endauth
            </div>
        </div>
    </header>

    @if(session('success'))
        <div class="notice">
            <div class="notice-box">{{ session('success') }}</div>
        </div>
    @endif

    <section class="page-section">
        <div class="product-shell">
            <div class="surface-card gallery-card">
                <div class="gallery-main" id="galleryMain" aria-label="กดเพื่อขยายรูปสินค้า">
                    @if($mainImage)
                        <img id="mainImage" src="{{ asset('storage/' . $mainImage) }}" alt="{{ $productName }}">
                    @else
                        <div class="placeholder" id="mainImage">No Image</div>
                    @endif
                </div>

                @if($product->variants->isNotEmpty() || !empty($product->images))
                    <div class="thumb-row">
                        @if(!empty($product->images))
                            @foreach($product->images as $index => $img)
                                <button type="button" class="thumb {{ $index === 0 && !$selectedVariant ? 'active' : '' }}"
                                    data-variant-thumb
                                    data-variant-id=""
                                    data-variant-image="{{ asset('storage/' . $img) }}"
                                    data-variant-retail="{{ number_format($selectedRetailPrice, 2, '.', '') }}"
                                    data-variant-wholesale="{{ number_format($selectedWholesalePrice, 2, '.', '') }}"
                                    data-variant-stock="{{ $selectedStock }}"
                                    data-variant-sku=""
                                    data-variant-name="{{ $productName }}">
                                    <img src="{{ asset('storage/' . $img) }}" alt="{{ $productName }}">
                                </button>
                            @endforeach
                        @endif

                        @foreach($product->variants as $variant)
                            @php $imagePath = $variant->image ?: $product->displayImage(); @endphp
                            <button type="button" class="thumb {{ $selectedVariant && $selectedVariant->id === $variant->id ? 'active' : '' }}"
                                data-variant-thumb
                                data-variant-id="{{ $variant->id }}"
                                data-variant-image="{{ $imagePath ? asset('storage/' . $imagePath) : '' }}"
                                data-variant-retail="{{ number_format($variant->retail_price, 2, '.', '') }}"
                                data-variant-wholesale="{{ number_format($variant->wholesale_price, 2, '.', '') }}"
                                data-variant-stock="{{ $variant->stock }}"
                                data-variant-sku="{{ data_get($variant, 'sku') ?: 'สูตรสินค้า' }}"
                                data-variant-name="{{ (string) data_get($variant, 'name', 'สูตรสินค้า') }}">
                                @if($imagePath)
                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ (string) data_get($variant, 'name', 'สูตรสินค้า') }}">
                                @else
                                    <img src="https://placehold.co/400x400/f4f7fb/99a4b5?text=No+Image" alt="No Image">
                                @endif
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="surface-card detail-card">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}">หน้าแรก</a>
                    <span>/</span>
                    @if($categoryName)
                        <a href="{{ route('home') }}{{ $categorySlug ? '#category-' . $categorySlug : '' }}">{{ $categoryName }}</a>
                        <span>/</span>
                    @endif
                    <span>{{ $productName }}</span>
                </div>

                <div class="product-meta">
                    @foreach($product->categories as $pc)
                        <span class="product-badge">{{ $pc->name }}</span>
                    @endforeach
                    @if($product->hasVariants())
                        <span class="product-badge">{{ $product->variants->count() }} สูตร</span>
                    @endif
                    <span class="product-badge success" id="stockText">มีสินค้า {{ $selectedStock ?? 'พร้อมขาย' }} ชิ้น</span>
                </div>

                <h1 class="product-title">{{ $productName }}</h1>
                @if($productDescription !== '')
                    <p class="product-subtitle">{{ $productDescription }}</p>
                @endif

                <div class="price-panel">
                    <div class="price-main">
                        <div>
                            <div class="price-label">ราคาปลีก</div>
                            <div class="price-retail" id="retailPrice">฿{{ number_format($selectedRetailPrice, 2) }}</div>
                        </div>
                        <div class="price-wholesale">
                            <span>ส่ง {{ $product->wholesale_min_qty }} ชิ้น</span>
                            <strong id="wholesalePrice">฿{{ number_format($selectedWholesalePrice, 2) }}</strong>
                        </div>
                    </div>
                </div>

                @if($product->variants->isNotEmpty())
                    <div class="variant-panel-title">เลือกสูตรสินค้า</div>
                    <div class="variant-select-shell">
                        <div class="variant-current">
                            <div class="variant-current-label">สูตรที่เลือก</div>
                            <div class="variant-current-name" id="variantNameText">{{ $selectedVariantName }}</div>
                            <div class="variant-current-meta" id="variantMetaText">{{ $selectedVariantSku }} · คงเหลือ {{ $selectedStock ?? 0 }} ชิ้น</div>
                        </div>
                        <div class="variant-picker">
                            @foreach($product->variants as $variant)
                                @php $imagePath = $variant->image ?: $product->image; @endphp
                                <button type="button" class="variant-option {{ $selectedVariant && $selectedVariant->id === $variant->id ? 'active' : '' }}"
                                    data-variant-option
                                    data-variant-id="{{ $variant->id }}"
                                    data-variant-image="{{ $imagePath ? asset('storage/' . $imagePath) : '' }}"
                                    data-variant-retail="{{ number_format($variant->retail_price, 2, '.', '') }}"
                                    data-variant-wholesale="{{ number_format($variant->wholesale_price, 2, '.', '') }}"
                                    data-variant-stock="{{ $variant->stock }}"
                                    data-variant-sku="{{ data_get($variant, 'sku') ?: 'สูตรสินค้า' }}"
                                    data-variant-name="{{ (string) data_get($variant, 'name', 'สูตรสินค้า') }}">
                                    @if($imagePath)
                                        <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ (string) data_get($variant, 'name', 'สูตรสินค้า') }}">
                                    @else
                                        <img src="https://placehold.co/200x200/f4f7fb/99a4b5?text=No+Image" alt="No Image">
                                    @endif
                                    <span>{{ (string) data_get($variant, 'name', 'สูตรสินค้า') }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="cta-stack">
                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="variant_id" id="singleVariantId" value="{{ data_get($selectedVariant, 'id') }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="cta-button">ใส่ตะกร้า 1 ชิ้น <span id="singlePriceText">฿{{ number_format($selectedRetailPrice, 2) }}</span></button>
                    </form>

                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="variant_id" id="bulkVariantId" value="{{ data_get($selectedVariant, 'id') }}">
                        <input type="hidden" name="quantity" value="{{ $product->wholesale_min_qty }}">
                        <button type="submit" class="cta-button primary">ใส่ตะกร้า {{ $product->wholesale_min_qty }} ชิ้น <span id="bulkPriceText">฿{{ number_format($selectedWholesalePrice * $product->wholesale_min_qty, 2) }}</span></button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section">
        <div class="section-head">
            <div>
                <h2 class="section-title">สินค้าที่คุณอาจชอบ</h2>
            </div>
            <a href="{{ route('home') }}#catalog" class="section-pill">ดูสินค้าทั้งหมด</a>
        </div>

        @if($relatedProducts->isNotEmpty())
            <div class="related-grid">
                @foreach($relatedProducts as $item)
                    <article class="product-card">
                        <a href="{{ route('products.show', $item) }}" class="product-image">
                            @if($item->displayImage())
                                <img src="{{ asset('storage/' . $item->displayImage()) }}" alt="{{ (string) data_get($item, 'name', 'สินค้า') }}">
                            @else
                                <span>No Image</span>
                            @endif
                        </a>
                        <div class="product-body">
                            <div class="product-meta">
                                @if(data_get($item, 'category.name'))
                                    <span class="product-badge">{{ data_get($item, 'category.name') }}</span>
                                @endif
                                @if(data_get($item, 'brand.name'))
                                    <span class="product-badge brand">{{ data_get($item, 'brand.name') }}</span>
                                @endif
                                @if($item->hasVariants())
                                    <span class="product-badge">{{ $item->variants->count() }} สูตร</span>
                                @endif
                            </div>
                            <a href="{{ route('products.show', $item) }}"><h3 class="product-name">{{ (string) data_get($item, 'name', 'สินค้า') }}</h3></a>
                            <p class="product-desc">{{ \Illuminate\Support\Str::limit((string) data_get($item, 'description', ''), 90) }}</p>
                            <div class="product-footer">
                                <div>
                                    <div class="price-retail" style="font-size:1.15rem;">฿{{ number_format((float) $item->displayRetailPrice(), 2) }}</div>
                                    <div class="price-wholesale">ราคาส่ง ฿{{ number_format((float) $item->displayWholesalePrice(), 2) }}</div>
                                </div>
                                <form method="POST" action="{{ route('cart.add') }}" style="margin:0;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                                    <input type="hidden" name="variant_id" value="{{ data_get($item->defaultVariant(), 'id') }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="buy-button">ใส่ตะกร้า</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="surface-card" style="padding:24px; color:var(--text-soft);">ยังไม่มีสินค้าที่เกี่ยวข้องในตอนนี้</div>
        @endif
    </section>

    @include('store.partials.floating-cart', [
        'cartCount' => $cartCount,
        'cartItems' => $cartSummary['items'],
        'cartTotal' => $cartSummary['total'],
    ])
    @guest
        @include('store.partials.auth-modal')
    @endguest

    <div class="lightbox" id="imageLightbox" aria-hidden="true">
        <div class="lightbox-dialog">
            <div class="lightbox-stage">
                <img id="lightboxImage" src="" alt="">
            </div>
            <div class="lightbox-sidebar">
                <div class="lightbox-head">
                    <div class="lightbox-title">ซูมรูปสินค้า</div>
                    <button type="button" class="lightbox-close" id="lightboxClose" aria-label="ปิดรูปขยาย">✕</button>
                </div>
                <div class="lightbox-thumbs">
                    @if($product->variants->isNotEmpty() || !empty($product->images))
                        @if(!empty($product->images))
                            @foreach($product->images as $index => $img)
                                <button type="button" class="lightbox-thumb {{ $index === 0 && !$selectedVariant ? 'active' : '' }}"
                                    data-lightbox-thumb
                                    data-variant-id=""
                                    data-variant-image="{{ asset('storage/' . $img) }}">
                                    <img src="{{ asset('storage/' . $img) }}" alt="{{ $productName }}">
                                </button>
                            @endforeach
                        @endif

                        @foreach($product->variants as $variant)
                            @php $imagePath = $variant->image ?: $product->displayImage(); @endphp
                            <button type="button"
                                class="lightbox-thumb {{ $selectedVariant && $selectedVariant->id === $variant->id ? 'active' : '' }}"
                                data-lightbox-thumb
                                data-variant-id="{{ $variant->id }}"
                                data-variant-image="{{ $imagePath ? asset('storage/' . $imagePath) : '' }}">
                                @if($imagePath)
                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ (string) data_get($variant, 'name', 'สูตรสินค้า') }}">
                                @else
                                    <img src="https://placehold.co/400x400/f4f7fb/99a4b5?text=No+Image" alt="No Image">
                                @endif
                            </button>
                        @endforeach
                    @elseif($mainImage)
                        <button type="button" class="lightbox-thumb active" data-lightbox-thumb data-variant-id="" data-variant-image="{{ asset('storage/' . $mainImage) }}">
                            <img src="{{ asset('storage/' . $mainImage) }}" alt="{{ $productName }}">
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        const variantOptions = Array.from(document.querySelectorAll('[data-variant-option]'));
        const variantThumbs = Array.from(document.querySelectorAll('[data-variant-thumb]'));
        const galleryMain = document.getElementById('galleryMain');
        const retailPrice = document.getElementById('retailPrice');
        const wholesalePrice = document.getElementById('wholesalePrice');
        const stockText = document.getElementById('stockText');
        const variantNameText = document.getElementById('variantNameText');
        const variantMetaText = document.getElementById('variantMetaText');
        const singleVariantId = document.getElementById('singleVariantId');
        const bulkVariantId = document.getElementById('bulkVariantId');
        const singlePriceText = document.getElementById('singlePriceText');
        const bulkPriceText = document.getElementById('bulkPriceText');
        const lightbox = document.getElementById('imageLightbox');
        const lightboxImage = document.getElementById('lightboxImage');
        const lightboxClose = document.getElementById('lightboxClose');
        const lightboxThumbs = Array.from(document.querySelectorAll('[data-lightbox-thumb]'));

        function syncLightboxThumbs(variantId) {
            lightboxThumbs.forEach((thumb) => thumb.classList.toggle('active', thumb.dataset.variantId === variantId));
        }

        function activateVariant(dataset) {
            if (!dataset) return;
            const currentMainImage = document.getElementById('mainImage');
            const stockLabel = dataset.variantStock ? `${dataset.variantStock} ชิ้น` : 'พร้อมขาย';

            if (dataset.variantImage && galleryMain) {
                if (currentMainImage && currentMainImage.tagName === 'IMG') {
                    currentMainImage.src = dataset.variantImage;
                } else {
                    galleryMain.innerHTML = `<img id="mainImage" src="${dataset.variantImage}" alt="">`;
                    document.getElementById('mainImage')?.setAttribute('alt', @json($productName));
                }
            }

            retailPrice.textContent = `฿${Number(dataset.variantRetail).toFixed(2)}`;
            wholesalePrice.textContent = `฿${Number(dataset.variantWholesale).toFixed(2)}`;
            stockText.textContent = `มีสินค้า ${stockLabel}`;
            if (variantNameText) {
                variantNameText.textContent = dataset.variantName || 'สูตรสินค้า';
            }
            if (variantMetaText) {
                variantMetaText.textContent = `${dataset.variantSku || 'สูตรสินค้า'} · คงเหลือ ${dataset.variantStock || 0} ชิ้น`;
            }
            singlePriceText.textContent = `฿${Number(dataset.variantRetail).toFixed(2)}`;
            bulkPriceText.textContent = `฿${(Number(dataset.variantWholesale) * {{ $product->wholesale_min_qty }}).toFixed(2)}`;

            if (singleVariantId) singleVariantId.value = dataset.variantId;
            if (bulkVariantId) bulkVariantId.value = dataset.variantId;

            variantOptions.forEach((option) => option.classList.toggle('active', option.dataset.variantId === dataset.variantId));
            variantThumbs.forEach((thumb) => thumb.classList.toggle('active', thumb.dataset.variantId === dataset.variantId));
            syncLightboxThumbs(dataset.variantId || '');

            if (lightboxImage && dataset.variantImage) {
                lightboxImage.src = dataset.variantImage;
                lightboxImage.alt = @json($productName);
            }
        }

        function openLightbox() {
            const currentMainImage = document.getElementById('mainImage');

            if (!lightbox || !lightboxImage || !currentMainImage || currentMainImage.tagName !== 'IMG') {
                return;
            }

            lightboxImage.src = currentMainImage.src;
            lightboxImage.alt = currentMainImage.alt || @json($productName);
            lightbox.classList.add('is-open');
            lightbox.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            if (!lightbox) {
                return;
            }

            lightbox.classList.remove('is-open');
            lightbox.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        variantOptions.forEach((option) => option.addEventListener('click', () => activateVariant(option.dataset)));
        variantThumbs.forEach((thumb) => thumb.addEventListener('click', () => activateVariant(thumb.dataset)));
        lightboxThumbs.forEach((thumb) => {
            thumb.addEventListener('click', () => {
                const variantId = thumb.dataset.variantId;
                const matchingThumb = variantThumbs.find((item) => item.dataset.variantId === variantId);
                const matchingOption = variantOptions.find((item) => item.dataset.variantId === variantId);

                if (matchingThumb) {
                    activateVariant(matchingThumb.dataset);
                } else if (matchingOption) {
                    activateVariant(matchingOption.dataset);
                } else if (lightboxImage && thumb.dataset.variantImage) {
                    lightboxImage.src = thumb.dataset.variantImage;
                    lightboxImage.alt = @json($productName);
                    syncLightboxThumbs(variantId || '');
                }
            });
        });

        galleryMain?.addEventListener('click', openLightbox);
        lightboxClose?.addEventListener('click', closeLightbox);
        lightbox?.addEventListener('click', (event) => {
            if (event.target === lightbox) {
                closeLightbox();
            }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && lightbox?.classList.contains('is-open')) {
                closeLightbox();
            }
        });
    </script>
</body>
</html>
