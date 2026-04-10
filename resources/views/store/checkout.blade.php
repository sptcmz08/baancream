<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ยืนยันการชำระเงิน | บ้านครีม สิงห์บุรี</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            padding: 40px 20px;
            font-family: 'Prompt', sans-serif;
            background: var(--page-color);
            color: var(--text-dark);
        }
        a { color: inherit; text-decoration: none; }
        img { display: block; max-width: 100%; }
        button, input, textarea { font: inherit; }

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
            padding: 22px;
            display: grid;
            gap: 18px;
            position: sticky;
            top: 24px;
        }
        .summary-title {
            font-size: 1.2rem;
            font-weight: 700;
        }
        .summary-item {
            display: grid;
            grid-template-columns: 58px 1fr auto;
            gap: 12px;
            align-items: start;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border-color);
        }
        .summary-thumb {
            width: 58px;
            height: 58px;
            border-radius: 16px;
            overflow: hidden;
            background: #f3f6fb;
        }
        .summary-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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

        @media (max-width: 980px) {
            .layout {
                grid-template-columns: 1fr;
            }
            .summary-card {
                position: static;
            }
        }

        @media (max-width: 640px) {
            body {
                padding: 24px 14px;
            }
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
                grid-template-columns: 52px 1fr;
            }
            .summary-price {
                grid-column: 2;
            }
        }
    </style>
</head>
<body>
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

        <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data" class="layout">
            @csrf

            <div class="card main-card">
                <div class="section-card">
                    <div class="section-title">
                        <span class="section-icon">1</span>
                        <span>ข้อมูลจัดส่งสินค้า</span>
                    </div>

                    <div class="field-grid">
                        <div class="field">
                            <label for="recipient_name">ชื่อ - นามสกุล</label>
                            <input id="recipient_name" class="input" type="text" name="recipient_name" value="{{ old('recipient_name', $customerName) }}" required>
                            @error('recipient_name')
                                <div class="field-help">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="phone">เบอร์โทรศัพท์</label>
                            <input id="phone" class="input" type="text" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="field-help">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field full">
                            <label for="address_line">รายละเอียดที่อยู่</label>
                            <textarea id="address_line" class="textarea" name="address_line" required>{{ old('address_line') }}</textarea>
                            @error('address_line')
                                <div class="field-help">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="subdistrict">ตำบล / แขวง</label>
                            <input id="subdistrict" class="input" type="text" name="subdistrict" value="{{ old('subdistrict') }}" required>
                            @error('subdistrict')
                                <div class="field-help">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="district">อำเภอ / เขต</label>
                            <input id="district" class="input" type="text" name="district" value="{{ old('district') }}" required>
                            @error('district')
                                <div class="field-help">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="province">จังหวัด</label>
                            <input id="province" class="input" type="text" name="province" value="{{ old('province') }}" required>
                            @error('province')
                                <div class="field-help">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="postal_code">รหัสไปรษณีย์</label>
                            <input id="postal_code" class="input" type="text" name="postal_code" value="{{ old('postal_code') }}" required>
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

                <div class="section-card">
                    <div class="section-title">
                        <span class="section-icon">2</span>
                        <span>วิธีชำระเงิน</span>
                    </div>

                    <label class="payment-option {{ old('payment_type', 'promptpay') === 'promptpay' ? 'active' : '' }}" data-payment-option>
                        <div class="payment-head">
                            <input type="radio" name="payment_type" value="promptpay" {{ old('payment_type', 'promptpay') === 'promptpay' ? 'checked' : '' }}>
                            <span>โอนเงิน / PromptPay</span>
                        </div>
                        <div class="payment-meta">
                            ชำระผ่าน PromptPay แล้วแนบสลิปเพื่อยืนยันการชำระเงิน ระบบจะบันทึกคำสั่งซื้อและส่งให้หลังบ้านตรวจสอบต่อทันที
                        </div>
                        <div class="slip-box" id="promptpaySlipBox" {{ old('payment_type', 'promptpay') === 'credit' ? 'hidden' : '' }}>
                            <div style="font-weight:700;">แนบสลิปการโอน</div>
                            <input type="file" class="input" name="slip_image" accept="image/*">
                            @error('slip_image')
                                <div class="field-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </label>

                    @if(in_array(auth()->user()->role, ['customer', 'vip']))
                        <label class="payment-option {{ old('payment_type') === 'credit' ? 'active' : '' }}" data-payment-option>
                            <div class="payment-head">
                                <input type="radio" name="payment_type" value="credit" {{ old('payment_type') === 'credit' ? 'checked' : '' }}>
                                <span>ชำระด้วยเครดิต</span>
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

                <div class="summary-total">
                    <span>ยอดรวมสุทธิ</span>
                    <span>฿{{ number_format($cartTotal, 2) }}</span>
                </div>
            </aside>
        </form>
    </div>

    <script>
        (() => {
            const options = Array.from(document.querySelectorAll('[data-payment-option]'));
            const radios = Array.from(document.querySelectorAll('input[name="payment_type"]'));
            const promptpaySlipBox = document.getElementById('promptpaySlipBox');

            const syncPaymentState = () => {
                const activeValue = radios.find((radio) => radio.checked)?.value || 'promptpay';

                options.forEach((option) => {
                    const radio = option.querySelector('input[name="payment_type"]');
                    option.classList.toggle('active', radio?.value === activeValue);
                });

                if (promptpaySlipBox) {
                    promptpaySlipBox.hidden = activeValue !== 'promptpay';
                }
            };

            radios.forEach((radio) => {
                radio.addEventListener('change', syncPaymentState);
            });

            syncPaymentState();
        })();
    </script>
</body>
</html>
