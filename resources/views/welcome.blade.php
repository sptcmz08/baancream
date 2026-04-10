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
        .header-main {
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
            cursor: pointer;
        }
        .section-pill:hover {
            color: var(--primary-color);
            border-color: rgba(255, 79, 135, 0.3);
        }
        .section-pill.active {
            color: var(--text-dark);
            background: #fff4f8;
            border-color: rgba(255, 79, 135, 0.3);
            box-shadow: 0 10px 24px rgba(233, 53, 116, 0.08);
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
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

        .catalog-toolbar {
            display: grid;
            gap: 18px;
            margin-bottom: 26px;
        }
        .catalog-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }
        .catalog-count {
            color: var(--text-soft);
            font-weight: 500;
        }
        .catalog-empty {
            background: white;
            border: 1px dashed #c9d2e3;
            border-radius: 24px;
            padding: 44px 24px;
            text-align: center;
            color: var(--text-soft);
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
            .product-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .top-strip { padding: 10px 16px; }
            .header-main,
            .page-section,
            .notice { padding-left: 16px; padding-right: 16px; }
            .brand-logo { font-size: 2rem; }
            .section-title { font-size: 1.6rem; }
            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 520px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    @php
        $newArrivalIds = $newArrivals->pluck('id')->all();
        $featuredIds = $featuredProducts->pluck('id')->all();
    @endphp
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
                <a href="#catalog">หมวดหมู่</a>
                <a href="#catalog">สินค้าใหม่</a>
                <a href="#catalog">สินค้าแนะนำ</a>
                <a href="#catalog">สินค้าทั้งหมด</a>
            </nav>

            <div class="header-tools">
                <label class="search-box" for="searchInput">
                    <span>🔍</span>
                    <input type="text" id="searchInput" placeholder="ค้นหาสินค้า แบรนด์ หรือหมวดหมู่">
                </label>
                <button type="button" class="pill-link" data-open-cart style="font-family: inherit; cursor: pointer;">ตะกร้าสินค้า</button>
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="user-action">บัญชีของฉัน</a>
                @else
                    <a href="{{ route('login') }}" class="user-action">เข้าสู่ระบบ</a>
                @endauth
            </div>
        </div>

    </header>

    @if(session('success'))
        <div class="notice">
            <div class="notice-box">{{ session('success') }}</div>
        </div>
    @endif

    <section class="hero" aria-label="แบนเนอร์หลัก"></section>

    <section class="page-section" id="catalog" style="padding-top: 26px;">
        <div class="section-head">
            <div>
                <h2 class="section-title">เลือกช้อปตามหมวดหมู่</h2>
                <p class="section-subtitle">เลือกจากหัวข้อด้านล่างได้เลย โดยมีทั้งหมด สินค้ามาใหม่ สินค้าแนะนำ และหมวดหมู่จากหลังบ้าน admin</p>
            </div>
        </div>
        <div class="catalog-toolbar">
            <div class="section-scroll" id="catalogFilters">
                <button type="button" class="section-pill active" data-filter="all">ทั้งหมด ({{ $catalogProducts->count() }})</button>
                <button type="button" class="section-pill" data-filter="new">สินค้ามาใหม่ ({{ count($newArrivalIds) }})</button>
                <button type="button" class="section-pill" data-filter="featured">สินค้าแนะนำ ({{ count($featuredIds) }})</button>
                @foreach($categories as $category)
                    <button type="button" class="section-pill" data-filter="category:{{ $category->slug }}">{{ $category->name }} ({{ $category->products->count() }})</button>
                @endforeach
            </div>
            <div class="catalog-summary">
                <div>
                    <h3 class="section-title" style="font-size:1.55rem;" id="catalogTitle">ทั้งหมด</h3>
                    <p class="section-subtitle" style="margin-top:6px;">รายการสินค้าจะเรียงยาวต่อเนื่อง และบนจอใหญ่แสดง 5 ชิ้นต่อแถว</p>
                </div>
                <div class="catalog-count" id="catalogCount">ทั้งหมด {{ $catalogProducts->count() }} รายการ</div>
            </div>
        </div>

        @if($catalogProducts->isEmpty())
            <div class="catalog-empty">ยังไม่มีสินค้าในระบบ</div>
        @else
            <div class="product-grid" id="catalogGrid">
                @foreach($catalogProducts as $product)
                    @php
                        $filterTags = ['all'];
                        if (in_array($product->id, $newArrivalIds, true)) {
                            $filterTags[] = 'new';
                        }
                        if (in_array($product->id, $featuredIds, true)) {
                            $filterTags[] = 'featured';
                        }
                        if ($product->category?->slug) {
                            $filterTags[] = 'category:' . $product->category->slug;
                        }
                    @endphp
                    <article
                        class="product-card"
                        data-card
                        data-filter-tags="{{ implode('|', $filterTags) }}"
                        data-search="{{ strtolower($product->name . ' ' . ($product->category->name ?? '') . ' ' . ($product->brand->name ?? '') . ' ' . $product->variants->pluck('name')->implode(' ')) }}">
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

    @include('store.partials.floating-cart', [
        'cartCount' => $cartCount,
        'cartItems' => $cartSummary['items'],
        'cartTotal' => $cartSummary['total'],
    ])

    <script>
        const searchInput = document.getElementById('searchInput');
        const productCards = Array.from(document.querySelectorAll('[data-card]'));
        const filterButtons = Array.from(document.querySelectorAll('#catalogFilters [data-filter]'));
        const catalogTitle = document.getElementById('catalogTitle');
        const catalogCount = document.getElementById('catalogCount');
        let activeFilter = 'all';

        function currentFilterLabel() {
            return filterButtons.find((button) => button.dataset.filter === activeFilter)?.textContent?.replace(/\s*\(\d+\)\s*$/, '') || 'ทั้งหมด';
        }

        function applyCatalogFilters() {
            const query = searchInput?.value.trim().toLowerCase() || '';
            let visibleCount = 0;

            productCards.forEach((card) => {
                const haystack = card.dataset.search || '';
                const tags = (card.dataset.filterTags || '').split('|');
                const matchesFilter = activeFilter === 'all' || tags.includes(activeFilter);
                const matchesSearch = !query || haystack.includes(query);
                const visible = matchesFilter && matchesSearch;

                card.style.display = visible ? '' : 'none';
                if (visible) {
                    visibleCount += 1;
                }
            });

            if (catalogTitle) {
                catalogTitle.textContent = currentFilterLabel();
            }

            if (catalogCount) {
                catalogCount.textContent = `${currentFilterLabel()} ${visibleCount} รายการ`;
            }
        }

        filterButtons.forEach((button) => {
            button.addEventListener('click', () => {
                activeFilter = button.dataset.filter || 'all';
                filterButtons.forEach((item) => item.classList.toggle('active', item === button));
                applyCatalogFilters();
            });
        });

        searchInput?.addEventListener('input', (event) => {
            applyCatalogFilters();
        });

        applyCatalogFilters();
    </script>
</body>
</html>
