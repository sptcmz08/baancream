@php
    $mediaUrl = fn (?string $path) => $path ? '/media/' . ltrim($path, '/') : null;
@endphp

<div class="top-strip">
    <div class="top-strip-inner">
        <div class="top-strip-badges">
            <span>🛒 สินค้าความงามพรีเมียม</span>
            <span>📦 ส่งตรงจากบ้านครีม สิงห์บุรี</span>
            <span>✨ อัปเดตสินค้าใหม่ทุกสัปดาห์</span>
        </div>
        <span>บ้านครีม สิงห์บุรี</span>
    </div>
</div>

<header class="header-shell">
    <div class="header-main">
        <div class="header-left">
            <a href="{{ route('home') }}" class="brand-logo" aria-label="บ้านครีม สิงห์บุรี">
                @include('store.partials.site-logo-markup')
            </a>
        </div>

        <div class="header-search">
            <div class="search-shell" id="searchShell">
                <label class="search-box" for="searchInput">
                    <span>🔍</span>
                    <input type="text" id="searchInput" placeholder="ค้นหาสินค้า แบรนด์ หรือหมวดหมู่" autocomplete="off">
                </label>
                <div class="search-results" id="searchResults" aria-live="polite"></div>
            </div>
        </div>

        <div class="header-tools">
            <button type="button" class="cart-icon-link" data-open-cart aria-label="ตะกร้าสินค้า" id="floatingCartButton">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M7 8h13l-1.2 6.6a2 2 0 0 1-2 1.6H9.1a2 2 0 0 1-2-1.7L5.8 5.8H3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9.4 20.2h.1M17 20.2h.1" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"/>
                </svg>
                @php $cartSummary = app(\App\Http\Controllers\StoreController::class)->cartWithTotals(); @endphp
                @if($cartSummary['count'] > 0)
                    <span style="position:absolute; top:4px; right:2px; min-width:26px; height:26px; border-radius:999px; background:#111827; color:white; font-size:0.8rem; font-weight:700; display:flex; align-items:center; justify-content:center; padding:0 7px;">{{ $cartSummary['count'] }}</span>
                @endif
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
                <button type="button" class="user-action" data-open-auth data-auth-mode="login">เข้าสู่ระบบ</button>
            @endauth
        </div>
    </div>
</header>
