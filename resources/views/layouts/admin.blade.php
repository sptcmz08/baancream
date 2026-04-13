<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Ban Cream Singburi</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=1.2">
    @yield('styles')
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                @if(!empty($storefrontLogoUrl))
                    <img src="{{ $storefrontLogoUrl }}" alt="บ้านครีม สิงห์บุรี" style="max-width: 100%; max-height: 54px; object-fit: contain;">
                @else
                    ✨ Ban Cream
                @endif
            </div>
            <ul class="nav-menu">
                <li><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 ภาพรวม (Dashboard)</a></li>
                <li><a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">📁 หมวดหมู่สินค้า</a></li>
                <li><a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">🛍️ รายการสินค้า (SKU)</a></li>
                <li><a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">📦 ตรวจสอบออเดอร์</a></li>
                <li><a href="{{ route('admin.credits.index') }}" class="nav-link {{ request()->routeIs('admin.credits.*') ? 'active' : '' }}">💳 ระบบเครดิต</a></li>
                <li><a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">👥 จัดการผู้ใช้</a></li>
                <li><a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">🖼️ จัดการแบนเนอร์</a></li>
                <li><a href="{{ url('/admin/settings/branding') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">⚙️ ตั้งค่าเว็บ / โลโก้</a></li>
                <li style="margin-top: 20px; border-top: 1px solid #eee;">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf 
                        <button type="submit" class="nav-link" style="border:none;background:none;width:100%;text-align:left;cursor:pointer;color:#dc2626;">🚪 ออกจากระบบ</button>
                    </form>
                </li>
            </ul>
        </aside>
        <main class="main-content">
            <header class="topbar">
                <div style="display: flex; gap: 15px; align-items: center;">
                    <span style="color: var(--text-muted);">โหมดผู้ดูแลระบบ</span>
                    <span style="font-weight: 500;">{{ auth()->user()->name ?? 'Administrator' }}</span>
                    <span style="color: var(--text-muted);">| {{ auth()->user()->email ?? '-' }}</span>
                </div>
            </header>
            <section class="content-area">
                @if(session('success'))
                    <div style="background: #22c55e15; color: #16a34a; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #22c55e40;">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div style="background: #fee2e2; color: #dc2626; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #fecaca;">
                        {{ session('error') }}
                    </div>
                @endif
                @if($errors->any())
                    <div style="background: #fff7ed; color: #9a3412; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #fed7aa;">
                        <strong>กรุณาตรวจสอบข้อมูลต่อไปนี้</strong>
                        <ul style="margin: 10px 0 0 20px; padding: 0;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </section>
        </main>
    </div>
    @yield('scripts')
</body>
</html>
