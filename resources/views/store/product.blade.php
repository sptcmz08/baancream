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
            grid-template-columns: minmax(300px, 520px) minmax(340px, 1fr);
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
            max-width: 560px;
            width: 100%;
        }
        .gallery-main {
            background: white;
            border-radius: 28px;
            overflow: hidden;
            aspect-ratio: 1 / 1;
            max-height: 540px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 16px 44px rgba(29, 41, 76, 0.08);
            cursor: zoom-in;
        }
        .gallery-main img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .gallery-main .placeholder {
            color: #9aa7bd;
            font-size: 1rem;
        }
        .thumb-row {
            margin-top: 16px;
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding-bottom: 6px;
        }
        .thumb {
            width: 82px;
            min-width: 82px;
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
            padding: 34px;
        }
        .product-title {
            font-size: clamp(1.9rem, 3.6vw, 3.2rem);
            line-height: 1.12;
            margin-bottom: 16px;
        }
        .product-subtitle {
            color: var(--text-soft);
            font-size: 1.08rem;
            line-height: 1.9;
            margin-bottom: 28px;
        }
        .price-panel {
            display: grid;
            gap: 16px;
            padding: 24px 26px;
            border: 1px solid var(--border-color);
            border-radius: 28px;
            background: linear-gradient(135deg, #fff8ee 0%, #ffffff 55%);
            margin-bottom: 26px;
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
            font-size: 1.02rem;
            font-weight: 700;
            margin-bottom: 14px;
        }
        .variant-select-shell {
            display: grid;
            gap: 16px;
            margin-bottom: 28px;
        }
        .variant-select-input {
            width: 100%;
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 14px 16px;
            background: white;
            color: var(--text-dark);
            outline: none;
        }
        .variant-select-input:focus {
            border-color: rgba(255, 79, 135, 0.35);
            box-shadow: 0 0 0 4px rgba(255, 79, 135, 0.08);
        }
        .variant-picker {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding-bottom: 8px;
        }
        .variant-option {
            width: 112px;
            min-width: 112px;
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
            height: 86px;
            object-fit: contain;
            background: #f8fafc;
        }
        .variant-option span {
            display: block;
            padding: 8px 8px 10px;
            color: var(--text-dark);
            font-size: 0.78rem;
            font-weight: 600;
            line-height: 1.35;
            min-height: 44px;
        }
        .variant-option.is-main {
            background: linear-gradient(180deg, #fff7ef 0%, #ffffff 100%);
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
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 24px;
        }
        .product-card {
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 18px 50px rgba(29, 41, 76, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 58px rgba(29, 41, 76, 0.12);
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
            padding: 22px 22px 24px;
        }
        .product-name {
            font-size: 1.12rem;
            font-weight: 600;
            line-height: 1.5;
            margin-bottom: 14px;
            min-height: 3em;
        }
        .product-price {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .product-price .price-retail {
            font-size: 1.45rem;
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
            .gallery-card {
                justify-self: center;
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
            .gallery-main {
                max-height: min(420px, 76vw);
            }
            .thumb {
                width: 70px;
                min-width: 70px;
            }
            .variant-option {
                width: 100px;
                min-width: 100px;
            }
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
        $selectedRetailPrice = (float) (data_get($selectedVariant, 'retail_price') ?? data_get($product, 'retail_price', 0));
        $selectedWholesalePrice = (float) (data_get($selectedVariant, 'wholesale_price') ?? data_get($product, 'wholesale_price', 0));
        $selectedWholesaleMinQty = (int) (data_get($selectedVariant, 'wholesale_min_qty') ?? data_get($product, 'wholesale_min_qty', 1));
        $mediaUrl = fn (?string $path) => $path ? route('media.show', ['path' => $path]) : null;
        $productGalleryUrls = collect($product->galleryImages())
            ->map(fn ($path) => $mediaUrl($path))
            ->filter()
            ->values()
            ->all();
        $selectedVariantGalleryUrls = collect($selectedVariant?->galleryImages() ?? [])
            ->map(fn ($path) => $mediaUrl($path))
            ->filter()
            ->values()
            ->all();
        $selectedGalleryUrls = $product->variants->isNotEmpty()
            ? ($selectedVariant ? $selectedVariantGalleryUrls : $productGalleryUrls)
            : $productGalleryUrls;
        $mainImage = $selectedVariant?->displayImage() ?: $product->displayImage();
        $mainImageUrl = $selectedGalleryUrls[0] ?? $mediaUrl($mainImage);
        $selectedVariantName = (string) data_get($selectedVariant, 'name', $productName);
        $selectedDescription = (string) data_get($selectedVariant, 'description', $productDescription);
        $selectedOptionKey = $selectedVariant ? 'variant:' . $selectedVariant->id : 'main';
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
                    @if($mainImageUrl)
                        <img id="mainImage" src="{{ $mainImageUrl }}" alt="{{ $productName }}">
                    @else
                        <div class="placeholder" id="mainImage">No Image</div>
                    @endif
                </div>

                @if(!empty($selectedGalleryUrls))
                    <div class="thumb-row" id="galleryThumbRow">
                        @foreach($selectedGalleryUrls as $index => $imageUrl)
                            <button type="button" class="thumb {{ $index === 0 ? 'active' : '' }}"
                                data-gallery-index="{{ $index }}"
                                data-gallery-image="{{ $imageUrl }}">
                                <img src="{{ $imageUrl }}" alt="{{ $productName }}">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="surface-card detail-card">
                <h1 class="product-title" id="productTitleText">{{ $selectedVariantName }}</h1>
                <p class="product-subtitle" id="productSubtitleText" style="{{ trim($selectedDescription) === '' ? 'display:none;' : '' }}">{{ $selectedDescription }}</p>

                <div class="price-panel">
                    <div class="price-main">
                        <div>
                            <div class="price-label">ราคาปลีก</div>
                            <div class="price-retail" id="retailPrice">฿{{ number_format($selectedRetailPrice, 2) }}</div>
                        </div>
                        <div class="price-wholesale">
                            <span id="bulkQtyText">ส่ง {{ $selectedWholesaleMinQty }} ชิ้น</span>
                            <strong id="wholesalePrice">฿{{ number_format($selectedWholesalePrice, 2) }}</strong>
                        </div>
                    </div>
                </div>

                @if($product->variants->isNotEmpty())
                    <div class="variant-panel-title">ตัวเลือกสินค้า</div>
                    <div class="variant-select-shell">
                        <select id="variantSelect" class="variant-select-input" aria-label="เลือกสินค้าหรือสูตร">
                            <option value="main" {{ $selectedOptionKey === 'main' ? 'selected' : '' }}>{{ $productName }} (สินค้าหลัก)</option>
                            @foreach($product->variants as $variant)
                                <option value="variant:{{ $variant->id }}" {{ $selectedOptionKey === 'variant:' . $variant->id ? 'selected' : '' }}>
                                    {{ (string) data_get($variant, 'name', 'สูตรสินค้า') }}
                                </option>
                            @endforeach
                        </select>
                        <div class="variant-picker">
                            <button type="button" class="variant-option is-main {{ $selectedOptionKey === 'main' ? 'active' : '' }}"
                                data-variant-option
                                data-option-key="main"
                                data-variant-id=""
                                data-variant-image="{{ $mainImageUrl ?: '' }}"
                                data-variant-gallery='@json($productGalleryUrls)'
                                data-variant-retail="{{ number_format($product->retail_price, 2, '.', '') }}"
                                data-variant-wholesale="{{ number_format($product->wholesale_price, 2, '.', '') }}"
                                data-variant-min-qty="{{ $product->wholesale_min_qty ?: 1 }}"
                                data-variant-name="{{ $productName }}"
                                data-variant-description="{{ $productDescription }}">
                                @if($product->displayImage())
                                    <img src="{{ route('media.show', ['path' => $product->displayImage()]) }}" alt="{{ $productName }}">
                                @else
                                    <img src="https://placehold.co/200x200/f4f7fb/99a4b5?text=No+Image" alt="No Image">
                                @endif
                                <span>สินค้าหลัก</span>
                            </button>
                            @foreach($product->variants as $variant)
                                @php
                                    $variantGalleryUrls = collect($variant->galleryImages())
                                        ->map(fn ($path) => $mediaUrl($path))
                                        ->filter()
                                        ->values()
                                        ->all();
                                    $variantDisplayGalleryUrls = !empty($variantGalleryUrls) ? $variantGalleryUrls : $productGalleryUrls;
                                    $imageUrl = $variantDisplayGalleryUrls[0] ?? null;
                                @endphp
                                <button type="button" class="variant-option {{ $selectedOptionKey === 'variant:' . $variant->id ? 'active' : '' }}"
                                    data-variant-option
                                    data-option-key="variant:{{ $variant->id }}"
                                    data-variant-id="{{ $variant->id }}"
                                    data-variant-image="{{ $imageUrl ?: '' }}"
                                    data-variant-gallery='@json($variantDisplayGalleryUrls)'
                                    data-variant-retail="{{ number_format($variant->retail_price, 2, '.', '') }}"
                                    data-variant-wholesale="{{ number_format($variant->wholesale_price, 2, '.', '') }}"
                                    data-variant-min-qty="{{ $variant->wholesale_min_qty ?: ($product->wholesale_min_qty ?: 1) }}"
                                    data-variant-name="{{ (string) data_get($variant, 'name', 'สูตรสินค้า') }}"
                                    data-variant-description="{{ (string) data_get($variant, 'description', $productDescription) }}">
                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}" alt="{{ (string) data_get($variant, 'name', 'สูตรสินค้า') }}">
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
                        <input type="hidden" name="quantity" id="bulkQuantity" value="{{ $selectedWholesaleMinQty }}">
                        <button type="submit" class="cta-button primary">ใส่ตะกร้า <span id="bulkQtyButtonText">{{ $selectedWholesaleMinQty }}</span> ชิ้น <span id="bulkPriceText">฿{{ number_format($selectedWholesalePrice, 2) }}</span></button>
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
                        <a href="{{ route('products.show', $item) }}" aria-label="{{ (string) data_get($item, 'name', 'สินค้า') }}">
                            <div class="product-image">
                                @if($item->displayImage())
                                    <img src="{{ url('/media/' . $item->displayImage()) }}" alt="{{ (string) data_get($item, 'name', 'สินค้า') }}">
                                @else
                                    <span>No Image</span>
                                @endif
                            </div>
                            <div class="product-body">
                                <h3 class="product-name">{{ (string) data_get($item, 'name', 'สินค้า') }}</h3>
                                <div class="product-price">
                                    <div class="price-retail">฿{{ number_format((float) $item->displayRetailPrice(), 2) }}</div>
                                </div>
                            </div>
                        </a>
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
                <div class="lightbox-thumbs" id="lightboxThumbs">
                    @if(!empty($selectedGalleryUrls))
                        @foreach($selectedGalleryUrls as $index => $imageUrl)
                            <button type="button" class="lightbox-thumb {{ $index === 0 ? 'active' : '' }}"
                                data-lightbox-index="{{ $index }}"
                                data-lightbox-image="{{ $imageUrl }}">
                                <img src="{{ $imageUrl }}" alt="{{ $productName }}">
                            </button>
                        @endforeach
                    @elseif($mainImageUrl)
                        <button type="button" class="lightbox-thumb active" data-lightbox-index="0" data-lightbox-image="{{ $mainImageUrl }}">
                            <img src="{{ $mainImageUrl }}" alt="{{ $productName }}">
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        const variantOptions = Array.from(document.querySelectorAll('[data-variant-option]'));
        const variantSelect = document.getElementById('variantSelect');
        const galleryMain = document.getElementById('galleryMain');
        const galleryThumbRow = document.getElementById('galleryThumbRow');
        const productTitleText = document.getElementById('productTitleText');
        const productSubtitleText = document.getElementById('productSubtitleText');
        const retailPrice = document.getElementById('retailPrice');
        const wholesalePrice = document.getElementById('wholesalePrice');
        const singleVariantId = document.getElementById('singleVariantId');
        const bulkVariantId = document.getElementById('bulkVariantId');
        const bulkQuantity = document.getElementById('bulkQuantity');
        const bulkQtyText = document.getElementById('bulkQtyText');
        const bulkQtyButtonText = document.getElementById('bulkQtyButtonText');
        const singlePriceText = document.getElementById('singlePriceText');
        const bulkPriceText = document.getElementById('bulkPriceText');
        const lightbox = document.getElementById('imageLightbox');
        const lightboxImage = document.getElementById('lightboxImage');
        const lightboxClose = document.getElementById('lightboxClose');
        const lightboxThumbContainer = document.getElementById('lightboxThumbs');
        let activeGalleryImages = @json(array_values($selectedGalleryUrls));
        let activeGalleryIndex = 0;

        function renderMainImage(imageUrl) {
            if (!galleryMain) {
                return;
            }

            if (imageUrl) {
                galleryMain.innerHTML = `<img id="mainImage" src="${imageUrl}" alt="">`;
                document.getElementById('mainImage')?.setAttribute('alt', @json($productName));
                return;
            }

            galleryMain.innerHTML = '<div class="placeholder" id="mainImage">No Image</div>';
        }

        function syncGalleryThumbs(index) {
            galleryThumbRow?.querySelectorAll('[data-gallery-index]').forEach((thumb) => {
                thumb.classList.toggle('active', Number(thumb.dataset.galleryIndex) === index);
            });

            lightboxThumbContainer?.querySelectorAll('[data-lightbox-index]').forEach((thumb) => {
                thumb.classList.toggle('active', Number(thumb.dataset.lightboxIndex) === index);
            });
        }

        function showGalleryImage(index) {
            if (!Array.isArray(activeGalleryImages) || !activeGalleryImages.length) {
                return;
            }

            const safeIndex = Math.max(0, Math.min(index, activeGalleryImages.length - 1));
            activeGalleryIndex = safeIndex;
            const imageUrl = activeGalleryImages[safeIndex];

            renderMainImage(imageUrl);
            syncGalleryThumbs(safeIndex);

            if (lightboxImage && imageUrl) {
                lightboxImage.src = imageUrl;
                lightboxImage.alt = @json($productName);
            }
        }

        function renderGalleryThumbMarkup(type) {
            return activeGalleryImages.map((imageUrl, index) => {
                const attrName = type === 'lightbox' ? 'data-lightbox-index' : 'data-gallery-index';
                const dataImage = type === 'lightbox' ? 'data-lightbox-image' : 'data-gallery-image';
                const className = type === 'lightbox' ? 'lightbox-thumb' : 'thumb';
                const isActive = index === activeGalleryIndex ? ' active' : '';

                return `<button type="button" class="${className}${isActive}" ${attrName}="${index}" ${dataImage}="${imageUrl}"><img src="${imageUrl}" alt=""></button>`;
            }).join('');
        }

        function renderGallery(images, preferredImage = null) {
            activeGalleryImages = Array.isArray(images) ? images.filter(Boolean) : [];

            if (!activeGalleryImages.length) {
                activeGalleryIndex = 0;
                renderMainImage(@json($mainImageUrl));
                if (galleryThumbRow) galleryThumbRow.innerHTML = '';
                if (lightboxThumbContainer) lightboxThumbContainer.innerHTML = '';
                return;
            }

            const nextIndex = preferredImage ? activeGalleryImages.indexOf(preferredImage) : 0;
            activeGalleryIndex = nextIndex >= 0 ? nextIndex : 0;

            if (galleryThumbRow) {
                galleryThumbRow.innerHTML = renderGalleryThumbMarkup('gallery');
            }
            if (lightboxThumbContainer) {
                lightboxThumbContainer.innerHTML = renderGalleryThumbMarkup('lightbox');
            }

            showGalleryImage(activeGalleryIndex);
        }

        function activateVariant(dataset) {
            if (!dataset) return;
            const wholesaleMinQty = Number(dataset.variantMinQty || {{ $selectedWholesaleMinQty }});
            let variantGallery = [];

            try {
                variantGallery = JSON.parse(dataset.variantGallery || '[]');
            } catch (error) {
                variantGallery = [];
            }

            renderGallery(variantGallery, dataset.variantImage || variantGallery[0] || null);

            retailPrice.textContent = `฿${Number(dataset.variantRetail).toFixed(2)}`;
            wholesalePrice.textContent = `฿${Number(dataset.variantWholesale).toFixed(2)}`;
            if (productTitleText) {
                productTitleText.textContent = dataset.variantName || @json($productName);
            }
            if (productSubtitleText) {
                const description = (dataset.variantDescription || '').trim();
                productSubtitleText.textContent = description;
                productSubtitleText.style.display = description ? '' : 'none';
            }
            singlePriceText.textContent = `฿${Number(dataset.variantRetail).toFixed(2)}`;
            bulkPriceText.textContent = `฿${Number(dataset.variantWholesale).toFixed(2)}`;
            if (bulkQtyText) bulkQtyText.textContent = `ส่ง ${wholesaleMinQty} ชิ้น`;
            if (bulkQtyButtonText) bulkQtyButtonText.textContent = wholesaleMinQty;

            if (singleVariantId) singleVariantId.value = dataset.variantId;
            if (bulkVariantId) bulkVariantId.value = dataset.variantId;
            if (bulkQuantity) bulkQuantity.value = wholesaleMinQty;

            variantOptions.forEach((option) => option.classList.toggle('active', option.dataset.optionKey === dataset.optionKey));
            if (variantSelect) {
                variantSelect.value = dataset.optionKey || 'main';
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
        variantSelect?.addEventListener('change', () => {
            const selectedOption = variantOptions.find((option) => option.dataset.optionKey === variantSelect.value);
            if (selectedOption) {
                activateVariant(selectedOption.dataset);
            }
        });
        galleryThumbRow?.addEventListener('click', (event) => {
            const thumb = event.target.closest('[data-gallery-index]');
            if (!thumb) {
                return;
            }

            showGalleryImage(Number(thumb.dataset.galleryIndex));
        });
        lightboxThumbContainer?.addEventListener('click', (event) => {
            const thumb = event.target.closest('[data-lightbox-index]');
            if (!thumb) {
                return;
            }

            showGalleryImage(Number(thumb.dataset.lightboxIndex));
        });

        renderGallery(activeGalleryImages, @json($mainImageUrl));
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
