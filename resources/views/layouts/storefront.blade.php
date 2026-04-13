<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'บ้านครีม สิงห์บุรี | Beauty Marketplace')</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/store-shared.css') }}">
    @yield('styles')
</head>
<body>
    @include('store.partials.layout-header')

    <main>
        @yield('content')
    </main>

    @include('store.partials.floating-cart')
    @include('store.partials.notifications')
    @include('store.partials.auth-modal')

    <script>
        // --- Header Tool Dropdowns ---
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');
        const notifBtn = document.getElementById('notifBtn');
        const notifDropdown = document.getElementById('notifDropdown');

        userMenuBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdown?.classList.toggle('is-open');
            notifDropdown?.classList.remove('is-open');
        });

        notifBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            notifDropdown?.classList.toggle('is-open');
            userDropdown?.classList.remove('is-open');
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('#userMenuWrap')) userDropdown?.classList.remove('is-open');
            if (!e.target.closest('#notifWrap')) notifDropdown?.classList.remove('is-open');
        });

        // --- Sidebar Cart Toggle ---
        const cartSidebar = document.getElementById('cartSidebar');
        const cartOverlay = document.getElementById('cartSidebarOverlay');
        const openCartBtns = document.querySelectorAll('[data-open-cart]');
        const closeCartBtns = document.querySelectorAll('[data-close-cart]');

        const toggleCart = (show = true) => {
            cartSidebar?.classList.toggle('is-active', show);
            cartOverlay?.classList.toggle('is-active', show);
            document.body.style.overflow = show ? 'hidden' : '';
        };

        openCartBtns.forEach(btn => btn.addEventListener('click', () => toggleCart(true)));
        closeCartBtns.forEach(btn => btn.addEventListener('click', () => toggleCart(false)));
        cartOverlay?.addEventListener('click', () => toggleCart(false));

        // --- Global Search Logic ---
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        
        // We'll fetch search data once if not provided
        let allProducts = @json($searchProducts ?? []);
        
        if (allProducts.length === 0) {
            // Optional: fallback fetch if needed, but for now we rely on the composer
        }

        searchInput?.addEventListener('input', (e) => {
            const val = e.target.value.trim().toLowerCase();
            if (val.length < 2) {
                searchResults.classList.remove('is-open');
                return;
            }

            const matches = allProducts.filter(p => p.search.includes(val)).slice(0, 10);
            
            if (matches.length > 0) {
                searchResults.innerHTML = matches.map(p => `
                    <a href="${p.url}" class="search-result-item">
                        <div class="search-result-thumb">
                            <img src="${p.image}" alt="">
                        </div>
                        <div>
                            <div class="search-result-name">${p.name}</div>
                            <div class="search-result-price">฿${p.price}</div>
                        </div>
                    </a>
                `).join('');
            } else {
                searchResults.innerHTML = '<div class="search-result-empty">ไม่พบสินค้าที่ค้นหา</div>';
            }
            searchResults.classList.add('is-open');
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('#searchShell')) searchResults?.classList.remove('is-open');
        });
    </script>
    @yield('scripts')
</body>
</html>
