<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บ้านครีม สิงห์บุรี | Premium Skincare</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Prompt:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #CCA35E;
            --text-dark: #1A1A1A;
            --bg-color: #FAFAFA;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Prompt', sans-serif; background: var(--bg-color); color: var(--text-dark); }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }
        
        /* Navbar */
        .nav { 
            position: absolute; top: 0; width: 100%; padding: 30px 60px; 
            display: flex; justify-content: space-between; align-items: center;
            z-index: 10; color: white; 
        }
        .nav-brand { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 600; letter-spacing: 1px;}
        .nav-links a { color: white; text-decoration: none; margin-left: 30px; font-weight: 400; font-size: 1rem; transition: 0.3s; }
        .nav-links a:hover { color: var(--primary-color); }
        
        /* Hero Section */
        .hero {
            height: 100vh; 
            background: url('https://images.unsplash.com/photo-1615397323133-c4547900bba0?q=80&w=1920&auto=format') center/cover;
            display: flex; align-items: center; justify-content: center; text-align: center; color: white; position: relative;
        }
        .hero-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.25); }
        .hero-content { position: relative; z-index: 1; max-width: 800px;}
        .hero-subtitle { font-size: 1.1rem; letter-spacing: 3px; text-transform: uppercase; margin-bottom: 15px; color: var(--primary-color); font-weight: 500;}
        .hero h1 { font-size: 4.5rem; margin-bottom: 25px; line-height: 1.1; text-shadow: 1px 1px 10px rgba(0,0,0,0.2); }
        .hero p { font-size: 1.25rem; margin-bottom: 40px; font-weight: 300; opacity: 0.9;}
        
        .btn-gold {
            background: var(--primary-color); color: white; padding: 16px 40px; 
            text-decoration: none; border-radius: 50px; font-size: 1.1rem; 
            transition: 0.3s ease; display: inline-block; font-weight: 500;
            box-shadow: 0 4px 15px rgba(204, 163, 94, 0.4);
        }
        .btn-gold:hover { background: #b38a4d; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(204, 163, 94, 0.6); }

    </style>
</head>
<body>
    <nav class="nav">
        <div class="nav-brand">บ้านครีม สิงห์บุรี</div>
        <div class="nav-links">
            <a href="#">สินค้าทั้งหมด</a>
            <a href="#">ตรวจสอบสถานะ</a>
            @auth
                <a href="{{ route('admin.dashboard') }}">ระบบหลังบ้าน</a>
            @else
                <a href="{{ route('login') }}" style="border: 1px solid white; padding: 10px 24px; border-radius: 30px;">เข้าสู่ระบบ</a>
            @endauth
        </div>
    </nav>

    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-subtitle">Premium Skincare & Beauty</div>
            <h1>Reveal Your True Radiance</h1>
            <p>สัมผัสประสบการณ์แห่งความงามเหนือระดับ เพื่อผิวพรรณที่โดดเด่นและเปล่งประกายในแบบของคุณ พร้อมระบบเครดิตสั่งซื้อง่ายๆ ทันใจ</p>
            <a href="#catalog" class="btn-gold">เลือกดูสินค้า</a>
        </div>
    </section>

    <!-- Catalog Section -->
    <section id="catalog" style="padding: 80px 40px; max-width: 1200px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
            <h2 style="font-size: 2.5rem; color: var(--text-dark);">คอลเลกชั่นสกินแคร์ของเรา</h2>
            <div style="position: relative; width: 300px;">
                <input type="text" id="searchInput" placeholder="ค้นหาสินค้าแบบ Real-time..." style="width: 100%; padding: 12px 20px; border-radius: 30px; border: 1px solid #ddd; outline: none; font-family: 'Prompt';">
            </div>
        </div>

        <div id="productGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 30px;">
            @foreach($products as $product)
            <div class="product-card" style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.03); transition: 0.3s; padding-bottom: 20px;">
                <div style="height: 250px; background: #eee; display:flex; align-items:center; justify-content:center;">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <span style="color:#aaa;">No Image</span>
                    @endif
                </div>
                <div style="padding: 20px;">
                    <div style="font-size: 0.8rem; color: var(--primary-color); font-weight: 500; margin-bottom: 5px;">{{ $product->category->name ?? 'ทั่วไป' }}</div>
                    <h3 style="font-size: 1.2rem; margin-bottom: 10px; font-family: 'Prompt'; font-weight: 500;">{{ $product->name }}</h3>
                    <p style="font-size: 0.9rem; color: #666; margin-bottom: 15px;">{{ Str::limit($product->description, 50) }}</p>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-size: 1.1rem; font-weight: 600; color: var(--text-dark);">฿{{ number_format($product->retail_price, 2) }}</div>
                            <div style="font-size: 0.8rem; color: #16a34a;">ราคาส่ง ฿{{ number_format($product->wholesale_price, 2) }}</div>
                        </div>
                        <button class="btn-gold" style="padding: 8px 20px; font-size: 0.9rem;" onclick="alert('ระบบตะกร้ากำลังอยู่ระหว่างพัฒนา')">หยิบใส่ตะกร้า</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <script>
        // Real-time search implementation
        const searchInput = document.getElementById('searchInput');
        const productGrid = document.getElementById('productGrid');
        
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value;
            fetch(`/search?q=${query}`)
                .then(res => res.json())
                .then(data => {
                    productGrid.innerHTML = '';
                    if(data.length === 0) {
                        productGrid.innerHTML = '<p style="grid-column: 1/-1; text-align:center; color:#999; padding: 50px;">ไม่พบสินค้าที่ค้นหา</p>';
                        return;
                    }
                    data.forEach(item => {
                        productGrid.innerHTML += `
                            <div class="product-card" style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.03); transition: 0.3s; padding-bottom: 20px;">
                                <div style="height: 250px; background: #eee; display:flex; align-items:center; justify-content:center;">
                                    ${item.image ? `<img src="/storage/${item.image}" style="width:100%; height:100%; object-fit:cover;">` : '<span style="color:#aaa;">No Image</span>'}
                                </div>
                                <div style="padding: 20px;">
                                    <h3 style="font-size: 1.2rem; margin-bottom: 10px; font-family: 'Prompt'; font-weight: 500;">${item.name}</h3>
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                                        <div>
                                            <div style="font-size: 1.1rem; font-weight: 600; color: #1A1A1A;">฿${parseFloat(item.retail_price).toFixed(2)}</div>
                                            <div style="font-size: 0.8rem; color: #16a34a;">ราคาส่ง ฿${parseFloat(item.wholesale_price).toFixed(2)}</div>
                                        </div>
                                        <button class="btn-gold" style="padding: 8px 20px; font-size: 0.9rem;" onclick="alert('ระบบตะกร้ากำลังอยู่ระหว่างพัฒนา')">หยิบใส่ตะกร้า</button>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                });
        });
    </script>
</body>
</html>
