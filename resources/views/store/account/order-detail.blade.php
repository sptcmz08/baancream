<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดคำสั่งซื้อ #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} | บ้านครีม</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ff4f87;
            --text-dark: #1a2233;
            --text-soft: #62708a;
            --border-color: #e7ebf3;
            --page-color: #f6f8fc;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Prompt', sans-serif; background: var(--page-color); color: var(--text-dark); }
        a { color: inherit; text-decoration: none; }
        .topbar {
            background: white; border-bottom: 1px solid var(--border-color);
            padding: 0 24px; display: flex; align-items: center; gap: 18px; min-height: 64px;
        }
        .topbar-brand { font-size: 1.4rem; font-weight: 700; color: var(--primary-color); }
        .page-wrap { max-width: 800px; margin: 32px auto; padding: 0 24px; display: grid; gap: 20px; }
        .card { background: white; border: 1px solid var(--border-color); border-radius: 20px; padding: 24px; }
        .back-link { display: inline-flex; align-items: center; gap: 6px; color: var(--text-soft); font-size: 0.92rem; margin-bottom: 20px; }
        .back-link:hover { color: var(--primary-color); }
        .order-title { font-size: 1.4rem; font-weight: 700; margin-bottom: 4px; }
        .order-subtitle { color: var(--text-soft); font-size: 0.9rem; }

        /* Status tracker */
        .status-tracker {
            display: flex; align-items: flex-start; gap: 0;
            margin: 24px 0; overflow-x: auto;
        }
        .status-step {
            flex: 1; display: flex; flex-direction: column; align-items: center;
            position: relative; min-width: 80px;
        }
        .status-step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 17px; left: 50%; width: 100%; height: 3px;
            background: var(--border-color);
        }
        .status-step.done:not(:last-child)::after { background: #35c98b; }
        .status-dot {
            width: 36px; height: 36px; border-radius: 999px;
            background: var(--border-color); color: #9aa7bd;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; position: relative; z-index: 1;
            border: 3px solid white; box-shadow: 0 0 0 3px var(--border-color);
        }
        .status-step.done .status-dot { background: #35c98b; color: white; box-shadow: 0 0 0 3px #35c98b; }
        .status-step.active .status-dot { background: #3b82f6; color: white; box-shadow: 0 0 0 3px #3b82f6; }
        .status-step.cancelled .status-dot { background: #ef4444; color: white; box-shadow: 0 0 0 3px #ef4444; }
        .status-label { font-size: 0.76rem; margin-top: 8px; text-align: center; color: var(--text-soft); font-weight: 500; }
        .status-step.done .status-label, .status-step.active .status-label { color: var(--text-dark); font-weight: 600; }

        /* Items table */
        .items-table { width: 100%; border-collapse: collapse; }
        .items-table th { text-align: left; padding: 10px 0; color: var(--text-soft); font-size: 0.85rem; border-bottom: 1px solid var(--border-color); }
        .items-table td { padding: 14px 0; border-bottom: 1px solid var(--border-color); vertical-align: middle; }
        .item-thumb { width: 52px; height: 52px; border-radius: 10px; background: #f3f4f8; overflow: hidden; }
        .item-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .item-name { font-weight: 600; font-size: 0.95rem; }
        .item-variant { color: var(--text-soft); font-size: 0.82rem; margin-top: 2px; }
        .total-row { display: flex; justify-content: space-between; padding: 10px 0; font-size: 0.95rem; }
        .total-row.grand { font-weight: 700; font-size: 1.1rem; border-top: 2px solid var(--border-color); padding-top: 14px; margin-top: 4px; }
        .status-badge {
            display: inline-block; border-radius: 999px; padding: 5px 14px;
            font-size: 0.85rem; font-weight: 600;
        }
        .items-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        @media (max-width: 640px) {
            body { overflow-x: hidden; }
            .topbar {
                padding: 12px 16px;
                min-height: auto;
            }
            .topbar-brand {
                font-size: 1.05rem;
                line-height: 1.4;
            }
            .page-wrap {
                margin: 16px auto 28px;
                padding: 0 12px;
                gap: 14px;
            }
            .card {
                padding: 16px;
                border-radius: 16px;
            }
            .order-title {
                font-size: 1.18rem;
                line-height: 1.35;
            }
            .status-tracker {
                padding-bottom: 8px;
            }
            .items-table {
                min-width: 520px;
                font-size: 0.88rem;
            }
            .total-row {
                gap: 16px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="topbar">
        <a href="{{ route('home') }}" class="topbar-brand">🏠 บ้านครีม สิงห์บุรี</a>
    </div>

    <div class="page-wrap">
        <a href="{{ route('account.index') }}" class="back-link">← กลับบัญชีของฉัน</a>

        @php
            $mediaUrl = fn (?string $path) => $path ? '/media/' . ltrim($path, '/') : null;
            $statusMap = [
                'pending'    => ['label' => 'รอชำระเงิน',     'bg' => '#fff7ed', 'color' => '#c2410c'],
                'confirmed'  => ['label' => 'ยืนยันแล้ว',     'bg' => '#ecfeff', 'color' => '#0e7490'],
                'paid_wait_shipping' => ['label' => 'เตรียมจัดส่ง', 'bg' => '#eff6ff', 'color' => '#1d4ed8'],
                'processing' => ['label' => 'กำลังดำเนินการ', 'bg' => '#eff6ff', 'color' => '#1d4ed8'],
                'shipped'    => ['label' => 'จัดส่งแล้ว',      'bg' => '#f5f3ff', 'color' => '#6d28d9'],
                'completed'  => ['label' => 'สำเร็จ',         'bg' => '#ecfdf5', 'color' => '#065f46'],
                'cancelled'  => ['label' => 'ยกเลิก',         'bg' => '#fff1f2', 'color' => '#be123c'],
            ];
            $s = $statusMap[$order->status] ?? ['label' => $order->status, 'bg' => '#f3f4f6', 'color' => '#374151'];
            $steps = ['pending', 'paid_wait_shipping', 'shipped', 'completed'];
            $currentIdx = array_search($order->status, $steps);
        @endphp

        {{-- Order Header --}}
        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:start; flex-wrap:wrap; gap:12px;">
                <div>
                    <div class="order-title">คำสั่งซื้อ #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                    <div class="order-subtitle">วันที่สั่ง: {{ $order->created_at->format('d M Y, H:i น.') }}</div>
                </div>
                <span class="status-badge" style="background:{{ $s['bg'] }}; color:{{ $s['color'] }};">
                    {{ $s['label'] }}
                </span>
            </div>

            {{-- Status Tracker --}}
            @if($order->status !== 'cancelled')
                <div class="status-tracker">
                    @foreach(['pending' => '💳', 'paid_wait_shipping' => '📦', 'shipped' => '🚚', 'completed' => '✅'] as $step => $icon)
                        @php
                            $stepIdx = array_search($step, $steps);
                            $cls = 'status-step';
                            if (!is_bool($currentIdx)) {
                                if ($stepIdx < $currentIdx) $cls .= ' done';
                                elseif ($stepIdx === $currentIdx) $cls .= ' active';
                            }
                        @endphp
                        <div class="{{ $cls }}">
                            <div class="status-dot">{{ $icon }}</div>
                            <div class="status-label">{{ $statusMap[$step]['label'] }}</div>
                        </div>
                    @endforeach
                </div>
                @if($order->tracking_number)
                    <div style="margin-top:8px; padding:12px 16px; background:#f5f3ff; border-radius:12px; font-size:0.92rem;">
                        🚚 เลขพัสดุ: <strong style="color:#6d28d9;">{{ $order->tracking_number }}</strong>
                    </div>
                @endif
            @else
                <div style="margin-top:16px; padding:12px 16px; background:#fff1f2; border-radius:12px; color:#be123c; font-weight:600;">
                    ❌ คำสั่งซื้อนี้ถูกยกเลิกแล้ว
                </div>
            @endif
        </div>

        {{-- Items --}}
        <div class="card">
            <h2 style="font-size:1.05rem; font-weight:700; margin-bottom:16px;">รายการสินค้า</h2>
            <div class="items-table-wrap">
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width:60px;"></th>
                        <th>สินค้า</th>
                        <th style="text-align:center;">จำนวน</th>
                        <th style="text-align:right;">ราคา</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="item-thumb">
                                    @if($item->product?->displayImage())
                                        <img src="{{ $mediaUrl($item->product->displayImage()) }}" alt="">
                                    @endif
                                </div>
                            </td>
                            <td style="padding-left:12px;">
                                <div class="item-name">{{ $item->product?->name ?? 'สินค้าถูกลบแล้ว' }}</div>
                                @if($item->variant_name)
                                    <div class="item-variant">สูตร: {{ $item->variant_name }}</div>
                                @endif
                            </td>
                            <td style="text-align:center;">{{ $item->quantity }}</td>
                            <td style="text-align:right; font-weight:600;">฿{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>

            <div style="margin-top:16px;">
                <div class="total-row"><span>ค่าสินค้า</span><span>฿{{ number_format($order->total_amount - ($order->shipping_cost ?? 0), 2) }}</span></div>
                <div class="total-row"><span>ค่าจัดส่ง</span><span style="color:#10b981;">{{ ($order->shipping_cost ?? 0) > 0 ? '฿' . number_format($order->shipping_cost, 2) : 'ฟรี' }}</span></div>
                <div class="total-row grand"><span>ยอดรวมทั้งหมด</span><span>฿{{ number_format($order->total_amount, 2) }}</span></div>
            </div>
        </div>
    </div>
</body>
</html>
