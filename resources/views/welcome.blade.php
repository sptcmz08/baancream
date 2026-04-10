<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บ้านครีม สิงห์บุรี | สินค้าทั้งหมด</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --green: #5ab89a;
            --green-dark: #3c9b7d;
            --ink: #1f2937;
            --muted: #7b8799;
            --border: #e8edf4;
            --surface: #ffffff;
            --page: #f7f9fc;
            --card-shadow: 0 16px 40px rgba(24, 40, 72, 0.08);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Prompt', sans-serif; background: var(--page); color: var(--ink); }
        a { text-decoration: none; color: inherit; }
        img { display: block; max-width: 100%; }
        .shell { max-width: 1480px; margin: 0 auto; padding: 0 24px 72px; }
        .hero {
            margin: 24px auto 28px;
            min-height: 320px;
            border-radius: 34px;
            background:
                linear-gradient(90deg, rgba(255,255,255,0.05), rgba(255,255,255,0.02)),
                url('https://images.unsplash.com/photo-1515377905703-c4788e51af15?q=80&w=2200&auto=format&fit=crop') center/cover;
            position: relative;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }
        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(100deg, rgba(21, 40, 53, 0.46), rgba(21, 40, 53, 0.12));
        }
        .hero-content {
            position: relative;
            z-index: 1;
            color: white;
            padding: 44px;
            width: min(620px, 100%);
        }
        .hero-content h1 {
            font-size: clamp(2rem, 4vw, 3.8rem);
            line-height: 1.05;
            margin-bottom: 14px;
        }
        .hero-content p {
            color: rgba(255,255,255,0.88);
            font-size: 1.02rem;
            margin-bottom: 24px;
        }
        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
        .hero-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            border-radius: 999px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.26);
            color: white;
            font-weight: 500;
        }
        .sticky-tabs {
            position: sticky;
            top: 12px;
            z-index: 20;
            background: rgba(247, 249, 252, 0.92);
            backdrop-filter: blur(16px);
            padding: 12px 0 16px;
        }
        .tab-row, .brand-strip {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 4px;
        }
        .tab, .brand-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 26px;
            border-radius: 999px;
            background: white;
            color: #64748b;
            border: 1px solid var(--border);
            font-weight: 600;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.04);
        }
        .tab.active, .tab:hover { color: white; background: linear-gradient(135deg, var(--green), var(--green-dark)); border-color: transparent; }
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin: 28px 0 24px;
        }
        .toolbar h2 { font-size: 2rem; margin-bottom: 4px; }
        .toolbar p { color: var(--muted); }
        .toolbar-right { display: flex; align-items: center; gap: 16px; }
        .search-box {
            width: min(360px, 52vw);
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 13px 18px;
            box-shadow: 0 8px 20px rgba(18, 30, 56, 0.04);
        }
        .search-box input {
            width: 100%;
            border: none;
            outline: none;
            font-family: inherit;
            font-size: 0.95rem;
        }
        .account-link {
            padding: 12px 18px;
            border-radius: 999px;
            background: white;
            border: 1px solid var(--border);
            font-weight: 600;
        }
        .section { margin-bottom: 38px; }
        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 18px;
        }
        .section-head h3 { font-size: 1.9rem; }
        .section-head span { color: #94a3b8; font-weight: 600; }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 24px;
        }
        .product-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 26px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            display: flex;
            flex-direction: column;
        }
        .product-cover {
            aspect-ratio: 1 / 1;
            background: linear-gradient(180deg, #ef9dcc 0%, #e6dff1 100%);
            padding: 14px;
        }
        .product-cover-frame {
            width: 100%;
            height: 100%;
            background: white;
            border-radius: 18px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .product-cover-frame img { width: 100%; height: 100%; object-fit: cover; }
        .product-cover-frame span { color: #a6adbb; font-size: 0.95rem; }
        .product-body {
            padding: 18px 18px 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            flex: 1;
        }
        .tag-row { display: flex; flex-wrap: wrap; gap: 8px; }
        .tag {
            display: inline-flex;
            padding: 6px 10px;
            border-radius: 999px;
            background: #edf9f4;
            color: var(--green-dark);
            font-size: 0.76rem;
            font-weight: 700;
        }
        .tag.brand { background: #eef2ff; color: #5964d8; }
        .product-title {
            font-size: 1.22rem;
            font-weight: 700;
            line-height: 1.35;
            min-height: 3.1em;
        }
        .product-desc { font-size: 0.9rem; color: var(--muted); min-height: 3.7em; }
        .price-stack { display: grid; gap: 6px; }
        .price-line { display: flex; align-items: baseline; gap: 8px; flex-wrap: wrap; }
        .price-chip {
            padding: 4px 8px;
            border-radius: 8px;
            background: #eef2f7;
            color: #9aa4b6;
            font-size: 0.72rem;
            font-weight: 700;
        }
        .price-amount { font-size: 1.05rem; font-weight: 700; }
        .price-amount.wholesale { color: #16a34a; }
        .stock-note { color: var(--muted); font-size: 0.83rem; }
        .stock-note strong { color: var(--green-dark); }
        .card-footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
        }
        .detail-link { font-size: 0.94rem; font-weight: 600; color: #0f172a; }
        .plus-button {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #0b0f19;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            line-height: 1;
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.25);
        }
        .empty-box {
            padding: 40px;
            background: white;
            border: 1px dashed #cdd7e6;
            border-radius: 24px;
            color: var(--muted);
            text-align: center;
            grid-column: 1 / -1;
        }
        @media (max-width: 900px) {
            .shell { padding: 0 16px 72px; }
            .toolbar, .toolbar-right { flex-direction: column; align-items: stretch; }
            .search-box { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="shell">
        <section class="hero">
            <div class="hero-content">
                <h1>ช้อปสินค้าความงาม<br>แยกตามหมวดและสูตรได้ง่าย</h1>
                <p>สินค้า 1 ตัวสามารถมีหลายสูตรจากหลังบ้านได้แล้ว และลูกค้ากดเข้าหน้ารายละเอียดเพื่อเลือกรูป สูตร และราคาแต่ละแบบก่อนใส่ตะกร้าได้ทันที</p>
                <div class="hero-actions">
                    <a href="#featured-products" class="hero-chip">ดูสินค้าทั้งหมด</a>
                    <a href="#new-arrivals" class="hero-chip">สินค้ามาใหม่</a>
                </div>
            </div>
        </section>

        <div class="sticky-tabs">
            <div class="tab-row">
                <a href="#featured-products" class="tab active">ทั้งหมด</a>
                @foreach($categories as $category)
                    <a href="#category-{{ $category->slug }}" class="tab">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>

        <div class="toolbar">
            <div>
                <h2>สินค้าแนะนำ</h2>
                <p>เลือกดูรายการสินค้าแล้วกดเข้าไปเลือกรายละเอียดสูตรก่อนเพิ่มลงตะกร้า</p>
            </div>
            <div class="toolbar-right">
                <label class="search-box">
                    <span>🔎</span>
                    <input type="text" id="searchInput" placeholder="ค้นหาสินค้า สูตร หรือแบรนด์">
                </label>
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="account-link">บัญชีของฉัน</a>
                @else
                    <a href="{{ route('login') }}" class="account-link">เข้าสู่ระบบ</a>
                @endauth
            </div>
        </div>

        <section class="section" id="brands">
            <div class="section-head">
                <h3>แบรนด์</h3>
                <span>{{ $brands->count() }} แบรนด์</span>
            </div>
            <div class="brand-strip">
                @foreach($brands as $brand)
                    <a href="#brand-{{ $brand->slug }}" class="brand-pill">{{ $brand->name }} ({{ $brand->products_count }})</a>
                @endforeach
            </div>
        </section>

        @php
            $sections = [
                'new-arrivals' => ['title' => 'สินค้ามาใหม่', 'items' => $newArrivals],
                'featured-products' => ['title' => 'สินค้าทั้งหมด', 'items' => $featuredProducts],
            ];
        @endphp

        @foreach($sections as $sectionId => $section)
            <section class="section" id="{{ $sectionId }}">
                <div class="section-head">
                    <h3>{{ $section['title'] }}</h3>
                    <span>{{ $section['items']->count() }} รายการ</span>
                </div>
                <div class="product-grid">
                    @forelse($section['items'] as $product)
                        <article class="product-card" data-search="{{ strtolower($product->name . ' ' . ($product->brand->name ?? '') . ' ' . ($product->category->name ?? '') . ' ' . $product->variants->pluck('name')->implode(' ')) }}">
                            <a href="{{ route('products.show', $product) }}" class="product-cover">
                                <div class="product-cover-frame">
                                    @if($product->displayImage())
                                        <img src="{{ asset('storage/' . $product->displayImage()) }}" alt="{{ $product->name }}">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </div>
                            </a>
                            <div class="product-body">
                                <div class="tag-row">
                                    @if($product->category)<span class="tag">{{ $product->category->name }}</span>@endif
                                    @if($product->brand)<span class="tag brand">{{ $product->brand->name }}</span>@endif
                                    @if($product->hasVariants())<span class="tag">{{ $product->variants->count() }} สูตร</span>@endif
                                </div>
                                <a href="{{ route('products.show', $product) }}" class="product-title">{{ $product->name }}</a>
                                <p class="product-desc">{{ Str::limit($product->description ?: 'กดเข้าดูรายละเอียดเพื่อเลือกสูตรและเพิ่มสินค้าลงตะกร้า', 90) }}</p>
                                <div class="price-stack">
                                    <div class="price-line">
                                        <span class="price-chip">ส่ง 1 ชิ้น</span>
                                        <span class="price-amount">฿{{ number_format($product->displayRetailPrice(), 2) }}</span>
                                    </div>
                                    <div class="price-line">
                                        <span class="price-chip">ส่ง 10 ชิ้น</span>
                                        <span class="price-amount wholesale">฿{{ number_format($product->displayWholesalePrice(), 2) }}</span>
                                    </div>
                                </div>
                                <div class="stock-note">
                                    @if($product->hasVariants())
                                        มีให้เลือก <strong>{{ $product->variants->count() }}</strong> สูตร
                                    @else
                                        พร้อมดูรายละเอียดสินค้า
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('products.show', $product) }}" class="detail-link">ดูรายละเอียดสินค้า</a>
                                    <a href="{{ route('products.show', $product) }}" class="plus-button">+</a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="empty-box">ยังไม่มีสินค้าในหมวดนี้</div>
                    @endforelse
                </div>
            </section>
        @endforeach

        @foreach($categories as $category)
            <section class="section" id="category-{{ $category->slug }}">
                <div class="section-head">
                    <h3>{{ $category->name }}</h3>
                    <span>{{ $category->products->count() }} รายการ</span>
                </div>
                <div class="product-grid">
                    @foreach($category->products as $product)
                        <article class="product-card" data-search="{{ strtolower($product->name . ' ' . ($product->brand->name ?? '') . ' ' . $category->name . ' ' . $product->variants->pluck('name')->implode(' ')) }}">
                            <a href="{{ route('products.show', $product) }}" class="product-cover">
                                <div class="product-cover-frame">
                                    @if($product->displayImage())
                                        <img src="{{ asset('storage/' . $product->displayImage()) }}" alt="{{ $product->name }}">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </div>
                            </a>
                            <div class="product-body">
                                <div class="tag-row">
                                    <span class="tag">{{ $category->name }}</span>
                                    @if($product->brand)<span class="tag brand">{{ $product->brand->name }}</span>@endif
                                    @if($product->hasVariants())<span class="tag">{{ $product->variants->count() }} สูตร</span>@endif
                                </div>
                                <a href="{{ route('products.show', $product) }}" class="product-title">{{ $product->name }}</a>
                                <p class="product-desc">{{ Str::limit($product->description ?: 'กดเข้าดูรายละเอียดเพื่อเลือกสูตรและเพิ่มสินค้าลงตะกร้า', 90) }}</p>
                                <div class="card-footer">
                                    <a href="{{ route('products.show', $product) }}" class="detail-link">ดูรายละเอียดสินค้า</a>
                                    <a href="{{ route('products.show', $product) }}" class="plus-button">+</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endforeach

        @foreach($brandCollections as $brand)
            <section class="section" id="brand-{{ $brand->slug }}">
                <div class="section-head">
                    <h3>แบรนด์ {{ $brand->name }}</h3>
                    <span>{{ $brand->products->count() }} รายการ</span>
                </div>
                <div class="product-grid">
                    @foreach($brand->products as $product)
                        <article class="product-card" data-search="{{ strtolower($product->name . ' ' . $brand->name . ' ' . ($product->category->name ?? '') . ' ' . $product->variants->pluck('name')->implode(' ')) }}">
                            <a href="{{ route('products.show', $product) }}" class="product-cover">
                                <div class="product-cover-frame">
                                    @if($product->displayImage())
                                        <img src="{{ asset('storage/' . $product->displayImage()) }}" alt="{{ $product->name }}">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </div>
                            </a>
                            <div class="product-body">
                                <div class="tag-row">
                                    <span class="tag brand">{{ $brand->name }}</span>
                                    @if($product->category)<span class="tag">{{ $product->category->name }}</span>@endif
                                </div>
                                <a href="{{ route('products.show', $product) }}" class="product-title">{{ $product->name }}</a>
                                <p class="product-desc">{{ Str::limit($product->description ?: 'กดเข้าดูรายละเอียดเพื่อเลือกสูตรและเพิ่มสินค้าลงตะกร้า', 90) }}</p>
                                <div class="card-footer">
                                    <a href="{{ route('products.show', $product) }}" class="detail-link">ดูรายละเอียดสินค้า</a>
                                    <a href="{{ route('products.show', $product) }}" class="plus-button">+</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>

    @include('store.partials.floating-cart', ['cartCount' => $cartCount])

    <script>
        const searchInput = document.getElementById('searchInput');
        const cards = Array.from(document.querySelectorAll('[data-search]'));

        searchInput?.addEventListener('input', (event) => {
            const query = event.target.value.trim().toLowerCase();

            cards.forEach((card) => {
                const visible = !query || (card.dataset.search || '').includes(query);
                card.style.display = visible ? '' : 'none';
            });
        });
    </script>
</body>
</html>
