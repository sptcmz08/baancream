<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บ้านครีม สิงห์บุรี | Beauty Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ff4f87;
            --primary-dark: #e93574;
            --accent-color: #1fbad6;
            --gold-color: #f8c64f;
            --text-dark: #1a2233;
            --text-soft: #62708a;
            --border-color: #e7ebf3;
            --surface-color: #ffffff;
            --page-color: #f6f8fc;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Prompt', sans-serif; background: var(--page-color); color: var(--text-dark); overflow-x: hidden; }
        a { color: inherit; text-decoration: none; }
        img { display: block; max-width: 100%; }

        .top-strip {
            background: linear-gradient(90deg, #8b5cf6 0%, #ff2d76 35%, #ff5f6d 68%, #35c98b 100%);
            color: white;
            padding: 10px 24px;
            font-size: 0.95rem;
        }
        .top-strip-inner {
            max-width: 1440px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .top-strip-badges {
            display: flex;
            gap: 22px;
            flex-wrap: wrap;
        }

        .header-shell {
            position: sticky;
            top: 0;
            z-index: 20;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(16px);
            box-shadow: 0 12px 30px rgba(40, 58, 100, 0.06);
        }
        .header-main {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .header-main {
            min-height: 96px;
            display: grid;
            grid-template-columns: auto minmax(520px, 720px) auto;
            align-items: center;
            gap: 24px;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 34px;
            min-width: 0;
            justify-self: start;
        }
        .brand-logo {
            display: inline-flex;
            align-items: center;
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: -0.04em;
        }
        .brand-logo-image {
            height: 78px;
            width: auto;
            object-fit: contain;
        }
        .brand-logo span:nth-child(2) { color: #6a67ff; }
        .brand-logo span:nth-child(3) { color: #22c1dc; }
        .brand-logo span:nth-child(4) { color: #f8c64f; }
        .brand-logo span:nth-child(5) { color: #35c98b; }
        .header-search {
            width: 100%;
            justify-self: center;
        }
        .header-tools {
            display: flex;
            align-items: center;
            gap: 14px;
            justify-self: end;
        }
        .search-shell {
            position: relative;
            width: 100%;
        }
        .search-box {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f7f8fb;
            border: 1px solid var(--border-color);
            border-radius: 999px;
            padding: 12px 18px;
        }
        .search-box input {
            width: 100%;
            border: none;
            background: transparent;
            outline: none;
            font-family: inherit;
            font-size: 0.96rem;
        }
        .search-results {
            position: absolute;
            top: calc(100% + 10px);
            left: 0;
            right: 0;
            display: none;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 24px;
            box-shadow: 0 18px 50px rgba(29, 41, 76, 0.14);
            overflow: hidden;
            z-index: 40;
        }
        .search-results.is-open {
            display: block;
        }
        .search-result-item {
            display: grid;
            grid-template-columns: 56px 1fr;
            gap: 12px;
            align-items: center;
            padding: 12px 14px;
            border-bottom: 1px solid var(--border-color);
        }
        .search-result-item:last-child {
            border-bottom: none;
        }
        .search-result-item:hover {
            background: #fff7fb;
        }
        .search-result-thumb {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            overflow: hidden;
            background: linear-gradient(135deg, #f8f0f3 0%, #eef7ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .search-result-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .search-result-name {
            font-size: 0.96rem;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 3px;
        }
        .search-result-price {
            color: var(--text-soft);
            font-size: 0.9rem;
        }
        .search-result-empty {
            padding: 16px 18px;
            color: var(--text-soft);
            font-size: 0.92rem;
        }
        .user-action,
        .pill-link {
            border: 1px solid var(--border-color);
            border-radius: 999px;
            padding: 10px 18px;
            font-weight: 500;
            background: white;
        }
        .user-action:hover,
        .pill-link:hover {
            border-color: rgba(255, 79, 135, 0.35);
            color: var(--primary-color);
        }
        .cart-icon-link {
            width: 46px;
            height: 46px;
            border: 1px solid var(--border-color);
            border-radius: 999px;
            background: white;
            color: var(--text-dark);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.2s ease;
        }
        .cart-icon-link:hover {
            border-color: rgba(255, 79, 135, 0.35);
            color: var(--primary-color);
            transform: translateY(-1px);
        }
        .cart-icon-link svg {
            width: 21px;
            height: 21px;
        }
        .hero {
            width: 100%;
            min-height: clamp(380px, 54vw, 760px);
            position: relative;
            overflow: hidden;
            background: #f1f4f9;
        }
        .hero.is-fallback {
            background:
                linear-gradient(180deg, rgba(11, 24, 58, 0.08), rgba(11, 24, 58, 0.08)),
                url('https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?q=80&w=2200&auto=format&fit=crop') center/cover;
        }
        .hero::after {
            content: '';
            position: absolute;
            inset: auto 0 0 0;
            height: 160px;
            background: linear-gradient(180deg, rgba(246, 248, 252, 0) 0%, rgba(246, 248, 252, 1) 100%);
            pointer-events: none;
            z-index: 3;
        }
        .hero-banner-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 0.75s ease;
        }
        .hero-banner-slide.is-active {
            opacity: 1;
            z-index: 1;
        }
        .hero-banner-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .page-section {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 24px 56px;
        }
        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 20px;
            margin-bottom: 24px;
        }
        .section-title {
            font-size: 2rem;
            line-height: 1.15;
        }
        .section-subtitle {
            color: var(--text-soft);
            margin-top: 8px;
        }
        .section-scroll {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 4px;
        }
        .section-pill {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 999px;
            padding: 10px 18px;
            color: var(--text-soft);
            cursor: pointer;
        }
        .section-pill:hover {
            color: var(--primary-color);
            border-color: rgba(255, 79, 135, 0.3);
        }
        .section-pill.active {
            color: var(--text-dark);
            background: #fff4f8;
            border-color: rgba(255, 79, 135, 0.3);
            box-shadow: 0 10px 24px rgba(233, 53, 116, 0.08);
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 26px;
        }
        .carousel-section {
            padding-top: 24px;
        }
        .auto-carousel {
            overflow: hidden;
            width: 100%;
        }
        .marquee-track {
            display: flex;
            width: max-content;
            animation: marquee var(--marquee-duration, 35s) linear infinite;
            padding: 10px 0 20px;
        }
        .marquee-track:hover {
            animation-play-state: paused;
        }
        .marquee-content {
            display: flex;
            gap: 24px;
            padding-right: 24px;
        }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .marquee-item {
            width: 260px;
            flex-shrink: 0;
            display: flex;
            align-items: stretch;
        }
        .marquee-item .product-card {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .marquee-item .product-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .product-card {
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 18px 50px rgba(29, 41, 76, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 58px rgba(29, 41, 76, 0.12);
        }
        .product-card-link {
            display: flex;
            min-height: 100%;
            flex-direction: column;
        }
        .product-image {
            aspect-ratio: 1 / 1;
            background: linear-gradient(135deg, #fff6fb 0%, #eef7ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 22px;
        }
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            mix-blend-mode: multiply;
        }
        .product-image span {
            color: #9aa7bd;
            font-size: 0.95rem;
        }
        .product-body {
            display: flex;
            flex: 1;
            flex-direction: column;
            gap: 12px;
            padding: 20px 20px 64px;
            background: white;
        }
        .product-category-badge {
            align-self: flex-start;
            border-radius: 8px;
            background: #effaf5;
            color: #14805a;
            padding: 5px 9px;
            font-size: 0.78rem;
            font-weight: 700;
            line-height: 1.2;
        }
        .product-name {
            font-size: 1.12rem;
            font-weight: 700;
            line-height: 1.45;
            min-height: 3.2em;
        }
        .product-price {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding-top: 8px;
            border-top: 1px solid #edf1f7;
        }
        .price-row {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 10px;
            color: var(--text-soft);
            font-size: 0.9rem;
        }
        .price-row strong {
            color: var(--text-dark);
            font-size: 1.18rem;
            font-weight: 700;
            white-space: nowrap;
        }
        .price-row-wholesale strong,
        .price-row-wholesale span {
            color: #06a45f;
        }
        .product-stock {
            color: var(--text-soft);
            font-size: 0.82rem;
        }
        .product-stock strong {
            color: #06a45f;
        }
        .product-add-form {
            position: absolute;
            right: 14px;
            bottom: 14px;
            z-index: 2;
        }
        .product-add-button {
            width: 48px;
            height: 48px;
            border: none;
            border-radius: 999px;
            background: #050505;
            color: white;
            box-shadow: 0 12px 26px rgba(5, 5, 5, 0.25);
            cursor: pointer;
            font-family: inherit;
            font-size: 2rem;
            font-weight: 300;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.18s ease, background 0.18s ease;
        }
        .product-add-button:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
        }

        .catalog-toolbar {
            display: grid;
            gap: 0;
            margin-bottom: 0;
        }
        .catalog-empty {
            background: white;
            border: 1px dashed #c9d2e3;
            border-radius: 24px;
            padding: 44px 24px;
            text-align: center;
            color: var(--text-soft);
        }
        .notice {
            max-width: 1440px;
            margin: 24px auto 0;
            padding: 0 24px;
        }
        .notice-box {
            background: #e9fff5;
            color: #117a4d;
            border: 1px solid #b8f0d6;
            padding: 14px 18px;
            border-radius: 18px;
        }

        .empty-state {
            background: white;
            border: 1px dashed #c9d2e3;
            border-radius: 24px;
            padding: 32px;
            text-align: center;
            color: var(--text-soft);
        }
        .category-products-section.is-empty {
            display: none;
        }

        @media (max-width: 1080px) {
            .header-main {
                grid-template-columns: 1fr;
                padding-top: 16px;
                padding-bottom: 16px;
            }
            .header-left {
                width: 100%;
                gap: 24px;
            }
            .header-search { width: 100%; }
            .header-tools {
                flex-wrap: wrap;
                justify-content: flex-start;
                justify-self: start;
            }
            .search-shell { width: 100%; }
            .search-box { width: 100%; }
            .hero { min-height: 56vh; }
            .product-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
            .marquee-item {
                width: 230px;
            }
        }

        @media (max-width: 720px) {
            .top-strip {
                display: none;
            }
            .header-main,
            .page-section,
            .notice { padding-left: 16px; padding-right: 16px; }
            .header-main {
                min-height: auto;
                display: grid;
                grid-template-columns: auto 1fr;
                gap: 10px 12px;
                padding-top: 10px;
                padding-bottom: 12px;
            }
            .header-left {
                width: auto;
                gap: 0;
            }
            .header-search {
                grid-column: 1 / -1;
                grid-row: 2;
            }
            .header-tools {
                grid-column: 2;
                justify-self: end;
                justify-content: flex-end;
                gap: 8px;
                flex-wrap: nowrap;
            }
            .brand-logo { font-size: 2.25rem; }
            .brand-logo-image { height: 54px; }
            .search-box {
                padding: 10px 14px;
            }
            .search-box input {
                font-size: 0.9rem;
            }
            .search-results {
                border-radius: 18px;
            }
            .cart-icon-link,
            .notif-btn {
                width: 40px;
                height: 40px;
            }
            .user-action {
                padding: 7px 10px;
            }
            .user-menu-name,
            .user-menu-caret {
                display: none;
            }
            .user-avatar {
                width: 28px;
                height: 28px;
            }
            .notif-dropdown,
            .user-dropdown {
                right: 0;
                max-width: calc(100vw - 32px);
            }
            .hero {
                min-height: 240px;
            }
            .hero::after {
                height: 90px;
            }
            .hero-banner-slide img {
                object-position: center;
            }
            #catalog {
                padding-top: 18px !important;
            }
            .section-scroll {
                gap: 8px;
                padding-bottom: 8px;
            }
            .section-pill {
                padding: 8px 13px;
                font-size: 0.9rem;
            }
            .carousel-section {
                padding-top: 18px;
                padding-bottom: 36px;
            }
            .section-head {
                margin-bottom: 14px;
            }
            .section-title { font-size: 1.55rem; }
            .marquee-track {
                padding: 6px 0 14px;
            }
            .marquee-content {
                gap: 14px;
                padding-right: 14px;
            }
            .marquee-item {
                width: 176px;
            }
            .product-card {
                border-radius: 18px;
                box-shadow: 0 12px 28px rgba(29, 41, 76, 0.08);
            }
            .product-image {
                padding: 12px;
            }
            .product-body {
                padding: 14px 14px 58px;
            }
            .product-category-badge {
                font-size: 0.68rem;
                padding: 4px 7px;
            }
            .product-name {
                font-size: 0.95rem;
                line-height: 1.35;
                min-height: 2.7em;
            }
            .price-row {
                font-size: 0.76rem;
                gap: 6px;
            }
            .price-row strong {
                font-size: 0.96rem;
            }
            .product-stock {
                font-size: 0.72rem;
            }
            .product-add-form {
                right: 10px;
                bottom: 10px;
            }
            .product-add-button {
                width: 40px;
                height: 40px;
                font-size: 1.65rem;
            }
            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
            }
            #floatingCartButton {
                right: 14px !important;
                bottom: 14px !important;
                width: 58px !important;
                height: 58px !important;
            }
            #floatingCartButton > span:first-child {
                font-size: 1.55rem !important;
            }
            #floatingCartModal {
                padding: 10px !important;
                align-items: flex-end !important;
                justify-content: center !important;
            }
            #floatingCartModal > div {
                width: 100% !important;
                max-height: 88vh !important;
                border-radius: 22px 22px 0 0 !important;
            }
            .header-left {
                gap: 14px;
            }
            .header-tools {
                gap: 8px;
            }
            .user-action,
            .pill-link {
                padding: 9px 12px;
                font-size: 0.86rem;
            }
            .hero {
                min-height: 42vh;
            }
            .marquee-content {
                gap: 14px;
                padding-right: 14px;
            }
            .marquee-item {
                width: 190px;
            }
            .product-card {
                border-radius: 20px;
            }
            .product-body {
                padding: 14px 14px 58px;
            }
            .product-name {
                font-size: 0.95rem;
                min-height: 0;
            }
        }

        @media (max-width: 520px) {
            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .marquee-item {
                width: 162px;
            }
            .hero {
                min-height: 210px;
            }
            .brand-logo-image {
                height: 48px;
            }
            .section-title {
                font-size: 1.42rem;
            }
            .product-body {
                padding: 12px 12px 56px;
            }
            .product-name {
                font-size: 0.9rem;
            }
            .price-row strong {
                font-size: 0.9rem;
            }
            .product-add-button {
                width: 38px;
                height: 38px;
                font-size: 1.55rem;
            }
            .top-strip-badges {
                gap: 8px;
            }
            .header-main {
                gap: 12px;
            }
            .hero {
                min-height: 34vh;
            }
            .marquee-item {
                width: 170px;
            }
            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
            }
        }

        /* ── Notification Bell ── */
        .notif-wrap { position: relative; }
        .notif-btn {
            width: 42px; height: 42px; border-radius: 999px;
            background: white; border: 1px solid var(--border-color);
            font-size: 1.1rem; cursor: pointer; position: relative;
            display: inline-flex; align-items: center; justify-content: center;
        }
        .notif-btn:hover { border-color: rgba(255,79,135,0.35); }
        .notif-badge {
            position: absolute; top: -4px; right: -4px;
            background: var(--primary-color); color: white;
            border-radius: 999px; font-size: 0.65rem; font-weight: 700;
            min-width: 18px; height: 18px; display: flex;
            align-items: center; justify-content: center; padding: 0 4px;
            border: 2px solid white;
        }
        .notif-dropdown {
            display: none; position: absolute; top: calc(100% + 10px); right: 0;
            width: 300px; background: white; border: 1px solid var(--border-color);
            border-radius: 20px; box-shadow: 0 16px 48px rgba(15,23,42,0.14);
            overflow: hidden; z-index: 50;
        }
        .notif-dropdown.is-open { display: block; }
        .notif-header { padding: 14px 16px; border-bottom: 1px solid var(--border-color); font-weight: 700; font-size: 0.95rem; }
        .notif-item {
            display: flex; gap: 12px; padding: 12px 16px; align-items: flex-start;
            border-bottom: 1px solid var(--border-color);
        }
        .notif-item:last-child { border-bottom: none; }
        .notif-item:hover { background: #f7f8fb; }
        .notif-dot { width: 10px; height: 10px; border-radius: 999px; flex-shrink:0; margin-top:5px; }
        .notif-item-title { font-size: 0.88rem; font-weight: 600; margin-bottom: 2px; }
        .notif-item-sub { font-size: 0.78rem; color: var(--text-soft); }
        .notif-empty { padding: 24px; text-align: center; color: var(--text-soft); font-size: 0.9rem; }

        /* ── User Dropdown ── */
        .user-menu { position: relative; }
        .user-menu-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: inherit;
            cursor: pointer;
        }
        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--primary-color), #6a67ff);
            color: white;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .user-menu-name { font-weight: 600; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .user-menu-caret { font-size: 0.7rem; color: var(--text-soft); transition: transform 0.2s; }
        .user-menu-btn[aria-expanded="true"] .user-menu-caret { transform: rotate(180deg); }
        .user-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 220px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 16px 48px rgba(15,23,42,0.14);
            overflow: hidden;
            z-index: 50;
        }
        .user-dropdown.is-open { display: block; }
        .user-dropdown-header {
            padding: 14px 16px 10px;
            border-bottom: 1px solid var(--border-color);
        }
        .user-dropdown-label { font-size: 0.78rem; color: var(--text-soft); }
        .user-dropdown-name { font-weight: 700; font-size: 1rem; margin-top: 2px; }
        .user-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 12px 16px;
            color: var(--text-dark);
            font-size: 0.95rem;
            font-weight: 500;
            background: transparent;
            border: none;
            font-family: inherit;
            cursor: pointer;
            text-align: left;
        }
        .user-dropdown-item:hover { background: #f7f8fb; color: var(--primary-color); }
        .user-dropdown-logout { color: #dc2626 !important; }
        .user-dropdown-logout:hover { background: #fff1f2 !important; color: #dc2626 !important; }
    </style>
</head>
<body>
    @php
        $mediaUrl = fn (?string $path) => $path ? '/media/' . ltrim($path, '/') : null;
        $newArrivalIds = $newArrivals->pluck('id')->all();
        $featuredIds = $featuredProducts->pluck('id')->all();
    @endphp

    @include('store.partials.layout-header')

    <section class="hero {{ $banners->isEmpty() ? 'is-fallback' : '' }}" aria-label="แบนเนอร์หลัก">
        @foreach($banners as $index => $banner)
            @php
                $bannerImage = $banner->displayImage();
                $bannerImageUrl = $mediaUrl($bannerImage);
                $bannerTag = $banner->link ? 'a' : 'div';
            @endphp
            @if($bannerImageUrl)
                <{{ $bannerTag }}
                    class="hero-banner-slide {{ $index === 0 ? 'is-active' : '' }}"
                    data-banner-slide
                    @if($banner->link) href="{{ $banner->link }}" @endif>
                    <img src="{{ $bannerImageUrl }}" alt="{{ $banner->title ?: 'แบนเนอร์ร้านค้า' }}">
                </{{ $bannerTag }}>
            @endif
        @endforeach
    </section>

    <section class="page-section" id="catalog" style="padding-top: 26px; padding-bottom: 0;">
        <div class="catalog-toolbar">
            <div class="section-scroll" id="catalogFilters">
                <button type="button" class="section-pill" data-filter="all">ทั้งหมด ({{ $catalogProducts->count() }})</button>
                @foreach($categories as $category)
                    <button type="button" class="section-pill" data-filter="category:{{ $category->slug }}">{{ $category->name }} ({{ $category->products_count }})</button>
                @endforeach
            </div>
        </div>
    </section>

    @if($newArrivals->isNotEmpty())
        <section class="page-section carousel-section" id="new-arrivals" aria-label="สินค้าใหม่">
            <div class="section-head">
                <div>
                    <h2 class="section-title">สินค้าใหม่</h2>
                </div>
            </div>
            <div class="auto-carousel" dir="ltr">
                <div class="marquee-track" style="--marquee-duration: {{ max(24, $newArrivals->count() * 5) }}s;">
                    <div class="marquee-content">
                        @foreach($newArrivals as $product)
                            <div class="marquee-item">
                                @include('store.partials.product-card', ['product' => $product, 'mediaUrl' => $mediaUrl])
                            </div>
                        @endforeach
                    </div>
                    <div class="marquee-content" aria-hidden="true">
                        @foreach($newArrivals as $product)
                            <div class="marquee-item">
                                @include('store.partials.product-card', ['product' => $product, 'mediaUrl' => $mediaUrl])
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($featuredProducts->isNotEmpty())
        <section class="page-section carousel-section" id="featured-products" aria-label="สินค้าแนะนำ">
            <div class="section-head">
                <div>
                    <h2 class="section-title">สินค้าแนะนำ</h2>
                </div>
            </div>
            <div class="auto-carousel" dir="ltr">
                <div class="marquee-track" style="--marquee-duration: {{ max(24, $featuredProducts->count() * 5) }}s;">
                    <div class="marquee-content">
                        @foreach($featuredProducts as $product)
                            <div class="marquee-item">
                                @include('store.partials.product-card', ['product' => $product, 'mediaUrl' => $mediaUrl])
                            </div>
                        @endforeach
                    </div>
                    <div class="marquee-content" aria-hidden="true">
                        @foreach($featuredProducts as $product)
                            <div class="marquee-item">
                                @include('store.partials.product-card', ['product' => $product, 'mediaUrl' => $mediaUrl])
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="page-section category-products-section is-empty" id="categoryProductsSection" style="padding-top: 10px;">
        @if($catalogProducts->isEmpty())
            <div class="catalog-empty">ยังไม่มีสินค้าในระบบ</div>
        @else
            <div class="product-grid" id="catalogGrid">
                @foreach($catalogProducts as $product)
                    @php
                        $filterTags = ['all'];
                        if (in_array($product->id, $newArrivalIds, true)) {
                            $filterTags[] = 'new';
                        }
                        if (in_array($product->id, $featuredIds, true)) {
                            $filterTags[] = 'featured';
                        }
                        foreach($product->categories as $pc) {
                            $filterTags[] = 'category:' . $pc->slug;
                        }
                    @endphp
                    @include('store.partials.product-card', [
                        'product' => $product,
                        'mediaUrl' => $mediaUrl,
                        'cardAttributes' => [
                            'data-card' => '',
                            'data-filter-tags' => implode('|', $filterTags),
                            'data-search' => strtolower($product->name),
                        ],
                    ])
                @endforeach
            </div>
        @endif
    </section>

    @include('store.partials.floating-cart', [
        'cartCount' => $cartCount,
        'cartItems' => $cartSummary['items'],
        'cartTotal' => $cartSummary['total'],
    ])
    @guest
        @include('store.partials.auth-modal')
    @endguest

    <script>
        const searchInput = document.getElementById('searchInput');
        const searchShell = document.getElementById('searchShell');
        const searchResults = document.getElementById('searchResults');
        const productCards = Array.from(document.querySelectorAll('[data-card]'));
        const filterButtons = Array.from(document.querySelectorAll('#catalogFilters [data-filter]'));
        const categoryProductsSection = document.getElementById('categoryProductsSection');
        const searchProducts = @json($searchProducts);
        let activeFilter = null;

        function closeSearchResults() {
            searchResults?.classList.remove('is-open');
        }

        function renderSearchResults(query) {
            if (!searchResults) {
                return;
            }

            const normalizedQuery = query.trim().toLowerCase();
            if (!normalizedQuery) {
                searchResults.innerHTML = '';
                closeSearchResults();
                return;
            }

            const matched = searchProducts
                .filter((product) => (product.search || '').includes(normalizedQuery))
                .slice(0, 6);

            if (!matched.length) {
                searchResults.innerHTML = '<div class="search-result-empty">ไม่พบสินค้าที่ค้นหา</div>';
                searchResults.classList.add('is-open');
                return;
            }

            searchResults.innerHTML = matched.map((product) => `
                <a href="${product.url}" class="search-result-item">
                    <div class="search-result-thumb">
                        ${product.image ? `<img src="${product.image}" alt="${product.name}">` : '<span>No Image</span>'}
                    </div>
                    <div>
                        <div class="search-result-name">${product.name}</div>
                        <div class="search-result-price">฿${product.price}</div>
                    </div>
                </a>
            `).join('');
            searchResults.classList.add('is-open');
        }

        function applyCatalogFilters() {
            const query = searchInput?.value.trim().toLowerCase() || '';
            const hasActiveFilter = Boolean(activeFilter);

            productCards.forEach((card) => {
                const haystack = card.dataset.search || '';
                const tags = (card.dataset.filterTags || '').split('|');
                const matchesFilter = activeFilter === 'all' || (hasActiveFilter && tags.includes(activeFilter));
                const matchesSearch = !query || haystack.includes(query);
                const visible = matchesFilter && matchesSearch;

                card.style.display = visible ? '' : 'none';
            });

            if (categoryProductsSection) {
                categoryProductsSection.classList.toggle('is-empty', !hasActiveFilter);
            }
        }

        filterButtons.forEach((button) => {
            button.addEventListener('click', () => {
                activeFilter = button.dataset.filter || null;
                filterButtons.forEach((item) => item.classList.toggle('active', item === button));
                applyCatalogFilters();
            });
        });

        searchInput?.addEventListener('input', (event) => {
            renderSearchResults(event.target.value);
            applyCatalogFilters();
        });

        searchInput?.addEventListener('focus', (event) => {
            renderSearchResults(event.target.value);
        });

        applyCatalogFilters();

        const bannerSlides = Array.from(document.querySelectorAll('[data-banner-slide]'));
        if (bannerSlides.length > 1) {
            let bannerIndex = 0;
            setInterval(() => {
                bannerSlides[bannerIndex]?.classList.remove('is-active');
                bannerIndex = (bannerIndex + 1) % bannerSlides.length;
                bannerSlides[bannerIndex]?.classList.add('is-active');
            }, 4500);
        }



        // ── User Dropdown ──
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');
        if (userMenuBtn && userDropdown) {
            userMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = userDropdown.classList.toggle('is-open');
                userMenuBtn.setAttribute('aria-expanded', String(isOpen));
                notifDropdown?.classList.remove('is-open');
            });
        }

        // ── Notification Bell ──
        const notifBtn = document.getElementById('notifBtn');
        const notifDropdown = document.getElementById('notifDropdown');
        const notifBadge = document.getElementById('notifBadge');
        const notifList = document.getElementById('notifList');
        let notifLoaded = false;

        async function loadNotifications() {
            try {
                const res = await fetch('{{ route('account.notifications') }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();

                if (notifBadge) {
                    notifBadge.textContent = data.unread;
                    notifBadge.style.display = data.unread > 0 ? 'flex' : 'none';
                }

                if (notifList) {
                    if (!data.items.length) {
                        notifList.innerHTML = '<div class="notif-empty">🔕 ยังไม่มีการแจ้งเตือน</div>';
                    } else {
                        notifList.innerHTML = data.items.map(item => `
                            <a href="${item.url}" class="notif-item" style="text-decoration:none;color:inherit;">
                                <div class="notif-dot" style="background:${item.color};"></div>
                                <div>
                                    <div class="notif-item-title">คำสั่งซื้อ #${String(item.id).padStart(5,'0')}</div>
                                    <div class="notif-item-sub">${item.label} · ฿${item.total} · ${item.created_at}</div>
                                </div>
                            </a>
                        `).join('');
                    }
                }
            } catch(e) {
                if (notifList) notifList.innerHTML = '<div class="notif-empty">ไม่สามารถโหลดได้</div>';
            }
        }

        if (notifBtn && notifDropdown) {
            notifBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = notifDropdown.classList.toggle('is-open');
                userDropdown?.classList.remove('is-open');
                userMenuBtn?.setAttribute('aria-expanded', 'false');
                if (isOpen && !notifLoaded) { notifLoaded = true; loadNotifications(); }
            });
            // Auto-load badge count
            loadNotifications();
        }

        document.addEventListener('click', (event) => {
            if (!searchShell?.contains(event.target)) {
                closeSearchResults();
            }
            userDropdown?.classList.remove('is-open');
            userMenuBtn?.setAttribute('aria-expanded', 'false');
            notifDropdown?.classList.remove('is-open');
        });

        // UI Helpers
        const updateCartUI = (data) => {
            const sidebarItems = document.getElementById('sidebarCartItems');
            const sidebarTotal = document.getElementById('sidebarCartTotal');
            const sidebarCount = document.getElementById('sidebarCartCount');
            const floatingBtn = document.getElementById('floatingCartButton');
            let floatingBadge = floatingBtn?.querySelector('span:nth-child(2)');

            if (sidebarItems) sidebarItems.innerHTML = data.html;
            if (sidebarTotal) sidebarTotal.textContent = data.total;
            if (sidebarCount) sidebarCount.textContent = `รวม ${data.count} ชิ้น`;

            if (floatingBadge && floatingBadge !== floatingBtn.querySelector('span:first-child')) {
                floatingBadge.textContent = data.count;
                floatingBadge.style.display = data.count > 0 ? 'flex' : 'none';
            } else if (floatingBtn && data.count > 0) {
                floatingBtn.insertAdjacentHTML('beforeend', `<span style="position:absolute; top:4px; right:2px; min-width:26px; height:26px; border-radius:999px; background:#111827; color:white; font-size:0.8rem; font-weight:700; display:flex; align-items:center; justify-content:center; padding:0 7px;">${data.count}</span>`);
            }
        };

        // Selection Popover Toggle
        document.addEventListener('click', (e) => {
            const toggleBtn = e.target.closest('[data-toggle-selection]');
            if (toggleBtn) {
                e.stopPropagation();
                const popover = toggleBtn.nextElementSibling;
                const isVisible = popover.style.display === 'block';
                
                // Close all others
                document.querySelectorAll('.selection-popover').forEach(p => p.style.display = 'none');
                
                popover.style.display = isVisible ? 'none' : 'block';
                return;
            }

            // Close popovers when clicking outside
            if (!e.target.closest('.selection-popover')) {
                document.querySelectorAll('.selection-popover').forEach(p => p.style.display = 'none');
            }
        });

        // AJAX Form Submissions (Add & Remove)
        document.addEventListener('submit', async (e) => {
            const form = e.target.closest('[data-ajax-cart-form], [data-ajax-cart-remove]');
            if (!form) return;

            e.preventDefault();
            const btn = form.querySelector('button');
            const originalContent = btn.innerHTML;
            const isAdd = form.hasAttribute('data-ajax-cart-form');

            btn.disabled = true;
            if (isAdd) btn.textContent = '...';

            try {
                const formData = new FormData(form);
                const res = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();

                if (data.success) {
                    updateCartUI(data);

                    if (isAdd) {
                        btn.textContent = '✓';
                        window.showToast('เพิ่มสินค้าลงตะกร้าแล้ว', 'success');
                        // Close popover if any
                        const popover = form.closest('.selection-popover');
                        if (popover) setTimeout(() => popover.style.display = 'none', 500);
                        
                        setTimeout(() => {
                            btn.innerHTML = originalContent;
                            btn.disabled = false;
                        }, 1000);
                    } else {
                        window.showToast('ลบสินค้าออกจากตะกร้าแล้ว', 'info');
                    }
                }
            } catch (err) {
                btn.innerHTML = originalContent;
                btn.disabled = false;
                window.showToast('ไม่สามารถชำระออเดอร์ได้ในขณะนี้', 'error');
            }
        });

        // Quantity Adjustment Buttons
        document.addEventListener('click', async (e) => {
            const qtyBtn = e.target.closest('.cart-qty-btn');
            if (!qtyBtn) return;

            const { id, action } = qtyBtn.dataset;
            qtyBtn.disabled = true;

            try {
                const res = await fetch('{{ route('cart.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ id, action })
                });
                const data = await res.json();

                if (data.success) {
                    updateCartUI(data);
                }
            } catch (err) {
                console.error('Update failed:', err);
                window.showToast('ไม่สามารถปรับจำนวนได้', 'error');
            } finally {
                qtyBtn.disabled = false;
            }
        });
    </script>
    @include('store.partials.notifications')
</body>
</html>
