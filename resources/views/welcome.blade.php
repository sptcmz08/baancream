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
            min-height: 96px;
            display: grid;
            grid-template-columns: auto 1fr;
            align-items: center;
            gap: 24px;
        }
        .brand-logo {
            display: inline-flex;
            align-items: center;
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: -0.04em;
        }
        .brand-logo-image {
            height: 78px;
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
            justify-self: end;
        }
        .search-shell {
            position: relative;
            width: min(360px, 42vw);
        }
        .search-box {
            width: 100%;
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
        .search-results {
            position: absolute;
            top: calc(100% + 10px);
            left: 0;
            right: 0;
            display: none;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 24px;
            box-shadow: 0 18px 50px rgba(29, 41, 76, 0.14);
            overflow: hidden;
            z-index: 40;
        }
        .search-results.is-open {
            display: block;
        }
        .search-result-item {
            display: grid;
            grid-template-columns: 56px 1fr;
            gap: 12px;
            align-items: center;
            padding: 12px 14px;
            border-bottom: 1px solid var(--border-color);
        }
        .search-result-item:last-child {
            border-bottom: none;
        }
        .search-result-item:hover {
            background: #fff7fb;
        }
        .search-result-thumb {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            overflow: hidden;
            background: linear-gradient(135deg, #f8f0f3 0%, #eef7ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .search-result-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .search-result-name {
            font-size: 0.96rem;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 3px;
        }
        .search-result-price {
            color: var(--text-soft);
            font-size: 0.9rem;
        }
        .search-result-empty {
            padding: 16px 18px;
            color: var(--text-soft);
            font-size: 0.92rem;
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
        .cart-icon-link {
            width: 46px;
            height: 46px;
            border: 1px solid var(--border-color);
            border-radius: 999px;
            background: white;
            color: var(--text-dark);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.2s ease;
        }
        .cart-icon-link:hover {
            border-color: rgba(255, 79, 135, 0.35);
            color: var(--primary-color);
            transform: translateY(-1px);
        }
        .cart-icon-link svg {
            width: 21px;
            height: 21px;
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
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 26px;
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
            padding: 18px;
        }
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            mix-blend-mode: multiply;
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
        .price-retail {
            font-size: 1.45rem;
            font-weight: 700;
        }

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
            .search-shell { width: 100%; }
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
            .brand-logo { font-size: 2.25rem; }
            .brand-logo-image { height: 62px; }
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

        /* ── Notification Bell ── */
        .notif-wrap { position: relative; }
        .notif-btn {
            width: 42px; height: 42px; border-radius: 999px;
            background: white; border: 1px solid var(--border-color);
            font-size: 1.1rem; cursor: pointer; position: relative;
            display: inline-flex; align-items: center; justify-content: center;
        }
        .notif-btn:hover { border-color: rgba(255,79,135,0.35); }
        .notif-badge {
            position: absolute; top: -4px; right: -4px;
            background: var(--primary-color); color: white;
            border-radius: 999px; font-size: 0.65rem; font-weight: 700;
            min-width: 18px; height: 18px; display: flex;
            align-items: center; justify-content: center; padding: 0 4px;
            border: 2px solid white;
        }
        .notif-dropdown {
            display: none; position: absolute; top: calc(100% + 10px); right: 0;
            width: 300px; background: white; border: 1px solid var(--border-color);
            border-radius: 20px; box-shadow: 0 16px 48px rgba(15,23,42,0.14);
            overflow: hidden; z-index: 50;
        }
        .notif-dropdown.is-open { display: block; }
        .notif-header { padding: 14px 16px; border-bottom: 1px solid var(--border-color); font-weight: 700; font-size: 0.95rem; }
        .notif-item {
            display: flex; gap: 12px; padding: 12px 16px; align-items: flex-start;
            border-bottom: 1px solid var(--border-color);
        }
        .notif-item:last-child { border-bottom: none; }
        .notif-item:hover { background: #f7f8fb; }
        .notif-dot { width: 10px; height: 10px; border-radius: 999px; flex-shrink:0; margin-top:5px; }
        .notif-item-title { font-size: 0.88rem; font-weight: 600; margin-bottom: 2px; }
        .notif-item-sub { font-size: 0.78rem; color: var(--text-soft); }
        .notif-empty { padding: 24px; text-align: center; color: var(--text-soft); font-size: 0.9rem; }

        /* ── User Dropdown ── */
        .user-menu { position: relative; }
        .user-menu-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: inherit;
            cursor: pointer;
        }
        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--primary-color), #6a67ff);
            color: white;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .user-menu-name { font-weight: 600; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .user-menu-caret { font-size: 0.7rem; color: var(--text-soft); transition: transform 0.2s; }
        .user-menu-btn[aria-expanded="true"] .user-menu-caret { transform: rotate(180deg); }
        .user-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 220px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 16px 48px rgba(15,23,42,0.14);
            overflow: hidden;
            z-index: 50;
        }
        .user-dropdown.is-open { display: block; }
        .user-dropdown-header {
            padding: 14px 16px 10px;
            border-bottom: 1px solid var(--border-color);
        }
        .user-dropdown-label { font-size: 0.78rem; color: var(--text-soft); }
        .user-dropdown-name { font-weight: 700; font-size: 1rem; margin-top: 2px; }
        .user-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 12px 16px;
            color: var(--text-dark);
            font-size: 0.95rem;
            font-weight: 500;
            background: transparent;
            border: none;
            font-family: inherit;
            cursor: pointer;
            text-align: left;
        }
        .user-dropdown-item:hover { background: #f7f8fb; color: var(--primary-color); }
        .user-dropdown-logout { color: #dc2626 !important; }
        .user-dropdown-logout:hover { background: #fff1f2 !important; color: #dc2626 !important; }
    </style>
</head>
<body>
    @php
        $newArrivalIds = $newArrivals->pluck('id')->all();
        $featuredIds = $featuredProducts->pluck('id')->all();
        $searchProducts = $catalogProducts->map(fn ($product) => [
            'name' => $product->name,
            'price' => number_format($product->displayRetailPrice(), 2),
            'url' => route('products.show', $product),
            'image' => $product->displayImage() ? route('media.show', ['path' => $product->displayImage()]) : null,
            'search' => strtolower($product->name),
        ])->values();
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
                @include('store.partials.site-logo-markup')
            </a>

            <div class="header-tools">
                <div class="search-shell" id="searchShell">
                    <label class="search-box" for="searchInput">
                        <span>🔍</span>
                        <input type="text" id="searchInput" placeholder="ค้นหาสินค้า แบรนด์ หรือหมวดหมู่" autocomplete="off">
                    </label>
                    <div class="search-results" id="searchResults" aria-live="polite"></div>
                </div>
                <button type="button" class="cart-icon-link" data-open-cart aria-label="ตะกร้าสินค้า">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M7 8h13l-1.2 6.6a2 2 0 0 1-2 1.6H9.1a2 2 0 0 1-2-1.7L5.8 5.8H3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9.4 20.2h.1M17 20.2h.1" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"/>
                    </svg>
                </button>
                @auth
                    {{-- Bell notification --}}
                    <div class="notif-wrap" id="notifWrap">
                        <button type="button" class="notif-btn" id="notifBtn" aria-label="การแจ้งเตือน">
                            🔔
                            <span class="notif-badge" id="notifBadge" style="display:none;">0</span>
                        </button>
                        <div class="notif-dropdown" id="notifDropdown">
                            <div class="notif-header">การแจ้งเตือน</div>
                            <div id="notifList" style="min-height:60px;">
                                <div style="padding:16px;text-align:center;color:var(--text-soft);font-size:0.9rem;">กำลังโหลด...</div>
                            </div>
                        </div>
                    </div>

                    {{-- User dropdown --}}
                    <div class="user-menu" id="userMenuWrap">
                        <button type="button" class="user-action user-menu-btn" id="userMenuBtn" aria-expanded="false" aria-haspopup="true">
                            <span class="user-avatar">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                            <span class="user-menu-name">{{ auth()->user()->username ?? auth()->user()->name }}</span>
                            <span class="user-menu-caret">▾</span>
                        </button>
                        <div class="user-dropdown" id="userDropdown" role="menu">
                            <div class="user-dropdown-header">
                                <div class="user-dropdown-label">เข้าสู่ระบบโดย</div>
                                <div class="user-dropdown-name">{{ auth()->user()->name }}</div>
                            </div>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="user-dropdown-item" role="menuitem">
                                    <span>⚙️</span> หลังบ้าน Admin
                                </a>
                            @endif
                            <a href="{{ route('account.index') }}" class="user-dropdown-item" role="menuitem">
                                <span>👤</span> โปรไฟล์ส่วนตัว
                            </a>
                            <a href="{{ route('account.orders') }}" class="user-dropdown-item" role="menuitem">
                                <span>📋</span> ประวัติการสั่งซื้อ
                            </a>
                            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                                @csrf
                                <button type="submit" class="user-dropdown-item user-dropdown-logout" role="menuitem">
                                    <span>↩</span> ออกจากระบบ
                                </button>
                            </form>
                        </div>
                    </div>
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

    <section class="hero" aria-label="แบนเนอร์หลัก"></section>

    <section class="page-section" id="catalog" style="padding-top: 26px;">
        <div class="section-head">
            <div>
                <h2 class="section-title">เลือกช้อปตามหมวดหมู่</h2>
            </div>
        </div>
        <div class="catalog-toolbar">
            <div class="section-scroll" id="catalogFilters">
                <button type="button" class="section-pill active" data-filter="all">ทั้งหมด ({{ $catalogProducts->count() }})</button>
                <button type="button" class="section-pill" data-filter="new">สินค้ามาใหม่ ({{ count($newArrivalIds) }})</button>
                <button type="button" class="section-pill" data-filter="featured">สินค้าแนะนำ ({{ count($featuredIds) }})</button>
                @foreach($categories as $category)
                    <button type="button" class="section-pill" data-filter="category:{{ $category->slug }}">{{ $category->name }} ({{ $category->products_count }})</button>
                @endforeach
            </div>
            <div class="catalog-summary">
                <div>
                    <h3 class="section-title" style="font-size:1.55rem;" id="catalogTitle">ทั้งหมด</h3>
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
                        foreach($product->categories as $pc) {
                            $filterTags[] = 'category:' . $pc->slug;
                        }
                    @endphp
                    <article
                        class="product-card"
                        data-card
                        data-filter-tags="{{ implode('|', $filterTags) }}"
                        data-search="{{ strtolower($product->name) }}">
                        <a href="{{ route('products.show', $product) }}" aria-label="{{ $product->name }}">
                            <div class="product-image">
                                @if($product->displayImage())
                                    <img src="{{ url('/media/' . $product->displayImage()) }}" alt="{{ $product->name }}">
                                @else
                                    <span>No Image</span>
                                @endif
                            </div>
                            <div class="product-body">
                                <h3 class="product-name">{{ $product->name }}</h3>
                                <div class="product-price">
                                    <div class="price-retail">฿{{ number_format($product->displayRetailPrice(), 2) }}</div>
                                </div>
                            </div>
                        </a>
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
    @guest
        @include('store.partials.auth-modal')
    @endguest

    <script>
        const searchInput = document.getElementById('searchInput');
        const searchShell = document.getElementById('searchShell');
        const searchResults = document.getElementById('searchResults');
        const productCards = Array.from(document.querySelectorAll('[data-card]'));
        const filterButtons = Array.from(document.querySelectorAll('#catalogFilters [data-filter]'));
        const catalogTitle = document.getElementById('catalogTitle');
        const catalogCount = document.getElementById('catalogCount');
        const searchProducts = @json($searchProducts);
        let activeFilter = 'all';

        function closeSearchResults() {
            searchResults?.classList.remove('is-open');
        }

        function renderSearchResults(query) {
            if (!searchResults) {
                return;
            }

            const normalizedQuery = query.trim().toLowerCase();
            if (!normalizedQuery) {
                searchResults.innerHTML = '';
                closeSearchResults();
                return;
            }

            const matched = searchProducts
                .filter((product) => (product.search || '').includes(normalizedQuery))
                .slice(0, 6);

            if (!matched.length) {
                searchResults.innerHTML = '<div class="search-result-empty">ไม่พบสินค้าที่ค้นหา</div>';
                searchResults.classList.add('is-open');
                return;
            }

            searchResults.innerHTML = matched.map((product) => `
                <a href="${product.url}" class="search-result-item">
                    <div class="search-result-thumb">
                        ${product.image ? `<img src="${product.image}" alt="${product.name}">` : '<span>No Image</span>'}
                    </div>
                    <div>
                        <div class="search-result-name">${product.name}</div>
                        <div class="search-result-price">฿${product.price}</div>
                    </div>
                </a>
            `).join('');
            searchResults.classList.add('is-open');
        }

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
            renderSearchResults(event.target.value);
            applyCatalogFilters();
        });

        searchInput?.addEventListener('focus', (event) => {
            renderSearchResults(event.target.value);
        });

        applyCatalogFilters();

        // ── User Dropdown ──
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');
        if (userMenuBtn && userDropdown) {
            userMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = userDropdown.classList.toggle('is-open');
                userMenuBtn.setAttribute('aria-expanded', String(isOpen));
                notifDropdown?.classList.remove('is-open');
            });
        }

        // ── Notification Bell ──
        const notifBtn = document.getElementById('notifBtn');
        const notifDropdown = document.getElementById('notifDropdown');
        const notifBadge = document.getElementById('notifBadge');
        const notifList = document.getElementById('notifList');
        let notifLoaded = false;

        async function loadNotifications() {
            try {
                const res = await fetch('{{ route('account.notifications') }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();

                if (notifBadge) {
                    notifBadge.textContent = data.unread;
                    notifBadge.style.display = data.unread > 0 ? 'flex' : 'none';
                }

                if (notifList) {
                    if (!data.items.length) {
                        notifList.innerHTML = '<div class="notif-empty">🔕 ยังไม่มีการแจ้งเตือน</div>';
                    } else {
                        notifList.innerHTML = data.items.map(item => `
                            <a href="${item.url}" class="notif-item" style="text-decoration:none;color:inherit;">
                                <div class="notif-dot" style="background:${item.color};"></div>
                                <div>
                                    <div class="notif-item-title">คำสั่งซื้อ #${String(item.id).padStart(5,'0')}</div>
                                    <div class="notif-item-sub">${item.label} · ฿${item.total} · ${item.created_at}</div>
                                </div>
                            </a>
                        `).join('');
                    }
                }
            } catch(e) {
                if (notifList) notifList.innerHTML = '<div class="notif-empty">ไม่สามารถโหลดได้</div>';
            }
        }

        if (notifBtn && notifDropdown) {
            notifBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = notifDropdown.classList.toggle('is-open');
                userDropdown?.classList.remove('is-open');
                userMenuBtn?.setAttribute('aria-expanded', 'false');
                if (isOpen && !notifLoaded) { notifLoaded = true; loadNotifications(); }
            });
            // Auto-load badge count
            loadNotifications();
        }

        document.addEventListener('click', (event) => {
            if (!searchShell?.contains(event.target)) {
                closeSearchResults();
            }
            userDropdown?.classList.remove('is-open');
            userMenuBtn?.setAttribute('aria-expanded', 'false');
            notifDropdown?.classList.remove('is-open');
        });
    </script>
</body>
</html>
