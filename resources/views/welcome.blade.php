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
            --bg-color: #F8F5F1;
            --surface-color: rgba(255, 255, 255, 0.92);
            --border-color: rgba(26, 26, 26, 0.08);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Prompt', sans-serif; background: var(--bg-color); color: var(--text-dark); }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }

        /* Header */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 20;
            padding: 18px 40px;
            background: rgba(248, 245, 241, 0.94);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-color);
        }
        .nav {
            max-width: 1280px;
            margin: 0 auto;
            display: flex; justify-content: space-between; align-items: center;
            gap: 24px;
        }
        .nav-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }
        .nav-tab {
            color: var(--text-dark);
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 999px;
            border: 1px solid transparent;
            font-weight: 500;
            font-size: 0.98rem;
            transition: 0.25s ease;
        }
        .nav-tab:hover {
            border-color: rgba(204, 163, 94, 0.35);
            background: rgba(204, 163, 94, 0.08);
            color: var(--primary-color);
        }
        .btn-gold {
            background: var(--primary-color); color: white; padding: 16px 40px; 
            text-decoration: none; border-radius: 50px; font-size: 1.1rem; 
            transition: 0.3s ease; display: inline-block; font-weight: 500;
            box-shadow: 0 4px 15px rgba(204, 163, 94, 0.4);
        }
        .btn-gold:hover { background: #b38a4d; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(204, 163, 94, 0.6); }
        .main-content {
            padding: 24px 40px 80px;
        }
        .hero-banner {
            max-width: 1280px;
            margin: 0 auto 56px;
        }
        .hero-banner-frame {
            overflow: hidden;
            border-radius: 32px;
            background: #EDE7DD;
            box-shadow: 0 18px 60px rgba(63, 40, 16, 0.12);
            aspect-ratio: 16 / 7;
        }
        .hero-banner-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .catalog-section {
            padding: 0 0 80px;
            max-width: 1200px;
            margin: 0 auto;
        }

        @media (max-width: 900px) {
            .site-header { padding: 16px 20px; }
            .main-content { padding: 20px 20px 64px; }
            .nav { flex-direction: column; align-items: stretch; }
            .nav-links { justify-content: flex-start; }
            .nav-brand { font-size: 1.5rem; }
            .hero-banner { margin-bottom: 40px; }
            .hero-banner-frame { border-radius: 24px; aspect-ratio: 4 / 3; }
        }

    </style>
</head>
<body>
    <header class="site-header">
        <nav class="nav">
            <div class="nav-brand">บ้านครีม สิงห์บุรี</div>
            <div class="nav-links">
                <a href="#catalog" class="nav-tab">สินค้าทั้งหมด</a>
                <a href="#" class="nav-tab">ตรวจสอบสถานะ</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="nav-tab">ระบบหลังบ้าน</a>
                @else
                    <a href="{{ route('login') }}" class="btn-gold" style="padding: 10px 24px; font-size: 1rem;">เข้าสู่ระบบ</a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="main-content">
        <section class="hero-banner" aria-label="แบนเนอร์หลัก">
            <div class="hero-banner-frame">
                <img src="https://images.unsplash.com/photo-1615397349754-cfa2066a298e?q=80&w=1920&auto=format" alt="แบนเนอร์บ้านครีม สิงห์บุรี">
            </div>
        </section>

    <!-- Catalog Section -->
    <section id="catalog" class="catalog-section">
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
    </main>

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
