<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บ้านครีม สิงห์บุรี | Beauty Marketplace</title>
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
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Prompt', sans-serif; background: var(--page-color); color: var(--text-dark); }
        a { color: inherit; text-decoration: none; }
        img { display: block; max-width: 100%; }

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
        .header-main,
        .header-tabs {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .header-main {
            min-height: 82px;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 24px;
        }
        .brand-logo {
            font-size: 2.35rem;
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: -0.04em;
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
            width: min(360px, 42vw);
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f7f8fb;
            border: 1px solid var(--border-color);
            border-radius: 999px;
            padding: 12px 18px;
        }
        .search-box input {
            width: 100%;
            border: none;
            background: transparent;
            outline: none;
            font-family: inherit;
            font-size: 0.96rem;
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
        .header-tabs {
            display: flex;
            gap: 14px;
            align-items: center;
            overflow-x: auto;
            padding-top: 14px;
            padding-bottom: 16px;
            border-top: 1px solid var(--border-color);
            white-space: nowrap;
        }
        .tab-link {
            color: var(--text-soft);
            padding: 8px 0;
            border-bottom: 2px solid transparent;
            font-weight: 500;
        }
        .tab-link:hover,
        .tab-link.active {
            color: var(--text-dark);
            border-bottom-color: var(--primary-color);
        }

        .hero {
            width: 100%;
            min-height: 74vh;
            background:
                linear-gradient(180deg, rgba(11, 24, 58, 0.08), rgba(11, 24, 58, 0.08)),
                url('https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?q=80&w=2200&auto=format&fit=crop') center/cover;
            position: relative;
        }
        .hero::after {
            content: '';
            position: absolute;
            inset: auto 0 0 0;
            height: 160px;
            background: linear-gradient(180deg, rgba(246, 248, 252, 0) 0%, rgba(246, 248, 252, 1) 100%);
        }
        .hero-floating-tabs {
            position: absolute;
            left: 50%;
            bottom: 28px;
            transform: translateX(-50%);
            width: min(1120px, calc(100% - 32px));
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(255, 255, 255, 0.65);
            border-radius: 28px;
            box-shadow: 0 24px 70px rgba(25, 38, 74, 0.18);
            padding: 18px 24px;
            display: flex;
            gap: 14px;
            overflow-x: auto;
            white-space: nowrap;
        }
        .hero-chip {
            background: #f7f9ff;
            border: 1px solid var(--border-color);
            border-radius: 999px;
            padding: 10px 16px;
            font-weight: 500;
            color: var(--text-soft);
        }
        .hero-chip:hover {
            color: var(--primary-color);
            border-color: rgba(255, 79, 135, 0.35);
        }

        .page-section {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 24px 56px;
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
        .section-scroll {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 4px;
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

        .product-grid {
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
        .product-meta {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 12px;
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
        .price-retail {
            font-size: 1.15rem;
            font-weight: 700;
        }
        .price-wholesale {
            color: #1f9d68;
            font-size: 0.82rem;
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
        .buy-button:hover { transform: translateY(-1px); }

        .brand-showcase {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
        }
        .brand-block {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 28px;
            padding: 24px;
            box-shadow: 0 18px 50px rgba(29, 41, 76, 0.08);
        }
        .brand-block h3 {
            font-size: 1.4rem;
            margin-bottom: 6px;
        }
        .brand-block p {
            color: var(--text-soft);
            margin-bottom: 18px;
        }
        .brand-mini-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }
        .brand-mini-card {
            background: #f8fafe;
            border: 1px solid var(--border-color);
            border-radius: 18px;
            overflow: hidden;
        }
        .brand-mini-card div {
            padding: 12px;
            font-size: 0.88rem;
            font-weight: 500;
        }
        .brand-mini-card img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            background: #eef3fb;
        }

        .notice {
            max-width: 1440px;
            margin: 24px auto 0;
            padding: 0 24px;
        }
        .notice-box {
            background: #e9fff5;
            color: #117a4d;
            border: 1px solid #b8f0d6;
            padding: 14px 18px;
            border-radius: 18px;
        }

        .empty-state {
            background: white;
            border: 1px dashed #c9d2e3;
            border-radius: 24px;
            padding: 32px;
            text-align: center;
            color: var(--text-soft);
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
            .hero { min-height: 56vh; }
        }

        @media (max-width: 720px) {
            .top-strip { padding: 10px 16px; }
            .header-main,
            .header-tabs,
            .page-section,
            .notice { padding-left: 16px; padding-right: 16px; }
            .brand-logo { font-size: 2rem; }
            .section-title { font-size: 1.6rem; }
            .hero-floating-tabs {
                bottom: 18px;
                padding: 14px 16px;
                border-radius: 22px;
            }
            .brand-showcase { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="top-strip">
        <div class="top-strip-inner">
            <div class="top-strip-badges">
                <span>ซื้อครบตามเงื่อนไข รับโปรพิเศษ</span>
                <span>อัปเดตแบรนด์ใหม่ได้จากหลังบ้าน</span>
                <span>สินค้าใหม่แยกแสดงอัตโนมัติ</span>
            </div>
            <span>บ้านครีม สิงห์บุรี</span>
        </div>
    </div>

    <header class="header-shell">
        <div class="header-main">
            <a href="{{ route('home') }}" class="brand-logo" aria-label="บ้านครีม สิงห์บุรี">
                <span>b</span><span>a</span><span>a</span><span>n</span><span>cream</span>
            </a>

            <nav class="main-links" aria-label="เมนูหลัก">
                <a href="#categories">หมวดหมู่</a>
                <a href="#brands">แบรนด์</a>
                <a href="#new-arrivals">สินค้าใหม่</a>
                <a href="#all-products">สินค้าทั้งหมด</a>
            </nav>

            <div class="header-tools">
                <label class="search-box" for="searchInput">
                    <span>🔍</span>
                    <input type="text" id="searchInput" placeholder="ค้นหาสินค้า แบรนด์ หรือหมวดหมู่">
                </label>
                <a href="{{ route('cart.index') }}" class="pill-link">ตะกร้าสินค้า</a>
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="user-action">บัญชีของฉัน</a>
                @else
                    <a href="{{ route('login') }}" class="user-action">เข้าสู่ระบบ</a>
                @endauth
            </div>
        </div>

        <div class="header-tabs">
            <a href="#new-arrivals" class="tab-link active">มาใหม่</a>
            @foreach($categories as $category)
                <a href="#category-{{ $category->slug }}" class="tab-link">{{ $category->name }}</a>
            @endforeach
        </div>
    </header>

    @if(session('success'))
        <div class="notice">
            <div class="notice-box">{{ session('success') }}</div>
        </div>
    @endif

    <section class="hero" aria-label="แบนเนอร์หลัก">
        <div class="hero-floating-tabs">
            <a href="#new-arrivals" class="hero-chip">สินค้าใหม่</a>
            @foreach($brands as $brand)
                <a href="#brand-{{ $brand->slug }}" class="hero-chip">{{ $brand->name }}</a>
            @endforeach
        </div>
    </section>

    <section class="page-section" id="categories" style="padding-top: 26px;">
        <div class="section-head">
            <div>
                <h2 class="section-title">เลือกช้อปตามหมวดหมู่</h2>
                <p class="section-subtitle">หมวดหมู่ทั้งหมดดึงจากหลังบ้าน admin และอัปเดตขึ้นหน้าแรกอัตโนมัติ</p>
            </div>
        </div>
        <div class="section-scroll">
            @foreach($categories as $category)
                <a href="#category-{{ $category->slug }}" class="section-pill">{{ $category->name }} ({{ $category->products->count() }})</a>
            @endforeach
        </div>
    </section>

    <section class="page-section" id="brands">
        <div class="section-head">
            <div>
                <h2 class="section-title">แบรนด์เด่นในร้าน</h2>
                <p class="section-subtitle">สร้างแบรนด์จากหลังบ้านได้เลย แล้วสินค้าในแบรนด์นั้นจะถูกรวมขึ้นมาแสดงอัตโนมัติ</p>
            </div>
        </div>
        <div class="section-scroll">
            @foreach($brands as $brand)
                <a href="#brand-{{ $brand->slug }}" class="section-pill">{{ $brand->name }} ({{ $brand->products_count }})</a>
            @endforeach
        </div>
    </section>

    <section class="page-section" id="new-arrivals">
        <div class="section-head">
            <div>
                <h2 class="section-title">สินค้ามาใหม่</h2>
                <p class="section-subtitle">ติ๊กสถานะสินค้าใหม่จากหลังบ้านเพื่อดันขึ้น section นี้ได้ทันที</p>
            </div>
        </div>

        @if($newArrivals->isEmpty())
            <div class="empty-state">ยังไม่มีสินค้าใหม่ในระบบ</div>
        @else
            <div class="product-grid">
                @foreach($newArrivals as $product)
                    <article class="product-card" data-search="{{ strtolower($product->name . ' ' . ($product->category->name ?? '') . ' ' . ($product->brand->name ?? '') . ' ' . $product->variants->pluck('name')->implode(' ')) }}">
                        <a href="{{ route('products.show', $product) }}" class="product-image">
                            @if($product->displayImage())
                                <img src="{{ asset('storage/' . $product->displayImage()) }}" alt="{{ $product->name }}">
                            @else
                                <span>No Image</span>
                            @endif
                        </a>
                        <div class="product-body">
                            <div class="product-meta">
                                @if($product->category)
                                    <span class="product-badge">{{ $product->category->name }}</span>
                                @endif
                                @if($product->brand)
                                    <span class="product-badge brand">{{ $product->brand->name }}</span>
                                @endif
                                @if($product->hasVariants())
                                    <span class="product-badge">{{ $product->variants->count() }} สูตร</span>
                                @endif
                            </div>
                            <a href="{{ route('products.show', $product) }}"><h3 class="product-name">{{ $product->name }}</h3></a>
                            <p class="product-desc">{{ Str::limit($product->description ?: 'อัปเดตรายละเอียดสินค้าเพิ่มเติมได้จากหลังบ้าน', 90) }}</p>
                            <div class="product-footer">
                                <div>
                                    <div class="price-retail">฿{{ number_format($product->displayRetailPrice(), 2) }}</div>
                                    <div class="price-wholesale">ราคาส่ง ฿{{ number_format($product->displayWholesalePrice(), 2) }}</div>
                                </div>
                                <a href="{{ route('products.show', $product) }}" class="buy-button">เลือกสูตร</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <section class="page-section" id="all-products">
        @foreach($categories as $category)
            <div id="category-{{ $category->slug }}" style="margin-bottom: 56px;">
                <div class="section-head">
                    <div>
                        <h2 class="section-title">{{ $category->name }}</h2>
                        <p class="section-subtitle">สินค้าในหมวดนี้ถูกดึงจากหลังบ้านตามหมวดหมู่ที่เลือกไว้</p>
                    </div>
                    <a href="#categories" class="section-pill">กลับไปดูหมวดหมู่</a>
                </div>

                <div class="product-grid">
                    @foreach($category->products->take(8) as $product)
                        <article class="product-card" data-search="{{ strtolower($product->name . ' ' . $category->name . ' ' . ($product->brand->name ?? '') . ' ' . $product->variants->pluck('name')->implode(' ')) }}">
                            <a href="{{ route('products.show', $product) }}" class="product-image">
                                @if($product->displayImage())
                                    <img src="{{ asset('storage/' . $product->displayImage()) }}" alt="{{ $product->name }}">
                                @else
                                    <span>No Image</span>
                                @endif
                            </a>
                            <div class="product-body">
                                <div class="product-meta">
                                    <span class="product-badge">{{ $category->name }}</span>
                                    @if($product->brand)
                                        <span class="product-badge brand">{{ $product->brand->name }}</span>
                                    @endif
                                    @if($product->is_new_arrival)
                                        <span class="product-badge">มาใหม่</span>
                                    @endif
                                    @if($product->hasVariants())
                                        <span class="product-badge">{{ $product->variants->count() }} สูตร</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product) }}"><h3 class="product-name">{{ $product->name }}</h3></a>
                                <p class="product-desc">{{ Str::limit($product->description ?: 'อัปเดตรายละเอียดสินค้าเพิ่มเติมได้จากหลังบ้าน', 90) }}</p>
                                <div class="product-footer">
                                    <div>
                                        <div class="price-retail">฿{{ number_format($product->displayRetailPrice(), 2) }}</div>
                                        <div class="price-wholesale">ราคาส่ง ฿{{ number_format($product->displayWholesalePrice(), 2) }}</div>
                                    </div>
                                    <a href="{{ route('products.show', $product) }}" class="buy-button">เลือกสูตร</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endforeach
    </section>

    <section class="page-section">
        <div class="section-head">
            <div>
                <h2 class="section-title">แยกดูตามแบรนด์</h2>
                <p class="section-subtitle">เหมาะกับหน้าแบบตัวอย่างที่ต้องการให้ลูกค้าเลือกต่อจากแบรนด์ก่อนลงไปดูสินค้า</p>
            </div>
        </div>

        @if($brandCollections->isEmpty())
            <div class="empty-state">ยังไม่มีแบรนด์ที่ผูกสินค้าไว้</div>
        @else
            <div class="brand-showcase">
                @foreach($brandCollections as $brand)
                    <section class="brand-block" id="brand-{{ $brand->slug }}">
                        <h3>{{ $brand->name }}</h3>
                        <p>รวมสินค้าของแบรนด์ {{ $brand->name }} ที่ดึงจากหลังบ้านโดยตรง</p>
                        <div class="brand-mini-grid">
                            @foreach($brand->products as $product)
                                <a href="{{ route('products.show', $product) }}" class="brand-mini-card" data-search="{{ strtolower($product->name . ' ' . ($product->category->name ?? '') . ' ' . $brand->name . ' ' . $product->variants->pluck('name')->implode(' ')) }}">
                                    @if($product->displayImage())
                                        <img src="{{ asset('storage/' . $product->displayImage()) }}" alt="{{ $product->name }}">
                                    @else
                                        <img src="https://placehold.co/600x600/f4f7fb/9aa7bd?text=No+Image" alt="No Image">
                                    @endif
                                    <div>{{ Str::limit($product->name, 40) }}</div>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>
        @endif
    </section>

    @include('store.partials.floating-cart', ['cartCount' => $cartCount])

    <script>
        const searchInput = document.getElementById('searchInput');
        const productCards = Array.from(document.querySelectorAll('[data-search]'));

        searchInput?.addEventListener('input', (event) => {
            const query = event.target.value.trim().toLowerCase();

            productCards.forEach((card) => {
                const haystack = card.dataset.search || '';
                const visible = !query || haystack.includes(query);
                card.style.display = visible ? '' : 'none';
            });
        });
    </script>
</body>
</html>
