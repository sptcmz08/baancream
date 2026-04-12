<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ยืนยันการชำระเงิน | บ้านครีม สิงห์บุรี</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-color: #ff4f87;
            --primary-dark: #e93574;
            --gold-color: #f8c64f;
            --text-dark: #152034;
            --text-soft: #708198;
            --border-color: #e7edf3;
            --surface-color: #ffffff;
            --page-color: #f6f8fc;
            --success-color: #16a34a;
            --success-soft: #eaf9ef;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Prompt', sans-serif;
            background: var(--page-color);
            color: var(--text-dark);
        }
        a { color: inherit; text-decoration: none; }
        img { display: block; max-width: 100%; }
        button, input, textarea, select { font: inherit; }

        .header-shell {
            position: sticky;
            top: 0;
            z-index: 20;
            background: rgba(255, 255, 255, 0.98);
            border-bottom: 1px solid var(--border-color);
            backdrop-filter: blur(14px);
        }
        .header-main {
            max-width: 1240px;
            min-height: 74px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }
        .brand-logo {
            display: inline-flex;
            align-items: center;
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: -0.04em;
            flex: 0 0 auto;
        }
        .brand-logo-image {
            height: 48px;
            width: auto;
            object-fit: contain;
        }
        .brand-logo span:nth-child(2) { color: #6a67ff; }
        .brand-logo span:nth-child(3) { color: #22c1dc; }
        .brand-logo span:nth-child(4) { color: #f8c64f; }
        .brand-logo span:nth-child(5) { color: #35c98b; }
        .main-links {
            display: flex;
            gap: 18px;
            align-items: center;
            justify-content: center;
            font-size: 0.92rem;
            font-weight: 600;
            overflow-x: auto;
            white-space: nowrap;
            color: var(--text-soft);
        }
        .main-links a:hover { color: var(--primary-color); }
        .header-tools {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            flex: 0 0 auto;
        }
        .user-action,
        .pill-link {
            border: 1px solid var(--border-color);
            border-radius: 999px;
            padding: 9px 14px;
            font-size: 0.92rem;
            font-weight: 600;
            background: white;
        }
        .user-action:hover,
        .pill-link:hover {
            border-color: rgba(255, 79, 135, 0.35);
            color: var(--primary-color);
        }
        .checkout-page {
            padding: 28px 20px 44px;
        }
        .container {
            max-width: 1240px;
            margin: 0 auto;
        }
        .page-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }
        .page-title {
            font-size: 2.2rem;
            margin: 0;
        }
        .page-link {
            color: var(--text-soft);
        }
        .layout {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(320px, 0.75fr);
            gap: 24px;
            align-items: start;
        }
        .card {
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 28px;
            box-shadow: 0 18px 50px rgba(19, 33, 68, 0.08);
        }
        .main-card {
            padding: 26px;
            display: grid;
            gap: 22px;
        }
        .section-card {
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 20px;
            display: grid;
            gap: 16px;
        }
        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.15rem;
            font-weight: 700;
        }
        .section-icon {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            background: #eef8ff;
            color: #2563eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        .field-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }
        .field {
            display: grid;
            gap: 8px;
        }
        .field.full {
            grid-column: 1 / -1;
        }
        .field label {
            font-size: 0.95rem;
            font-weight: 600;
        }
        .input,
        .textarea {
            width: 100%;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            background: #fbfcff;
            padding: 14px 16px;
            outline: none;
        }
        .input:focus,
        .textarea:focus {
            border-color: rgba(255, 79, 135, 0.32);
            box-shadow: 0 0 0 4px rgba(255, 79, 135, 0.08);
        }
        .textarea {
            min-height: 110px;
            resize: vertical;
        }
        .field-help {
            color: #dc2626;
            font-size: 0.85rem;
        }

        /* Address Book */
        .address-selector {
            display: grid;
            gap: 10px;
            margin-bottom: 16px;
        }
        .address-card {
            border: 2px solid var(--border-color);
            border-radius: 16px;
            padding: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .address-card:hover {
            border-color: rgba(255, 79, 135, 0.3);
        }
        .address-card.selected {
            border-color: var(--primary-color);
            background: rgba(255, 79, 135, 0.03);
        }
        .address-card .addr-name {
            font-weight: 600;
        }
        .address-card .addr-detail {
            color: var(--text-soft);
            font-size: 0.88rem;
            margin-top: 4px;
            line-height: 1.6;
        }
        .address-card .addr-badge {
            display: inline-block;
            background: #eef8ff;
            color: #2563eb;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 6px;
        }

        .payment-option {
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 16px;
            display: grid;
            gap: 14px;
            cursor: pointer;
        }
        .payment-option.active {
            border-color: rgba(255, 79, 135, 0.28);
            box-shadow: 0 0 0 4px rgba(255, 79, 135, 0.08);
        }
        .payment-head {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
        }
        .payment-meta {
            color: var(--text-soft);
            font-size: 0.92rem;
            line-height: 1.8;
        }
        .slip-box {
            display: grid;
            gap: 12px;
            padding: 16px;
            border-radius: 18px;
            background: #fbfcff;
            border: 1px dashed #cfd8e5;
        }
        .slip-box[hidden] {
            display: none;
        }
        .submit-button {
            width: 100%;
            min-height: 56px;
            border: none;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--gold-color), #ffb340);
            color: #46260a;
            font-weight: 700;
            cursor: pointer;
        }
        .summary-card {
            padding: 20px;
            display: grid;
            gap: 16px;
            position: sticky;
            top: 96px;
        }
        .summary-title {
            font-size: 1.2rem;
            font-weight: 700;
        }
        .summary-item {
            display: grid;
            grid-template-columns: 46px 1fr auto;
            gap: 10px;
            align-items: start;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
        }
        .summary-thumb {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            overflow: hidden;
            background: #f8fafc;
            border: 1px solid var(--border-color);
        }
        .summary-thumb img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 4px;
        }
        .summary-name {
            font-weight: 600;
            line-height: 1.45;
        }
        .summary-sub {
            color: var(--text-soft);
            font-size: 0.86rem;
            margin-top: 4px;
        }
        .summary-price {
            font-weight: 700;
        }
        .summary-total {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            font-size: 1.32rem;
            font-weight: 700;
            color: var(--success-color);
            padding-top: 8px;
        }
        .summary-line {
            display: flex;
            justify-content: space-between;
            font-size: 0.92rem;
            padding: 4px 0;
        }
        .summary-line.muted {
            color: var(--text-soft);
        }
        .alert {
            padding: 14px 16px;
            border-radius: 18px;
            font-size: 0.94rem;
        }
        .alert.error {
            background: #fff1f2;
            color: #be123c;
            border: 1px solid #fecdd3;
        }
        .credit-note {
            padding: 14px 16px;
            border-radius: 18px;
            background: var(--success-soft);
            color: var(--success-color);
            font-size: 0.92rem;
            line-height: 1.7;
        }
        .fee-info {
            padding: 10px 14px;
            border-radius: 14px;
            background: #fff7ed;
            color: #c2410c;
            font-size: 0.88rem;
            margin-top: 8px;
        }

        @media (max-width: 980px) {
            .header-main {
                align-items: flex-start;
                flex-direction: column;
                padding-top: 16px;
                padding-bottom: 16px;
            }
            .main-links {
                justify-content: flex-start;
                width: 100%;
            }
            .header-tools {
                flex-wrap: wrap;
                justify-content: flex-start;
            }
            .layout {
                grid-template-columns: 1fr;
            }
            .summary-card {
                position: static;
            }
        }

        @media (max-width: 640px) {
            .checkout-page {
                padding: 22px 14px 34px;
            }
            .header-main {
                padding-left: 14px;
                padding-right: 14px;
            }
            .brand-logo { font-size: 2rem; }
            .main-card,
            .summary-card {
                padding: 18px;
            }
            .field-grid {
                grid-template-columns: 1fr;
            }
            .page-title {
                font-size: 1.85rem;
            }
            .summary-item {
                grid-template-columns: 42px 1fr;
            }
            .summary-thumb {
                width: 42px;
                height: 42px;
            }
            .summary-price {
                grid-column: 2;
            }
        }
    </style>
</head>
<body>
    <header class="header-shell">
        <div class="header-main">
            <a href="{{ route('home') }}" class="brand-logo" aria-label="บ้านครีม สิงห์บุรี">
                @include('store.partials.site-logo-markup')
            </a>

            <nav class="main-links" aria-label="เมนูหลัก">
                <a href="{{ route('home') }}">หน้าแรก</a>
                <a href="{{ route('home') }}#catalog">เลือกสินค้าเพิ่ม</a>
                <a href="{{ route('cart.index') }}">ตะกร้าสินค้า</a>
            </nav>

            <div class="header-tools">
                <a href="{{ route('cart.index') }}" class="pill-link">ตะกร้า {{ $cartCount }} ชิ้น</a>
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('account.index') }}" class="user-action">บัญชีของฉัน</a>
            </div>
        </div>
    </header>

    <div class="checkout-page">
    <div class="container">
        <div class="page-head">
            <div>
                <h1 class="page-title">ยืนยันคำสั่งซื้อ</h1>
                <a href="{{ route('cart.index') }}" class="page-link">&larr; กลับไปตะกร้าสินค้า</a>
            </div>
        </div>

        @if(session('error'))
            <div class="alert error" style="margin-bottom:20px;">{{ session('error') }}</div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data" class="layout" id="checkoutForm">
            @csrf

            <div class="card main-card">
                {{-- Section 1: Address Book + Shipping --}}
                <div class="section-card">
                    <div class="section-title">
                        <span class="section-icon">1</span>
                        <span>ข้อมูลจัดส่งสินค้า</span>
                    </div>

                    {{-- Saved Addresses --}}
                    @if($addresses->isNotEmpty())
                    <div class="address-selector" id="addressSelector">
                        @foreach($addresses as $addr)
                        <div class="address-card {{ $addr->is_primary ? 'selected' : '' }}"
                             data-address-id="{{ $addr->id }}"
                             data-name="{{ $addr->recipient_name }}"
                             data-phone="{{ $addr->phone }}"
                             data-address="{{ $addr->address_line }}"
                             data-subdistrict="{{ $addr->subdistrict }}"
                             data-district="{{ $addr->district }}"
                             data-province="{{ $addr->province }}"
                             data-postal="{{ $addr->postal_code }}"
                             onclick="selectAddress(this)">
                            <div>
                                <span class="addr-name">{{ $addr->recipient_name }}</span>
                                @if($addr->is_primary)
                                    <span class="addr-badge">ที่อยู่หลัก</span>
                                @endif
                                @if($addr->label)
                                    <span class="addr-badge" style="background:#f3f4f6; color:#6b7280;">{{ $addr->label }}</span>
                                @endif
                            </div>
                            <div class="addr-detail">
                                {{ $addr->phone }}<br>
                                {{ $addr->address_line }} {{ $addr->subdistrict }} {{ $addr->district }} {{ $addr->province }} {{ $addr->postal_code }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div style="font-size:0.85rem; color:var(--text-soft); margin-bottom:8px;">
                        หรือกรอกที่อยู่ใหม่ด้านล่าง
                    </div>
                    @endif

                    <div class="field-grid">
                        <div class="field">
                            <label for="recipient_name">ชื่อ - นามสกุล</label>
                            <input id="recipient_name" class="input" type="text" name="recipient_name" value="{{ old('recipient_name', $primaryAddress->recipient_name ?? $customerName) }}" required>
                            @error('recipient_name')
                                <div class="field-help">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="phone">เบอร์โทรศัพท์</label>
                            <input id="phone" class="input" type="text" name="phone" value="{{ old('phone', $primaryAddress->phone ?? '') }}" required>
                            @error('phone')
                                <div class="field-help">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field full">
                            <label for="address_line">รายละเอียดที่อยู่</label>
                            <textarea id="address_line" class="textarea" name="address_line" required>{{ old('address_line', $primaryAddress->address_line ?? '') }}</textarea>
                            @error('address_line')
                                <div class="field-help">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="subdistrict">ตำบล / แขวง</label>
                            <input id="subdistrict" class="input" type="text" name="subdistrict" value="{{ old('subdistrict', $primaryAddress->subdistrict ?? '') }}" required>
                            @error('subdistrict')
                                <div class="field-help">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="district">อำเภอ / เขต</label>
                            <input id="district" class="input" type="text" name="district" value="{{ old('district', $primaryAddress->district ?? '') }}" required>
                            @error('district')
                                <div class="field-help">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="province">จังหวัด</label>
                            <input id="province" class="input" type="text" name="province" value="{{ old('province', $primaryAddress->province ?? '') }}" required>
                            @error('province')
                                <div class="field-help">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="postal_code">รหัสไปรษณีย์</label>
                            <input id="postal_code" class="input" type="text" name="postal_code" value="{{ old('postal_code', $primaryAddress->postal_code ?? '') }}" required>
                            @error('postal_code')
                                <div class="field-help">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field full">
                            <label for="order_note">หมายเหตุเพิ่มเติม</label>
                            <textarea id="order_note" class="textarea" name="order_note">{{ old('order_note') }}</textarea>
                            @error('order_note')
                                <div class="field-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Section 2: Payment Methods --}}
                <div class="section-card">
                    <div class="section-title">
                        <span class="section-icon">2</span>
                        <span>วิธีชำระเงิน</span>
                    </div>

                    {{-- PromptPay --}}
                    <label class="payment-option {{ old('payment_type', 'promptpay') === 'promptpay' ? 'active' : '' }}" data-payment-option>
                        <div class="payment-head">
                            <input type="radio" name="payment_type" value="promptpay" {{ old('payment_type', 'promptpay') === 'promptpay' ? 'checked' : '' }}>
                            <span>💳 โอนเงิน / PromptPay</span>
                        </div>
                        <div class="payment-meta">
                            ชำระผ่าน PromptPay แล้วแนบสลิปเพื่อยืนยันการชำระเงิน
                        </div>
                        <div class="slip-box" id="promptpaySlipBox" {{ old('payment_type', 'promptpay') === 'credit' ? 'hidden' : '' }}>
                            <div style="font-weight:700;">แนบสลิปการโอน</div>
                            <input type="file" class="input" name="slip_image" accept="image/*">
                            @error('slip_image')
                                <div class="field-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </label>

                    {{-- COD --}}
                    <label class="payment-option {{ old('payment_type') === 'cod' ? 'active' : '' }}" data-payment-option>
                        <div class="payment-head">
                            <input type="radio" name="payment_type" value="cod" {{ old('payment_type') === 'cod' ? 'checked' : '' }}>
                            <span>📦 เก็บเงินปลายทาง (COD)</span>
                        </div>
                        <div class="payment-meta">
                            ชำระเงินเมื่อได้รับสินค้า
                        </div>
                        <div class="fee-info" id="codFeeInfo" {{ old('payment_type') !== 'cod' ? 'hidden' : '' }}>
                            ⚠️ มีค่าบริการ COD 3% ของยอดสินค้า = <strong>฿{{ number_format($codFee, 2) }}</strong>
                        </div>
                    </label>

                    {{-- Pickup --}}
                    <label class="payment-option {{ old('payment_type') === 'pickup' ? 'active' : '' }}" data-payment-option>
                        <div class="payment-head">
                            <input type="radio" name="payment_type" value="pickup" {{ old('payment_type') === 'pickup' ? 'checked' : '' }}>
                            <span>🏪 รับหน้าร้าน</span>
                        </div>
                        <div class="payment-meta">
                            มารับสินค้าที่ร้านด้วยตัวเอง ไม่มีค่าจัดส่ง
                        </div>
                    </label>

                    {{-- Credit --}}
                    @if(in_array(auth()->user()->role, ['customer', 'vip']))
                        <label class="payment-option {{ old('payment_type') === 'credit' ? 'active' : '' }}" data-payment-option>
                            <div class="payment-head">
                                <input type="radio" name="payment_type" value="credit" {{ old('payment_type') === 'credit' ? 'checked' : '' }}>
                                <span>💰 ชำระด้วยเครดิต</span>
                            </div>
                            @if($credit)
                                <div class="credit-note">
                                    วงเงินเครดิต {{ $credit->credit_limit !== null ? '฿' . number_format($credit->credit_limit, 2) : 'ไม่จำกัด' }}<br>
                                    ใช้ไปแล้ว ฿{{ number_format($credit->spent_amount, 2) }}<br>
                                    หากชำระด้วยเครดิต ยอดจะถูกรวมเข้าในรอบบิลของลูกค้าโดยอัตโนมัติ
                                </div>
                            @else
                                <div class="field-help">บัญชีนี้ยังไม่มีโควตาเครดิตในเดือนนี้</div>
                            @endif
                        </label>
                    @endif
                </div>

                <button type="submit" class="submit-button">ยืนยันการสั่งซื้อ</button>
            </div>

            {{-- Summary Sidebar --}}
            <aside class="card summary-card">
                <div class="summary-title">สรุปรายการ</div>

                @foreach($cart as $item)
                    <div class="summary-item">
                        <div class="summary-thumb">
                            @if(!empty($item['image']))
                                <img src="{{ route('media.show', ['path' => $item['image']]) }}" alt="{{ $item['name'] }}">
                            @endif
                        </div>
                        <div>
                            <div class="summary-name">{{ $item['name'] }}</div>
                            @if(!empty($item['variant_name']))
                                <div class="summary-sub">ตัวเลือก: {{ $item['variant_name'] }}</div>
                            @endif
                            <div class="summary-sub">{{ $item['quantity'] }} ชิ้น × ฿{{ number_format((float) $item['unit_price'], 2) }}</div>
                        </div>
                        <div class="summary-price">฿{{ number_format((float) $item['subtotal'], 2) }}</div>
                    </div>
                @endforeach

                <div style="padding-top:8px; display:grid; gap:4px;">
                    <div class="summary-line">
                        <span>ค่าสินค้า</span>
                        <span>฿{{ number_format($cartTotal, 2) }}</span>
                    </div>
                    <div class="summary-line muted" id="shippingLine">
                        <span>ค่าจัดส่ง</span>
                        <span id="shippingDisplay">฿{{ number_format($shippingCost, 2) }}</span>
                    </div>
                    <div class="summary-line muted" id="codFeeLine" style="display:none;">
                        <span>ค่าบริการ COD (3%)</span>
                        <span>฿{{ number_format($codFee, 2) }}</span>
                    </div>
                </div>

                <div class="summary-total">
                    <span>ยอดรวมสุทธิ</span>
                    <span id="grandTotalDisplay">฿{{ number_format($cartTotal + $shippingCost, 2) }}</span>
                </div>
            </aside>
        </form>
    </div>
    </div>

    <script>
        (() => {
            const options = Array.from(document.querySelectorAll('[data-payment-option]'));
            const radios = Array.from(document.querySelectorAll('input[name="payment_type"]'));
            const promptpaySlipBox = document.getElementById('promptpaySlipBox');
            const codFeeInfo = document.getElementById('codFeeInfo');
            const codFeeLine = document.getElementById('codFeeLine');
            const shippingLine = document.getElementById('shippingLine');
            const shippingDisplay = document.getElementById('shippingDisplay');
            const grandTotalDisplay = document.getElementById('grandTotalDisplay');

            const cartTotal = {{ $cartTotal }};
            const shippingCost = {{ $shippingCost }};
            const codFee = {{ $codFee }};

            const syncPaymentState = () => {
                const activeValue = radios.find((radio) => radio.checked)?.value || 'promptpay';

                options.forEach((option) => {
                    const radio = option.querySelector('input[name="payment_type"]');
                    option.classList.toggle('active', radio?.value === activeValue);
                });

                if (promptpaySlipBox) {
                    promptpaySlipBox.hidden = activeValue !== 'promptpay';
                }
                if (codFeeInfo) {
                    codFeeInfo.hidden = activeValue !== 'cod';
                }
                if (codFeeLine) {
                    codFeeLine.style.display = activeValue === 'cod' ? 'flex' : 'none';
                }

                // Update shipping display
                const isPickup = activeValue === 'pickup';
                if (shippingDisplay) {
                    shippingDisplay.textContent = isPickup ? 'ฟรี (รับหน้าร้าน)' : '฿' + shippingCost.toLocaleString('th-TH', {minimumFractionDigits: 2});
                }

                // Calculate grand total
                let grand = cartTotal;
                if (!isPickup) grand += shippingCost;
                if (activeValue === 'cod') grand += codFee;

                if (grandTotalDisplay) {
                    grandTotalDisplay.textContent = '฿' + grand.toLocaleString('th-TH', {minimumFractionDigits: 2});
                }
            };

            radios.forEach((radio) => {
                radio.addEventListener('change', syncPaymentState);
            });

            syncPaymentState();
        })();

        // Address Book selector
        function selectAddress(el) {
            document.querySelectorAll('.address-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');

            document.getElementById('recipient_name').value = el.dataset.name || '';
            document.getElementById('phone').value = el.dataset.phone || '';
            document.getElementById('address_line').value = el.dataset.address || '';
            document.getElementById('subdistrict').value = el.dataset.subdistrict || '';
            document.getElementById('district').value = el.dataset.district || '';
            document.getElementById('province').value = el.dataset.province || '';
            document.getElementById('postal_code').value = el.dataset.postal || '';
        }
    </script>
</body>
</html>
