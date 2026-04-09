<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ชำระเงิน | บ้านครีม สิงห์บุรี</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Prompt', sans-serif; background: #FAFAFA; color: #1A1A1A; margin:0; padding:40px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        h1, h2 { color:#CCA35E; margin-top:0; }
        .input-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 500; }
        .payment-box { border: 1px solid #ddd; padding: 20px; border-radius: 12px; margin-bottom: 15px; cursor: pointer; transition: 0.3s; }
        .payment-box:hover { border-color: #CCA35E; background: #CCA35E05; }
        input[type="radio"] { margin-right: 10px; }
        .btn-primary { background: #CCA35E; color: white; padding: 15px 25px; border:none; border-radius: 8px; text-decoration: none; cursor:pointer; font-weight:500; width:100%; font-size:1.1rem; margin-top:20px;}
    </style>
</head>
<body>
    <div class="container">
        <h1>ยืนยันคำสั่งซื้อ</h1>
        
        @if($errors->any())
            <div style="background:#fee2e2; color:#dc2626; padding:15px; border-radius:8px; margin-bottom:20px;">
                {{ $errors->first() }}
            </div>
        @endif

        @php 
            $total = 0; 
            foreach($cart as $item) {
                $total += ($item['quantity'] >= 5 ? $item['wholesale'] : $item['price']) * $item['quantity'];
            }
        @endphp

        <div style="background:#f9f9f9; padding:20px; border-radius:12px; margin-bottom:30px; border:1px dashed #ccc;">
            <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                <span>จำนวนสินค้าทั้งหมด</span>
                <strong>{{ array_sum(array_column($cart, 'quantity')) }} ชิ้น</strong>
            </div>
            <div style="display:flex; justify-content:space-between; font-size:1.3rem; font-weight:600; color:#CCA35E; border-top:1px solid #ddd; padding-top:10px; margin-top:10px;">
                <span>ยอดที่ต้องชำระ</span>
                <span>฿{{ number_format($total, 2) }}</span>
            </div>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h2>ช่องทางการชำระเงิน</h2>
            
            <label class="payment-box">
                <div style="display:flex; align-items:center;">
                    <input type="radio" name="payment_type" value="money_transfer" checked onchange="toggleSlip(true)">
                    <span style="font-weight:600;">โอนเงิน / แนบสลิปผ่านบัญชีธนาคาร</span>
                </div>
                <div id="slipUploadZone" style="margin-top:15px; margin-left:25px; padding:15px; background:#f4f4f4; border-radius:8px;">
                    <p style="margin-top:0; font-size:0.9rem; color:#666;">บัญชีธนาคารกสิกรไทย 123-4-56789-0 ชื่อ บ้านครีม สิงห์บุรี</p>
                    <input type="file" name="slip_image" accept="image/*" style="width:100%; background:white; padding:10px; border:1px solid #ddd; border-radius:6px;">
                </div>
            </label>

            @if(in_array(auth()->user()->role, ['customer', 'vip']))
                <label class="payment-box">
                    <div style="display:flex; align-items:center;">
                        <input type="radio" name="payment_type" value="credit" onchange="toggleSlip(false)">
                        <span style="font-weight:600;">ชำระด้วยโควตาเครดิตรายเดือน</span>
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
            if(show) {
                slipZone.style.display = 'block';
            } else {
                slipZone.style.display = 'none';
            }
        }
    </script>
</body>
</html>
