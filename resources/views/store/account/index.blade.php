<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บัญชีของฉัน | บ้านครีม สิงห์บุรี</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #ff4f87;
            --accent: #1fbad6;
            --green: #35c98b;
            --text: #1a2233;
            --soft: #62708a;
            --border: #e7ebf3;
            --bg: #f6f8fc;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Prompt',sans-serif; background:var(--bg); color:var(--text); }
        a { color:inherit; text-decoration:none; }

        /* Topbar */
        .topbar {
            background:white; border-bottom:1px solid var(--border);
            padding:0 32px; display:flex; align-items:center; gap:16px; min-height:60px;
        }
        .topbar-logo { font-size:1.2rem; font-weight:700; color:var(--primary); }
        .topbar-back { margin-left:auto; color:var(--soft); font-size:0.88rem; display:flex; align-items:center; gap:5px; }
        .topbar-back:hover { color:var(--primary); }

        /* Layout */
        .layout {
            max-width:1060px; margin:28px auto; padding:0 20px;
            display:grid; grid-template-columns:260px 1fr; gap:20px; align-items:start;
        }

        /* Card base */
        .card { background:white; border:1px solid var(--border); border-radius:18px; }

        /* Sidebar profile */
        .profile-card { padding:20px; }
        .profile-avatar {
            width:58px; height:58px; border-radius:999px;
            background:linear-gradient(135deg,var(--primary),#6a67ff);
            color:white; font-size:1.5rem; font-weight:700;
            display:flex; align-items:center; justify-content:center; margin-bottom:10px;
        }
        .profile-name { font-weight:700; font-size:1rem; }
        .profile-sub { font-size:0.82rem; color:var(--soft); margin-top:2px; margin-bottom:10px; }
        .badge-member {
            display:inline-block; background:#e9fff5; color:#117a4d;
            border:1px solid #b8f0d6; border-radius:999px; padding:3px 10px; font-size:0.75rem; font-weight:600;
        }

        /* Sidebar tabs */
        .tabs-card { padding:8px; margin-top:12px; }
        .tab-btn {
            width:100%; display:flex; align-items:center; gap:10px;
            padding:10px 12px; border-radius:12px; border:none; background:transparent;
            color:var(--soft); font-size:0.9rem; font-weight:500; font-family:inherit;
            cursor:pointer; text-align:left; transition:all 0.15s;
        }
        .tab-btn:hover { background:#f7f8fb; color:var(--text); }
        .tab-btn.active { background:#fff4f8; color:var(--primary); font-weight:600; }
        .tab-icon { font-size:1rem; width:20px; text-align:center; flex-shrink:0; }
        .tab-logout { color:#dc2626; }
        .tab-logout:hover { background:#fff1f2 !important; color:#dc2626 !important; }

        /* Main panel */
        .main-card { padding:24px; }
        .panel { display:none; }
        .panel.active { display:block; }
        .panel-title { font-size:1.2rem; font-weight:700; margin-bottom:20px; padding-bottom:14px; border-bottom:1px solid var(--border); }

        /* Profile info */
        .info-row { display:flex; gap:12px; padding:12px 0; border-bottom:1px solid var(--border); align-items:center; }
        .info-row:last-child { border-bottom:none; }
        .info-label { width:130px; color:var(--soft); font-size:0.88rem; flex-shrink:0; }
        .info-value { font-weight:500; font-size:0.95rem; }

        /* Orders */
        .order-card {
            border:1px solid var(--border); border-radius:14px; overflow:hidden; margin-bottom:12px;
        }
        .order-head {
            display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;
            padding:14px 16px; background:#f9fafc; border-bottom:1px solid var(--border);
        }
        .order-num { font-weight:700; font-size:0.9rem; }
        .order-date { color:var(--soft); font-size:0.8rem; }
        .status-pill { border-radius:999px; padding:3px 10px; font-size:0.76rem; font-weight:600; }
        .order-body { padding:14px 16px; }
        .order-thumbs { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:12px; }
        .thumb {
            width:48px; height:48px; border-radius:10px; border:1px solid var(--border);
            background:#f3f4f8; overflow:hidden; flex-shrink:0;
        }
        .thumb img { width:100%; height:100%; object-fit:cover; }
        .order-foot { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; }
        .order-total-label { font-size:0.84rem; color:var(--soft); }
        .order-total-amount { font-weight:700; font-size:1rem; }
        .btn-expand {
            border:1px solid var(--border); border-radius:999px; padding:6px 14px;
            background:white; font-family:inherit; font-size:0.82rem; font-weight:600;
            color:var(--soft); cursor:pointer; transition:all 0.15s;
        }
        .btn-expand:hover { border-color:var(--primary); color:var(--primary); }

        /* Status tracker inside expanded */
        .order-detail { display:none; padding:14px 16px; border-top:1px solid var(--border); background:#fafbfd; }
        .order-detail.open { display:block; }
        .tracker { display:flex; margin-bottom:16px; overflow-x:auto; }
        .t-step { flex:1; display:flex; flex-direction:column; align-items:center; position:relative; min-width:70px; }
        .t-step:not(:last-child)::after {
            content:''; position:absolute; top:15px; left:50%; width:100%; height:2px; background:var(--border);
        }
        .t-step.done:not(:last-child)::after { background:var(--green); }
        .t-dot {
            width:32px; height:32px; border-radius:999px; background:var(--border); color:#9aa7bd;
            display:flex; align-items:center; justify-content:center; font-size:0.9rem;
            position:relative; z-index:1; border:3px solid white; box-shadow:0 0 0 2px var(--border);
        }
        .t-step.done .t-dot { background:var(--green); color:white; box-shadow:0 0 0 2px var(--green); }
        .t-step.active .t-dot { background:#3b82f6; color:white; box-shadow:0 0 0 2px #3b82f6; }
        .t-label { font-size:0.7rem; margin-top:6px; color:var(--soft); text-align:center; }
        .t-step.done .t-label, .t-step.active .t-label { color:var(--text); font-weight:600; }
        .detail-items { display:grid; gap:8px; }
        .detail-item { display:flex; gap:10px; align-items:center; }
        .detail-thumb { width:40px; height:40px; border-radius:8px; background:#f3f4f8; border:1px solid var(--border); overflow:hidden; flex-shrink:0; }
        .detail-thumb img { width:100%; height:100%; object-fit:cover; }
        .detail-name { font-size:0.88rem; font-weight:600; }
        .detail-meta { font-size:0.76rem; color:var(--soft); }

        /* Empty state */
        .empty { text-align:center; padding:48px 24px; color:var(--soft); }
        .empty-icon { font-size:2.8rem; opacity:0.35; margin-bottom:12px; }
        .btn-shop {
            display:inline-block; margin-top:14px; background:linear-gradient(135deg,var(--green),var(--accent));
            color:white; border:none; border-radius:999px; padding:10px 24px;
            font-family:inherit; font-weight:700; font-size:0.9rem; cursor:pointer;
        }

        @media(max-width:760px) {
            body { overflow-x:hidden; }
            .topbar {
                padding:12px 16px;
                min-height:auto;
                flex-wrap:wrap;
            }
            .topbar-logo {
                width:100%;
                font-size:1.02rem;
                line-height:1.4;
            }
            .topbar-back {
                margin-left:0;
            }
            .layout {
                grid-template-columns:1fr;
                margin:16px auto;
                padding:0 12px;
            }
            .main-card,
            .profile-card {
                padding:16px;
            }
            .tabs-card {
                display:flex;
                gap:8px;
                overflow-x:auto;
                padding:8px;
                -webkit-overflow-scrolling:touch;
            }
            .tab-btn {
                flex:0 0 auto;
                width:auto;
                white-space:nowrap;
                padding:10px 12px;
            }
            .info-row {
                display:grid;
                gap:4px;
            }
            .info-label {
                width:auto;
            }
            .order-head,
            .order-foot,
            .detail-item {
                align-items:flex-start;
            }
            .tracker {
                padding-bottom:8px;
            }
        }
    </style>
</head>
<body>

<div class="topbar">
    <a href="{{ route('home') }}" class="topbar-logo">🏠 บ้านครีม สิงห์บุรี</a>
    <a href="{{ route('home') }}" class="topbar-back">← กลับหน้าร้าน</a>
</div>

@php
    $mediaUrl = fn (?string $path) => $path ? '/media/' . ltrim($path, '/') : null;
    $statusMap = [
        'pending'    => ['label'=>'รอชำระเงิน',     'bg'=>'#fff7ed','color'=>'#c2410c'],
        'paid_wait_shipping' => ['label'=>'เตรียมจัดส่ง', 'bg'=>'#eff6ff','color'=>'#1d4ed8'],
        'processing' => ['label'=>'กำลังดำเนินการ', 'bg'=>'#eff6ff','color'=>'#1d4ed8'],
        'shipped'    => ['label'=>'จัดส่งแล้ว',      'bg'=>'#f5f3ff','color'=>'#6d28d9'],
        'completed'  => ['label'=>'สำเร็จ',         'bg'=>'#ecfdf5','color'=>'#065f46'],
        'cancelled'  => ['label'=>'ยกเลิก',         'bg'=>'#fff1f2','color'=>'#be123c'],
    ];
    $steps = ['pending','paid_wait_shipping','shipped','completed'];
@endphp

<div class="layout">
    {{-- Sidebar --}}
    <aside>
        <div class="card profile-card">
            <div class="profile-avatar">{{ mb_strtoupper(mb_substr($user->name,0,1)) }}</div>
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-sub">Username: {{ $user->username ?? '-' }}</div>
            <span class="badge-member">สมาชิกทั่วไป</span>
        </div>

        <div class="card tabs-card">
            <button class="tab-btn active" data-tab="profile">
                <span class="tab-icon">👤</span> โปรไฟล์ส่วนตัว
            </button>
            <button class="tab-btn" data-tab="orders">
                <span class="tab-icon">📋</span> ประวัติการสั่งซื้อ
            </button>
            <button class="tab-btn" data-tab="status">
                <span class="tab-icon">📦</span> สถานะการสั่งซื้อ
            </button>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="tab-btn tab-logout">
                    <span class="tab-icon">↩</span> ออกจากระบบ
                </button>
            </form>
        </div>
    </aside>

    {{-- Main --}}
    <main>
        <div class="card main-card">

            {{-- Tab: โปรไฟล์ --}}
            <div class="panel active" id="panel-profile">
                <div class="panel-title">โปรไฟล์ส่วนตัว</div>
                <div class="info-row">
                    <div class="info-label">ชื่อ-นามสกุล</div>
                    <div class="info-value">{{ $user->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Username</div>
                    <div class="info-value">{{ $user->username ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">ระดับสมาชิก</div>
                    <div class="info-value"><span class="badge-member">สมาชิกทั่วไป</span></div>
                </div>
                <div class="info-row">
                    <div class="info-label">สมัครเมื่อ</div>
                    <div class="info-value">{{ $user->created_at->format('d M Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">จำนวนคำสั่งซื้อ</div>
                    <div class="info-value">{{ $orders->count() }} รายการ</div>
                </div>
            </div>

            {{-- Tab: ประวัติการสั่งซื้อ --}}
            <div class="panel" id="panel-orders">
                <div class="panel-title">ประวัติการสั่งซื้อ</div>

                @if($orders->isEmpty())
                    <div class="empty">
                        <div class="empty-icon">🛍️</div>
                        <div style="font-weight:600;color:var(--text);margin-bottom:4px;">ยังไม่มีรายการสั่งซื้อ</div>
                        <div>เริ่มช้อปปิ้งเพื่อรับสิทธิพิเศษสมาชิก</div>
                        <a href="{{ route('home') }}" class="btn-shop">ไปเลือกซื้อสินค้า</a>
                    </div>
                @else
                    @foreach($orders as $order)
                        @php $s = $statusMap[$order->status] ?? ['label'=>$order->status,'bg'=>'#f3f4f6','color'=>'#374151']; @endphp
                        <div class="order-card">
                            <div class="order-head">
                                <div>
                                    <div class="order-num">คำสั่งซื้อ #{{ str_pad($order->id,5,'0',STR_PAD_LEFT) }}</div>
                                    <div class="order-date">{{ $order->created_at->format('d M Y, H:i น.') }}</div>
                                </div>
                                <span class="status-pill" style="background:{{ $s['bg'] }};color:{{ $s['color'] }};">{{ $s['label'] }}</span>
                            </div>
                            <div class="order-body">
                                @if($order->items->count())
                                    <div class="order-thumbs">
                                        @foreach($order->items->take(5) as $item)
                                            <div class="thumb" title="{{ $item->product?->name }}">
                                                @if($item->product?->displayImage())
                                                    <img src="{{ $mediaUrl($item->product->displayImage()) }}" alt="">
                                                @endif
                                            </div>
                                        @endforeach
                                        @if($order->items->count() > 5)
                                            <div class="thumb" style="display:flex;align-items:center;justify-content:center;font-size:0.76rem;color:var(--soft);">+{{ $order->items->count()-5 }}</div>
                                        @endif
                                    </div>
                                @endif
                                <div class="order-foot">
                                    <div>
                                        <div class="order-total-label">ยอดรวม</div>
                                        <div class="order-total-amount">฿{{ number_format($order->total_amount,2) }}</div>
                                    </div>
                                    <button class="btn-expand" onclick="toggleDetail(this)">ดูรายละเอียด ▾</button>
                                </div>
                            </div>
                            {{-- Expandable detail --}}
                            <div class="order-detail">
                                @php
                                    $currentIdx = array_search($order->status, $steps);
                                @endphp
                                @if($order->status !== 'cancelled')
                                    <div class="tracker">
                                        @foreach(['pending'=>'💳','paid_wait_shipping'=>'📦','shipped'=>'🚚','completed'=>'✅'] as $step=>$icon)
                                            @php
                                                $si = array_search($step,$steps);
                                                $cls = 't-step';
                                                if(!is_bool($currentIdx)) {
                                                    if($si < $currentIdx) $cls .= ' done';
                                                    elseif($si === $currentIdx) $cls .= ' active';
                                                }
                                            @endphp
                                            <div class="{{ $cls }}">
                                                <div class="t-dot">{{ $icon }}</div>
                                                <div class="t-label">{{ $statusMap[$step]['label'] }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div style="padding:8px 0 12px;color:#be123c;font-weight:600;font-size:0.88rem;">❌ คำสั่งซื้อนี้ถูกยกเลิกแล้ว</div>
                                @endif
                                <div class="detail-items">
                                    @foreach($order->items as $item)
                                        <div class="detail-item">
                                            <div class="detail-thumb">
                                                @if($item->product?->displayImage())
                                                    <img src="{{ $mediaUrl($item->product->displayImage()) }}" alt="">
                                                @endif
                                            </div>
                                            <div>
                                                <div class="detail-name">{{ $item->product?->name ?? 'สินค้าถูกลบ' }}</div>
                                                <div class="detail-meta">{{ $item->variant_name ? 'สูตร: '.$item->variant_name.' · ' : '' }}{{ $item->quantity }} ชิ้น · ฿{{ number_format($item->total,2) }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Tab: สถานะการสั่งซื้อ --}}
            <div class="panel" id="panel-status">
                <div class="panel-title">สถานะการสั่งซื้อ</div>

                @php $activeOrders = $orders->whereNotIn('status',['completed','cancelled']); @endphp

                @if($activeOrders->isEmpty())
                    <div class="empty">
                        <div class="empty-icon">📦</div>
                        <div style="font-weight:600;color:var(--text);margin-bottom:4px;">ไม่มีคำสั่งซื้อที่กำลังดำเนินการ</div>
                        <div>คำสั่งซื้อที่รอชำระและกำลังจัดส่งจะแสดงที่นี่</div>
                        <a href="{{ route('home') }}" class="btn-shop">ไปเลือกซื้อสินค้า</a>
                    </div>
                @else
                    @foreach($activeOrders as $order)
                        @php
                            $s = $statusMap[$order->status] ?? ['label'=>$order->status,'bg'=>'#f3f4f6','color'=>'#374151'];
                            $currentIdx = array_search($order->status, $steps);
                        @endphp
                        <div class="order-card" style="margin-bottom:16px;">
                            <div class="order-head">
                                <div>
                                    <div class="order-num">คำสั่งซื้อ #{{ str_pad($order->id,5,'0',STR_PAD_LEFT) }}</div>
                                    <div class="order-date">{{ $order->created_at->format('d M Y, H:i น.') }}</div>
                                </div>
                                <span class="status-pill" style="background:{{ $s['bg'] }};color:{{ $s['color'] }};">{{ $s['label'] }}</span>
                            </div>
                            <div class="order-body">
                                <div class="tracker" style="margin-bottom:0;">
                                    @foreach(['pending'=>'💳','paid_wait_shipping'=>'📦','shipped'=>'🚚','completed'=>'✅'] as $step=>$icon)
                                        @php
                                            $si = array_search($step,$steps);
                                            $cls = 't-step';
                                            if(!is_bool($currentIdx)) {
                                                if($si < $currentIdx) $cls .= ' done';
                                                elseif($si === $currentIdx) $cls .= ' active';
                                            }
                                        @endphp
                                        <div class="{{ $cls }}">
                                            <div class="t-dot">{{ $icon }}</div>
                                            <div class="t-label">{{ $statusMap[$step]['label'] }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </main>
</div>

<script>
    // Tab switching
    const tabBtns = document.querySelectorAll('.tab-btn[data-tab]');
    const panels  = document.querySelectorAll('.panel');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(b => b.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('panel-' + btn.dataset.tab)?.classList.add('active');
        });
    });

    // Toggle order detail expand
    function toggleDetail(btn) {
        const detail = btn.closest('.order-card').querySelector('.order-detail');
        const isOpen = detail.classList.toggle('open');
        btn.textContent = isOpen ? 'ซ่อนรายละเอียด ▴' : 'ดูรายละเอียด ▾';
    }

    // Open tab from URL hash
    const hash = location.hash.replace('#','');
    if (hash && document.getElementById('panel-'+hash)) {
        document.querySelector(`[data-tab="${hash}"]`)?.click();
    }
</script>
</body>
</html>
