<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บัญชีของฉัน | บ้านครีม สิงห์บุรี</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ff4f87;
            --accent-color: #1fbad6;
            --gold-color: #f8c64f;
            --text-dark: #1a2233;
            --text-soft: #62708a;
            --border-color: #e7ebf3;
            --surface-color: #ffffff;
            --page-color: #f6f8fc;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Prompt', sans-serif; background: var(--page-color); color: var(--text-dark); }
        a { color: inherit; text-decoration: none; }

        .topbar {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 0 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            min-height: 64px;
        }
        .topbar-brand { font-size: 1.4rem; font-weight: 700; color: var(--primary-color); }
        .topbar-back { display: flex; align-items: center; gap: 6px; color: var(--text-soft); font-size: 0.92rem; margin-left: auto; }
        .topbar-back:hover { color: var(--primary-color); }

        .page-wrap {
            max-width: 1100px;
            margin: 32px auto;
            padding: 0 24px;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 24px;
            align-items: start;
        }

        /* Sidebar */
        .sidebar { display: grid; gap: 16px; }
        .card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 20px;
        }
        .profile-avatar {
            width: 64px; height: 64px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--primary-color), #6a67ff);
            color: white; font-size: 1.6rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 12px;
        }
        .profile-name { font-weight: 700; font-size: 1.05rem; margin-bottom: 4px; }
        .profile-username { color: var(--text-soft); font-size: 0.88rem; margin-bottom: 10px; }
        .member-badge {
            display: inline-block;
            background: #e9fff5; color: #117a4d;
            border: 1px solid #b8f0d6;
            border-radius: 999px; padding: 4px 12px;
            font-size: 0.8rem; font-weight: 600;
        }
        .sidebar-menu { display: grid; gap: 4px; }
        .sidebar-link {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 12px;
            color: var(--text-soft); font-size: 0.95rem; font-weight: 500;
            transition: all 0.15s;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background: #fff4f8; color: var(--primary-color);
        }
        .sidebar-link .icon { font-size: 1.1rem; width: 22px; text-align: center; }
        .sidebar-logout { color: #dc2626 !important; }
        .sidebar-logout:hover { background: #fff1f2 !important; }

        /* Main Content */
        .main-content { display: grid; gap: 20px; }
        .section-title {
            font-size: 1.35rem; font-weight: 700; margin-bottom: 18px;
        }

        /* Order cards */
        .order-card {
            background: white; border: 1px solid var(--border-color);
            border-radius: 16px; padding: 18px 20px;
            display: grid; gap: 12px;
        }
        .order-header {
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 8px;
        }
        .order-id { font-weight: 700; font-size: 0.95rem; }
        .order-date { color: var(--text-soft); font-size: 0.85rem; }
        .order-status {
            border-radius: 999px; padding: 4px 12px;
            font-size: 0.8rem; font-weight: 600;
        }
        .order-products {
            display: flex; gap: 10px; flex-wrap: wrap;
        }
        .order-product-img {
            width: 52px; height: 52px; border-radius: 10px;
            background: #f3f4f8; overflow: hidden; flex-shrink: 0;
        }
        .order-product-img img { width: 100%; height: 100%; object-fit: cover; }
        .order-footer {
            display: flex; justify-content: space-between; align-items: center;
            padding-top: 10px; border-top: 1px solid var(--border-color);
            flex-wrap: wrap; gap: 8px;
        }
        .order-total { font-weight: 700; font-size: 1rem; }
        .btn-detail {
            border: 1px solid var(--border-color); border-radius: 999px;
            padding: 7px 16px; font-size: 0.88rem; font-weight: 600;
            color: var(--text-soft); background: white; cursor: pointer;
            transition: all 0.15s; font-family: inherit;
        }
        .btn-detail:hover { border-color: var(--primary-color); color: var(--primary-color); }
        .empty-state {
            text-align: center; padding: 56px 24px; color: var(--text-soft);
        }
        .empty-icon { font-size: 3rem; margin-bottom: 12px; opacity: 0.4; }
        .btn-primary {
            display: inline-block; margin-top: 16px;
            background: linear-gradient(135deg, #35c98b, #1fbad6);
            color: white; border: none; border-radius: 999px;
            padding: 12px 28px; font-family: inherit; font-weight: 700;
            font-size: 0.95rem; cursor: pointer;
        }
        .btn-primary:hover { opacity: 0.88; }

        @media (max-width: 720px) {
            .page-wrap { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="topbar">
        <a href="{{ route('home') }}" class="topbar-brand">🏠 บ้านครีม สิงห์บุรี</a>
        <a href="{{ route('home') }}" class="topbar-back">← กลับหน้าร้าน</a>
    </div>

    <div class="page-wrap">
        {{-- Sidebar --}}
        <aside class="sidebar">
            <div class="card">
                <div class="profile-avatar">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                <div class="profile-name">{{ $user->name }}</div>
                <div class="profile-username">Username: {{ $user->username ?? '-' }}</div>
                <span class="member-badge">สมาชิกทั่วไป</span>
            </div>

            <div class="card" style="padding: 12px 8px;">
                <nav class="sidebar-menu">
                    <a href="{{ route('account.index') }}" class="sidebar-link active">
                        <span class="icon">👤</span> โปรไฟล์ส่วนตัว
                    </a>
                    <a href="{{ route('account.orders') }}" class="sidebar-link">
                        <span class="icon">📋</span> ประวัติการสั่งซื้อ
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="sidebar-link sidebar-logout" style="width:100%; border:none; background:none; font-family:inherit; cursor:pointer; text-align:left;">
                            <span class="icon">↩</span> ออกจากระบบ
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        {{-- Main --}}
        <main class="main-content">
            <div class="card">
                <h1 class="section-title">ประวัติการสั่งซื้อ</h1>

                @if($orders->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">🛍️</div>
                        <div style="font-weight:600; font-size:1rem; color: var(--text-dark); margin-bottom:6px;">ยังไม่มีรายการสั่งซื้อ</div>
                        <div>เริ่มช้อปปิ้งเพื่อรับสิทธิพิเศษสมาชิก</div>
                        <a href="{{ route('home') }}" class="btn-primary">ไปเลือกซื้อสินค้า</a>
                    </div>
                @else
                    <div style="display:grid; gap:14px;">
                        @foreach($orders as $order)
                            @php
                                $statusMap = [
                                    'pending'    => ['label' => 'รอชำระเงิน',      'bg' => '#fff7ed', 'color' => '#c2410c'],
                                    'processing' => ['label' => 'กำลังดำเนินการ',  'bg' => '#eff6ff', 'color' => '#1d4ed8'],
                                    'shipped'    => ['label' => 'จัดส่งแล้ว',       'bg' => '#f5f3ff', 'color' => '#6d28d9'],
                                    'completed'  => ['label' => 'สำเร็จ',          'bg' => '#ecfdf5', 'color' => '#065f46'],
                                    'cancelled'  => ['label' => 'ยกเลิก',          'bg' => '#fff1f2', 'color' => '#be123c'],
                                ];
                                $s = $statusMap[$order->status] ?? ['label' => $order->status, 'bg' => '#f3f4f6', 'color' => '#374151'];
                            @endphp
                            <div class="order-card">
                                <div class="order-header">
                                    <div>
                                        <div class="order-id">คำสั่งซื้อ #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                                        <div class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                    </div>
                                    <span class="order-status" style="background:{{ $s['bg'] }}; color:{{ $s['color'] }};">
                                        {{ $s['label'] }}
                                    </span>
                                </div>

                                @if($order->items->count())
                                    <div class="order-products">
                                        @foreach($order->items->take(4) as $item)
                                            <div class="order-product-img" title="{{ $item->product?->name }}">
                                                @if($item->product?->displayImage())
                                                    <img src="{{ asset('storage/' . $item->product->displayImage()) }}" alt="{{ $item->product->name }}">
                                                @else
                                                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#9aa7bd;font-size:0.7rem;">No img</div>
                                                @endif
                                            </div>
                                        @endforeach
                                        @if($order->items->count() > 4)
                                            <div class="order-product-img" style="display:flex;align-items:center;justify-content:center;color:var(--text-soft);font-size:0.8rem;">
                                                +{{ $order->items->count() - 4 }}
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <div class="order-footer">
                                    <div>
                                        <span style="color:var(--text-soft);font-size:0.88rem;">ยอดรวม </span>
                                        <span class="order-total">฿{{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                    <a href="{{ route('account.order', $order->id) }}" class="btn-detail">ดูรายละเอียด</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
