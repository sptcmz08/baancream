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
            <a href="#" class="btn-gold">เลือกดูสินค้า</a>
        </div>
    </section>
</body>
</html>
