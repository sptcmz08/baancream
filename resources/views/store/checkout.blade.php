<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ชำระเงิน | บ้านครีม สิงห์บุรี</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Prompt', sans-serif; background: #f6f8fc; color: #1A1A1A; margin:0; padding:40px 20px; }
        .container { max-width: 740px; margin: 0 auto; background: white; padding: 34px; border-radius: 28px; box-shadow: 0 18px 50px rgba(19, 33, 68, 0.08); }
        h1, h2 { color:#111827; margin-top:0; }
        .payment-box { border: 1px solid #e5e7eb; padding: 20px; border-radius: 18px; margin-bottom: 15px; cursor: pointer; transition: 0.3s; }
        .payment-box:hover { border-color: #22c55e; background: #22c55e05; }
        input[type="radio"] { margin-right: 10px; }
        .btn-primary { background: #22c55e; color: white; padding: 15px 25px; border:none; border-radius: 14px; cursor:pointer; font-weight:700; width:100%; font-size:1.1rem; margin-top:20px;}
        .summary-item { display:flex; justify-content:space-between; gap:16px; padding:12px 0; border-bottom:1px solid #eef2f7; }
    </style>
</head>
<body>
    <div class="container">
        <h1>ยืนยันคำสั่งซื้อ</h1>

        @if(session('error'))
            <div style="background:#fee2e2; color:#dc2626; padding:15px; border-radius:12px; margin-bottom:20px;">{{ session('error') }}</div>
        @endif

        <div style="background:#f8fafc; padding:22px; border-radius:18px; margin-bottom:30px; border:1px dashed #cbd5e1;">
            @foreach($cart as $item)
                <div class="summary-item">
                    <div>
                        <strong>{{ $item['name'] }}</strong>
                        @if($item['variant_name'])
                            <div style="font-size:0.9rem; color:#64748b;">สูตร: {{ $item['variant_name'] }}</div>
                        @endif
                        <div style="font-size:0.85rem; color:#94a3b8;">{{ $item['quantity'] }} ชิ้น × ฿{{ number_format($item['unit_price'], 2) }}</div>
                    </div>
                    <strong>฿{{ number_format($item['subtotal'], 2) }}</strong>
                </div>
            @endforeach

            <div style="display:flex; justify-content:space-between; font-size:1.35rem; font-weight:700; color:#22c55e; padding-top:16px; margin-top:8px;">
                <span>ยอดที่ต้องชำระ</span>
                <span>฿{{ number_format($cartTotal, 2) }}</span>
            </div>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h2>ช่องทางการชำระเงิน</h2>

            <label class="payment-box">
                <div style="display:flex; align-items:center;">
                    <input type="radio" name="payment_type" value="money_transfer" checked onchange="toggleSlip(true)">
                    <span style="font-weight:700;">โอนเงิน / แนบสลิปผ่านบัญชีธนาคาร</span>
                </div>
                <div id="slipUploadZone" style="margin-top:15px; margin-left:25px; padding:15px; background:#f8fafc; border-radius:12px;">
                    <p style="margin-top:0; font-size:0.9rem; color:#64748b;">บัญชีธนาคารกสิกรไทย 123-4-56789-0 ชื่อ บ้านครีม สิงห์บุรี</p>
                    <input type="file" name="slip_image" accept="image/*" style="width:100%; background:white; padding:10px; border:1px solid #ddd; border-radius:10px;">
                </div>
            </label>

            @if(in_array(auth()->user()->role, ['customer', 'vip']))
                <label class="payment-box">
                    <div style="display:flex; align-items:center;">
                        <input type="radio" name="payment_type" value="credit" onchange="toggleSlip(false)">
                        <span style="font-weight:700;">ชำระด้วยโควตาเครดิตรายเดือน</span>
                    </div>
                    @if($credit)
                        <div style="margin-left:25px; margin-top:10px; font-size:0.9rem; color:#16a34a;">
                            คุณมีสิทธิ์เครดิต: {{ $credit->credit_limit ? 'วงเงิน ฿'.number_format($credit->credit_limit,2) : 'ไม่จำกัด (VIP)' }}<br>
                            ใช้ไปแล้ว: ฿{{ number_format($credit->spent_amount, 2) }}
                        </div>
                    @else
                        <div style="margin-left:25px; margin-top:10px; font-size:0.9rem; color:#dc2626;">คุณยังไม่ได้รับโควตาเครดิตในเดือนนี้</div>
                    @endif
                </label>
            @endif

            <button type="submit" class="btn-primary">ยืนยันการสั่งซื้อ</button>
        </form>
    </div>

    <script>
        function toggleSlip(show) {
            const slipZone = document.getElementById('slipUploadZone');
            slipZone.style.display = show ? 'block' : 'none';
        }
    </script>
</body>
</html>
