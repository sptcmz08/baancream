<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ตะกร้าสินค้า | บ้านครีม สิงห์บุรี</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Prompt', sans-serif; background: #FAFAFA; color: #1A1A1A; margin:0; padding:40px; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        h1 { margin-top:0; color:#CCA35E; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { padding: 15px; border-bottom: 1px solid #eee; text-align: left; }
        .btn-primary { background: #CCA35E; color: white; padding: 12px 25px; border:none; border-radius: 8px; text-decoration: none; cursor:pointer; font-weight:500; display:inline-block;}
        .btn-danger { background: #fee2e2; color: #dc2626; padding: 8px 15px; border:none; border-radius: 6px; cursor:pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h1>ตะกร้าสินค้าของคุณ</h1>
        <a href="{{ route('home') }}" style="color:#666; text-decoration:none;">&larr; กลับไปเลือกสินค้าต่อ</a>

        @if(session('success'))
            <div style="background:#22c55e20; color:#16a34a; padding:15px; border-radius:8px; margin-top:20px;">{{ session('success') }}</div>
        @endif

        @if(count($cart) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>สินค้า</th>
                        <th>ราคา (ปกติ/ส่ง)</th>
                        <th>จำนวน</th>
                        <th>รวมเป็นเงิน</th>
                        <th>ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php 
                            $priceUsed = $item['quantity'] >= 5 ? $item['wholesale'] : $item['price'];
                            $subtotal = $priceUsed * $item['quantity'];
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:15px;">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/'.$item['image']) }}" style="width:60px; height:60px; object-fit:cover; border-radius:8px;">
                                    @endif
                                    <strong>{{ $item['name'] }}</strong>
                                    @if($item['quantity'] >= 5) <span style="font-size:0.75rem; background:#22c55e20; color:#16a34a; padding:2px 6px; border-radius:4px;">เรทส่งทำงาน</span> @endif
                                </div>
                            </td>
                            <td>฿{{ number_format($priceUsed, 2) }}</td>
                            <td>{{ $item['quantity'] }} ชิ้น</td>
                            <td style="font-weight:600; color:#CCA35E;">฿{{ number_format($subtotal, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button type="submit" class="btn-danger">ลบ</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div style="text-align:right; margin-top:30px;">
                <h2 style="font-size: 1.8rem; margin-bottom: 20px;">ยอดรวมทั้งสิ้น: <span style="color:#CCA35E;">฿{{ number_format($total, 2) }}</span></h2>
                <a href="{{ route('checkout.index') }}" class="btn-primary" style="font-size:1.1rem; padding:15px 40px;">ดำเนินการชำระเงิน</a>
            </div>
        @else
            <div style="text-align:center; padding:50px; color:#999;">ตะกร้าสินค้าว่างเปล่า</div>
        @endif
    </div>
</body>
</html>
