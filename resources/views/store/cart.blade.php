<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ตะกร้าสินค้า | บ้านครีม สิงห์บุรี</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ff4f87;
            --text-soft: #62708a;
            --text-dark: #1a2233;
            --border-color: #e7ebf3;
            --gold-color: #f8c64f;
        }
        body { font-family: 'Prompt', sans-serif; background: #f6f8fc; color: #1A1A1A; margin:0; padding:40px 20px; }
        .container { max-width: 1080px; margin: 0 auto; background: white; padding: 34px; border-radius: 28px; box-shadow: 0 18px 50px rgba(19, 33, 68, 0.08); }
        h1 { margin-top:0; color:#1f2937; font-size:2.2rem; }
        .table { width: 100%; border-collapse: collapse; margin-top: 24px; }
        .table th, .table td { padding: 18px 14px; border-bottom: 1px solid #eef2f7; text-align: left; vertical-align: middle; }
        .btn-primary { background: #22c55e; color: white; padding: 14px 28px; border:none; border-radius: 14px; text-decoration: none; cursor:pointer; font-weight:700; display:inline-block;}
        .btn-danger { background: #fee2e2; color: #dc2626; padding: 10px 16px; border:none; border-radius: 10px; cursor:pointer; font-weight:600; }
        .pill { display:inline-flex; padding:4px 10px; border-radius:999px; font-size:0.78rem; font-weight:700; }
        .pill.variant { background:#fff1f5; color:#e11d72; }
        .pill.wholesale { background:#e9f9ef; color:#15803d; }
    </style>
</head>
<body>
    <div class="container">
        <h1>ตะกร้าสินค้าของคุณ</h1>
        <div style="display:flex; justify-content:space-between; align-items:center; gap:20px; flex-wrap:wrap;">
            <a href="{{ route('home') }}" style="color:#64748b; text-decoration:none;">&larr; กลับไปเลือกสินค้าต่อ</a>
            <div style="color:#64748b;">รวม {{ $cartCount }} ชิ้น</div>
        </div>

        @if(session('success'))
            <div style="background:#22c55e20; color:#16a34a; padding:15px; border-radius:12px; margin-top:20px;">{{ session('success') }}</div>
        @endif

        @if(count($cart ?? []) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>สินค้า</th>
                        <th>ราคาต่อหน่วย</th>
                        <th>จำนวน</th>
                        <th>รวมเป็นเงิน</th>
                        <th>ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:15px;">
                                    @if(!empty($item['image']))
                                        <img src="{{ url('/media/' . $item['image']) }}" style="width:72px; height:72px; object-fit:contain; padding:6px; border-radius:14px; background:#f8fafc; mix-blend-mode:multiply;">
                                    @endif
                                    <div>
                                        <strong style="display:block; margin-bottom:6px;">{{ $item['name'] ?? 'สินค้า' }}</strong>
                                        @if(!empty($item['variant_name']))
                                            <span class="pill variant">{{ $item['variant_name'] }}</span>
                                        @endif
                                        @if(!empty($item['uses_wholesale']))
                                            <span class="pill wholesale">เรทส่ง {{ $item['wholesale_min_qty'] ?? 1 }} ชิ้น</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>฿{{ number_format((float) ($item['unit_price'] ?? 0), 2) }}</td>
                            <td>{{ $item['quantity'] ?? 0 }} ชิ้น</td>
                            <td style="font-weight:700; color:#0f172a;">฿{{ number_format((float) ($item['subtotal'] ?? 0), 2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item['id'] ?? '' }}">
                                    <button type="submit" class="btn-danger">ลบ</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="text-align:right; margin-top:30px;">
                <h2 style="font-size: 1.8rem; margin-bottom: 20px;">ยอดรวมทั้งสิ้น: <span style="color:#22c55e;">฿{{ number_format($cartTotal, 2) }}</span></h2>
                @auth
                    <a href="{{ route('checkout.index') }}" class="btn-primary" style="font-size:1.05rem;">ดำเนินการชำระเงิน</a>
                @else
                    <button type="button" class="btn-primary" data-open-auth data-auth-mode="login" data-auth-redirect="{{ route('cart.index', absolute: false) }}" style="font-size:1.05rem;">เข้าสู่ระบบเพื่อชำระเงิน</button>
                @endauth
            </div>
        @else
            <div style="text-align:center; padding:60px; color:#94a3b8;">ตะกร้าสินค้าว่างเปล่า</div>
        @endif
    </div>

    @guest
        @include('store.partials.auth-modal')
    @endguest
</body>
</html>
