<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO --}}
    <title>{{ $seo['title'] ?? 'Bookish & Beyond | School Essentials Store' }}</title>
    <meta name="description" content="{{ $seo['description'] ?? 'School books, bundles, uniforms & accessories in Pakistan.' }}">
    <meta name="keywords"    content="{{ $seo['keywords']     ?? 'school books Pakistan, book bundle, school uniforms' }}">
    <meta property="og:title"       content="{{ $seo['title'] ?? 'Bookish & Beyond' }}">
    <meta property="og:description" content="{{ $seo['description'] ?? '' }}">
    <meta property="og:type"        content="website">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    {{-- jQuery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- Swiper --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Announcement bar ─────────────────── */
        .announcement-bar { background: linear-gradient(90deg, #0f172a, #1e3a8a, #0f172a); font-size: 12px; }

        /* ── Header ──────────────────────────── */
        #main-header { position: sticky; top: 0; z-index: 100; background: #fff; box-shadow: 0 1px 8px rgba(0,0,0,.07); transition: box-shadow 0.3s; }
        #main-header.scrolled { box-shadow: 0 2px 20px rgba(0,0,0,.12); }

        /* ── Search bar ──────────────────────── */
        .search-input:focus { outline: none; border-color: #1e3a8a; box-shadow: 0 0 0 3px rgba(30,58,138,.12); }

        /* ── Nav bar ─────────────────────────── */
        .nav-bar { background: #0f172a; }
        .nav-link-item { position: relative; font-size: 13.5px; font-weight: 600; color: rgba(255,255,255,.82); padding: 12px 14px; transition: color .18s; white-space: nowrap; }
        .nav-link-item:hover { color: #fbbf24; }
        .nav-link-item.active { color: #fbbf24; }
        .nav-link-item::after { content:''; position:absolute; bottom:0; left:14px; right:14px; height:2px; background:#fbbf24; border-radius:2px 2px 0 0; transform:scaleX(0); transition:transform .2s; }
        .nav-link-item:hover::after, .nav-link-item.active::after { transform:scaleX(1); }

        /* ── Mobile menu ─────────────────────── */
        #mobile-drawer { position: fixed; inset: 0; z-index: 200; }
        #mobile-drawer-overlay { position:absolute; inset:0; background:rgba(0,0,0,.55); }
        #mobile-drawer-panel { position:absolute; left:0; top:0; bottom:0; width:300px; background:#0f172a; overflow-y:auto; transform:translateX(-100%); transition:transform .3s cubic-bezier(.4,0,.2,1); }
        #mobile-drawer.open #mobile-drawer-panel { transform:translateX(0); }
        .mob-link { display:block; padding:13px 20px; font-size:14px; font-weight:600; color:rgba(255,255,255,.8); border-bottom:1px solid rgba(255,255,255,.06); transition:background .15s, color .15s; }
        .mob-link:hover { background:rgba(255,255,255,.07); color:#fbbf24; }
        .mob-sub-link { display:block; padding:10px 20px 10px 36px; font-size:13px; color:rgba(255,255,255,.55); border-bottom:1px solid rgba(255,255,255,.04); transition:background .15s, color .15s; }
        .mob-sub-link:hover { color:#fbbf24; background:rgba(255,255,255,.04); }

        /* ── Cart / wishlist badge ────────────── */
        .icon-btn { position:relative; display:flex; flex-direction:column; align-items:center; gap:2px; font-size:11px; font-weight:600; color:#374151; transition:color .18s; cursor:pointer; }
        .icon-btn:hover { color:#1e3a8a; }
        .icon-btn .badge { position:absolute; top:-4px; right:-6px; min-width:18px; height:18px; padding:0 4px; border-radius:999px; font-size:10px; font-weight:700; display:flex; align-items:center; justify-content:center; }

        /* ── Footer ──────────────────────────── */
        .footer-link { color:#94a3b8; font-size:13.5px; transition:color .15s; }
        .footer-link:hover { color:#fff; }

        /* ── Flash toast ─────────────────────── */
        .flash-toast { animation: slideDown .35s ease; }
        @keyframes slideDown { from{opacity:0;transform:translateY(-10px)} to{opacity:1;transform:translateY(0)} }

        /* ── Scrollbar ───────────────────────── */
        ::-webkit-scrollbar { width:6px; }
        ::-webkit-scrollbar-track { background:#f1f5f9; }
        ::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:99px; }
        ::-webkit-scrollbar-thumb:hover { background:#94a3b8; }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 min-h-screen flex flex-col antialiased">

{{-- ════════════════════════════════════════════════════════════
     ANNOUNCEMENT BAR
═════════════════════════════════════════════════════════════ --}}
<div class="announcement-bar text-white py-2 text-center overflow-hidden relative">
    <div class="flex items-center justify-center gap-6 animate-marquee-pause">
        <span class="flex items-center gap-1.5"><i class="fa-solid fa-truck-fast text-yellow-400 text-xs"></i> Free delivery on orders above PKR 1,500</span>
        <span class="hidden sm:flex items-center gap-1.5"><i class="fa-solid fa-shield-halved text-yellow-400 text-xs"></i> 100% Authentic Products</span>
        <span class="hidden md:flex items-center gap-1.5"><i class="fa-solid fa-headset text-yellow-400 text-xs"></i> 24/7 Customer Support</span>
        <span class="hidden lg:flex items-center gap-1.5"><i class="fa-solid fa-rotate-left text-yellow-400 text-xs"></i> Easy Returns</span>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════
     STICKY HEADER
═════════════════════════════════════════════════════════════ --}}
<header id="main-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex items-center gap-3 sm:gap-5">

        {{-- Hamburger (mobile) --}}
        <button id="hamburger-btn" class="lg:hidden flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 transition flex-shrink-0" aria-label="Open menu">
            <i class="fa-solid fa-bars text-base"></i>
        </button>

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex-shrink-0 flex flex-col leading-none">
            <span class="text-xl sm:text-2xl font-extrabold text-blue-900 tracking-tight">Bookish <span class="italic text-yellow-500">&amp; Beyond</span></span>
            <span class="text-[10px] text-slate-400 font-medium hidden sm:block">School Essentials, Baby Wear &amp; Gifts</span>
        </a>

        {{-- Search Bar --}}
        <div class="flex-1 hidden md:block">
            <div class="relative max-w-xl">
                <input id="header-search" type="text" placeholder="Search books, uniforms, bags, gifts…"
                    class="search-input w-full border border-slate-200 bg-slate-50 rounded-xl pl-4 pr-12 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 transition">
                <button class="absolute right-1 top-1/2 -translate-y-1/2 bg-blue-900 hover:bg-blue-800 text-white px-3 py-1.5 rounded-lg text-sm transition">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </button>
            </div>
        </div>

        {{-- Icons: Search (mobile), Wishlist, Cart --}}
        <div class="flex items-center gap-1 sm:gap-3 ml-auto lg:ml-0">

            {{-- Mobile search toggle --}}
            <button id="mobile-search-btn" class="md:hidden icon-btn w-9 h-9 rounded-lg border border-slate-200 hover:bg-slate-100 transition text-slate-600" aria-label="Search">
                <i class="fa-solid fa-magnifying-glass text-base"></i>
            </button>

            {{-- Wishlist --}}
            @php $wishlistCount = count(session('wishlist', [])); @endphp
            <a href="#" class="icon-btn hidden sm:flex px-2 py-1 rounded-lg hover:bg-slate-100 transition">
                <span class="relative">
                    <i class="fa-regular fa-heart text-xl text-slate-600"></i>
                    <span id="wishlist-count" class="badge bg-red-500 text-white {{ $wishlistCount > 0 ? '' : 'hidden' }}">{{ $wishlistCount }}</span>
                </span>
                <span class="text-slate-600">Wishlist</span>
            </a>

            {{-- Cart --}}
            @php $cartCount = collect(session('cart', []))->sum('quantity'); @endphp
            <a href="{{ route('cart.index') }}" class="icon-btn px-2 sm:px-3 py-1.5 bg-blue-900 hover:bg-blue-800 text-white rounded-xl transition">
                <span class="relative">
                    <i class="fa-solid fa-cart-shopping text-base"></i>
                    <span id="cart-count" class="badge bg-yellow-400 text-blue-900 {{ $cartCount > 0 ? '' : 'opacity-0' }}">{{ $cartCount }}</span>
                </span>
                <span class="hidden sm:block text-white">Cart</span>
            </a>

        </div>
    </div>

    {{-- Mobile Search Bar (hidden by default) --}}
    <div id="mobile-search-bar" class="hidden md:hidden border-t border-slate-100 px-4 py-2.5">
        <div class="relative">
            <input type="text" placeholder="Search products…"
                class="search-input w-full border border-slate-200 bg-slate-50 rounded-xl pl-4 pr-12 py-2.5 text-sm text-slate-700 placeholder:text-slate-400">
            <button class="absolute right-1 top-1/2 -translate-y-1/2 bg-blue-900 text-white px-3 py-1.5 rounded-lg text-sm">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </button>
        </div>
    </div>
</header>

{{-- ════════════════════════════════════════════════════════════
     NAVIGATION BAR (desktop)
═════════════════════════════════════════════════════════════ --}}
<nav class="nav-bar hidden lg:block">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 flex items-center">

        {{-- Category mega button --}}
        <div class="relative group">
            <button class="flex items-center gap-2 bg-yellow-400 hover:bg-yellow-300 text-blue-900 font-bold text-sm px-5 py-3.5 transition-colors">
                <i class="fa-solid fa-grid-2 text-xs"></i>
                All Categories
                <i class="fa-solid fa-chevron-down text-[10px] ml-1 group-hover:rotate-180 transition-transform duration-200"></i>
            </button>
            {{-- Mega dropdown --}}
            <div class="absolute left-0 top-full w-56 bg-white rounded-b-xl shadow-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                @php
                    $megaLinks = [
                        ['Books',         'fa-book-open',    'books'],
                        ['Uniforms',      'fa-shirt',        'uniforms'],
                        ['Bags',          'fa-bag-shopping', 'bags'],
                        ['Bottles',       'fa-bottle-water', 'bottles'],
                        ['Baby Wear',     'fa-baby',         'baby-wear'],
                        ['Gifts',         'fa-gift',         'gifts'],
                        ['Accessories',   'fa-stars',        'accessories'],
                        ['Lunch Boxes',   'fa-box',          'lunch-boxes'],
                    ];
                @endphp
                @foreach($megaLinks as [$label, $icon, $slug])
                    <a href="{{ route('category.show', $slug) }}"
                       class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-900 font-medium transition border-b border-slate-50 last:border-0">
                        <i class="fa-solid {{ $icon }} text-blue-300 w-4 text-center text-xs"></i>
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Nav Links --}}
        <div class="flex items-center flex-1 overflow-x-auto">
            @php
                $navLinks = [
                    ['Schools',      route('schools.index'),              'schools.index'],
                    ['Books',        route('category.show', 'books'),     'category.show'],
                    ['Uniforms',     route('category.show', 'uniforms'),  'category.show'],
                    ['Bags',         route('category.show', 'bags'),      'category.show'],
                    ['Baby Wear',    route('category.show', 'baby-wear'), 'category.show'],
                    ['Gifts',        route('category.show', 'gifts'),     'category.show'],
                    ['Accessories',  route('category.show', 'accessories'),'category.show'],
                    ['Contact',      route('contact'),                    'contact'],
                ];
            @endphp
            @foreach($navLinks as [$label, $href, $routeName])
                <a href="{{ $href }}" class="nav-link-item {{ request()->routeIs($routeName) ? 'active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Promo badge --}}
        <a href="#" class="flex-shrink-0 flex items-center gap-2 bg-orange-500 hover:bg-orange-400 text-white text-xs font-bold px-4 py-3.5 ml-auto transition-colors">
            <i class="fa-solid fa-fire-flame-curved"></i> Hot Deals
        </a>
    </div>
</nav>

{{-- ════════════════════════════════════════════════════════════
     MOBILE DRAWER
═════════════════════════════════════════════════════════════ --}}
<div id="mobile-drawer" class="hidden lg:hidden" aria-hidden="true">
    <div id="mobile-drawer-overlay"></div>
    <div id="mobile-drawer-panel">

        {{-- Drawer Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-white/10">
            <div>
                <span class="text-white font-extrabold text-lg">Bookish <span class="italic text-yellow-400">&amp; Beyond</span></span>
                <p class="text-slate-400 text-[10px] font-medium">School Essentials Store</p>
            </div>
            <button id="drawer-close-btn" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        {{-- Mobile Search --}}
        <div class="px-4 py-3 border-b border-white/10">
            <div class="relative">
                <input type="text" placeholder="Search products…"
                    class="w-full bg-white/10 border border-white/20 rounded-xl pl-4 pr-10 py-2.5 text-sm text-white placeholder:text-slate-400 focus:outline-none focus:border-yellow-400">
                <i class="fa-solid fa-magnifying-glass absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            </div>
        </div>

        {{-- Main links --}}
        <nav>
            <a href="{{ route('home') }}" class="mob-link">
                <i class="fa-solid fa-house-chimney text-yellow-400 mr-2 w-4 text-center text-xs"></i> Home
            </a>
            <a href="{{ route('schools.index') }}" class="mob-link">
                <i class="fa-solid fa-school text-blue-400 mr-2 w-4 text-center text-xs"></i> Schools
            </a>

            {{-- Categories accordion --}}
            <button class="mob-link w-full text-left flex items-center justify-between" onclick="document.getElementById('mob-cats').classList.toggle('hidden')">
                <span><i class="fa-solid fa-grid-2 text-indigo-400 mr-2 w-4 text-center text-xs"></i> Categories</span>
                <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform"></i>
            </button>
            <div id="mob-cats">
                <a href="{{ route('category.show', 'books') }}"       class="mob-sub-link"><i class="fa-solid fa-book-open mr-2 text-xs"></i> Books</a>
                <a href="{{ route('category.show', 'uniforms') }}"    class="mob-sub-link"><i class="fa-solid fa-shirt mr-2 text-xs"></i> Uniforms</a>
                <a href="{{ route('category.show', 'bags') }}"        class="mob-sub-link"><i class="fa-solid fa-bag-shopping mr-2 text-xs"></i> Bags</a>
                <a href="{{ route('category.show', 'bottles') }}"     class="mob-sub-link"><i class="fa-solid fa-bottle-water mr-2 text-xs"></i> Bottles</a>
                <a href="{{ route('category.show', 'baby-wear') }}"   class="mob-sub-link"><i class="fa-solid fa-baby mr-2 text-xs"></i> Baby Wear</a>
                <a href="{{ route('category.show', 'gifts') }}"       class="mob-sub-link"><i class="fa-solid fa-gift mr-2 text-xs"></i> Gifts</a>
                <a href="{{ route('category.show', 'accessories') }}" class="mob-sub-link"><i class="fa-solid fa-stars mr-2 text-xs"></i> Accessories</a>
                <a href="{{ route('category.show', 'lunch-boxes') }}" class="mob-sub-link"><i class="fa-solid fa-box mr-2 text-xs"></i> Lunch Boxes</a>
            </div>

            <a href="{{ route('contact') }}" class="mob-link">
                <i class="fa-solid fa-envelope text-pink-400 mr-2 w-4 text-center text-xs"></i> Contact Us
            </a>
            <a href="{{ route('cart.index') }}" class="mob-link">
                <i class="fa-solid fa-cart-shopping text-green-400 mr-2 w-4 text-center text-xs"></i>
                Cart
                @if($cartCount > 0)
                    <span class="ml-2 bg-yellow-400 text-blue-900 text-[10px] font-bold rounded-full px-2 py-0.5">{{ $cartCount }}</span>
                @endif
            </a>
        </nav>

        {{-- Footer info inside drawer --}}
        <div class="mx-4 mt-6 p-4 bg-white/5 rounded-xl border border-white/10">
            <p class="text-slate-400 text-xs font-semibold mb-3 uppercase tracking-wide">Support</p>
            <div class="space-y-2 text-xs text-slate-300">
                <div class="flex items-center gap-2"><i class="fa-solid fa-phone text-yellow-400"></i> +92 300 1234567</div>
                <div class="flex items-center gap-2"><i class="fa-solid fa-envelope text-yellow-400"></i> support@bookish.pk</div>
                <div class="flex items-center gap-2"><i class="fa-solid fa-location-dot text-yellow-400"></i> Lahore, Pakistan</div>
            </div>
        </div>

    </div>
</div>

{{-- ════════════════════════════════════════════════════════════
     FLASH NOTIFICATIONS
═════════════════════════════════════════════════════════════ --}}
<div class="max-w-7xl mx-auto w-full px-4 sm:px-6 mt-3">
    @if(session('success'))
        <div class="flash-toast flex items-center justify-between p-3.5 mb-3 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm">
            <div class="flex items-center gap-2 text-sm font-semibold">
                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                {{ session('success') }}
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-700 text-xs font-bold ml-4">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="flash-toast flex items-center justify-between p-3.5 mb-3 text-red-800 bg-red-50 border border-red-200 rounded-xl shadow-sm">
            <div class="flex items-center gap-2 text-sm font-semibold">
                <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                {{ session('error') }}
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-700 text-xs font-bold ml-4">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif
</div>

{{-- ════════════════════════════════════════════════════════════
     MAIN CONTENT
═════════════════════════════════════════════════════════════ --}}
<main class="flex-grow w-full">
    @yield('content')
</main>

{{-- ════════════════════════════════════════════════════════════
     FOOTER
═════════════════════════════════════════════════════════════ --}}
<footer class="bg-slate-900 text-white mt-8">

    {{-- Newsletter Strip --}}
    <div class="bg-blue-900 border-b border-blue-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h4 class="font-bold text-white text-base">📩 Stay in the Loop!</h4>
                <p class="text-blue-200 text-xs mt-0.5">Get school season deals and new arrivals straight to your inbox.</p>
            </div>
            <div class="flex w-full sm:w-auto gap-2">
                <input type="email" placeholder="Your email address"
                    class="flex-1 sm:w-64 bg-white/10 border border-blue-600 rounded-xl px-4 py-2.5 text-sm text-white placeholder:text-blue-300 focus:outline-none focus:border-yellow-400 transition">
                <button class="bg-yellow-400 hover:bg-yellow-300 text-blue-900 font-bold text-sm px-5 py-2.5 rounded-xl transition whitespace-nowrap">
                    Subscribe
                </button>
            </div>
        </div>
    </div>

    {{-- Main Footer Grid --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-8 lg:gap-12">

        {{-- Brand --}}
        <div class="col-span-2 md:col-span-1">
            <h3 class="text-2xl font-extrabold">Bookish <span class="italic text-yellow-400">&amp; Beyond</span></h3>
            <p class="mt-3 text-slate-400 text-sm leading-relaxed">Pakistan's trusted destination for school books, uniforms, bags, baby wear, and gifts.</p>
            <div class="mt-5 flex items-center gap-3">
                <a href="#" class="w-9 h-9 rounded-lg bg-white/10 hover:bg-blue-600 flex items-center justify-center transition" aria-label="Facebook">
                    <i class="fa-brands fa-facebook-f text-sm"></i>
                </a>
                <a href="#" class="w-9 h-9 rounded-lg bg-white/10 hover:bg-pink-600 flex items-center justify-center transition" aria-label="Instagram">
                    <i class="fa-brands fa-instagram text-sm"></i>
                </a>
                <a href="#" class="w-9 h-9 rounded-lg bg-white/10 hover:bg-green-600 flex items-center justify-center transition" aria-label="WhatsApp">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                </a>
                <a href="#" class="w-9 h-9 rounded-lg bg-white/10 hover:bg-red-600 flex items-center justify-center transition" aria-label="YouTube">
                    <i class="fa-brands fa-youtube text-sm"></i>
                </a>
            </div>
        </div>

        {{-- Quick Links --}}
        <div>
            <h4 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Quick Links</h4>
            <ul class="space-y-2.5">
                <li><a href="{{ route('home') }}"          class="footer-link hover:underline">Home</a></li>
                <li><a href="{{ route('schools.index') }}" class="footer-link hover:underline">Schools</a></li>
                <li><a href="{{ route('cart.index') }}"    class="footer-link hover:underline">My Cart</a></li>
                <li><a href="{{ route('contact') }}"       class="footer-link hover:underline">Contact Us</a></li>
            </ul>
        </div>

        {{-- Categories --}}
        <div>
            <h4 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Categories</h4>
            <ul class="space-y-2.5">
                <li><a href="{{ route('category.show', 'books') }}"       class="footer-link hover:underline">Books</a></li>
                <li><a href="{{ route('category.show', 'uniforms') }}"    class="footer-link hover:underline">Uniforms</a></li>
                <li><a href="{{ route('category.show', 'bags') }}"        class="footer-link hover:underline">Bags &amp; Bottles</a></li>
                <li><a href="{{ route('category.show', 'baby-wear') }}"   class="footer-link hover:underline">Baby Wear</a></li>
                <li><a href="{{ route('category.show', 'gifts') }}"       class="footer-link hover:underline">Gifts</a></li>
                <li><a href="{{ route('category.show', 'accessories') }}" class="footer-link hover:underline">Accessories</a></li>
            </ul>
        </div>

        {{-- Contact --}}
        <div>
            <h4 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Contact Us</h4>
            <ul class="space-y-3">
                <li class="flex items-start gap-2.5 text-sm text-slate-400">
                    <i class="fa-solid fa-phone text-yellow-400 mt-0.5 flex-shrink-0"></i>
                    <span>+92 300 1234567</span>
                </li>
                <li class="flex items-start gap-2.5 text-sm text-slate-400">
                    <i class="fa-brands fa-whatsapp text-yellow-400 mt-0.5 flex-shrink-0"></i>
                    <span>+92 300 1234567</span>
                </li>
                <li class="flex items-start gap-2.5 text-sm text-slate-400">
                    <i class="fa-solid fa-envelope text-yellow-400 mt-0.5 flex-shrink-0"></i>
                    <span>support@bookish.pk</span>
                </li>
                <li class="flex items-start gap-2.5 text-sm text-slate-400">
                    <i class="fa-solid fa-location-dot text-yellow-400 mt-0.5 flex-shrink-0"></i>
                    <span>Lahore, Punjab, Pakistan</span>
                </li>
            </ul>
        </div>

    </div>

    {{-- Trust badges --}}
    <div class="border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-slate-500 text-xs order-2 sm:order-1">
                © {{ date('Y') }} Bookish &amp; Beyond. All Rights Reserved.
            </p>
            <div class="flex flex-wrap items-center gap-2 order-1 sm:order-2">
                <div class="flex items-center gap-1 bg-white/5 border border-white/10 rounded-lg px-3 py-1.5 text-xs text-slate-300 font-semibold">
                    <i class="fa-solid fa-lock text-yellow-400 text-[10px]"></i> Secure Checkout
                </div>
                <div class="flex items-center gap-2 bg-white rounded-lg px-3 py-1.5">
                    <span class="text-blue-800 font-extrabold text-xs italic">VISA</span>
                </div>
                <div class="flex items-center gap-2 bg-white rounded-lg px-3 py-1.5">
                    <span class="text-red-600 font-bold text-xs">MC</span>
                </div>
                <div class="flex items-center gap-2 bg-white rounded-lg px-3 py-1.5">
                    <span class="text-green-600 font-bold text-xs">Easypaisa</span>
                </div>
                <div class="flex items-center gap-2 bg-white rounded-lg px-3 py-1.5">
                    <span class="text-orange-500 font-bold text-xs">JazzCash</span>
                </div>
                <div class="flex items-center gap-2 bg-white rounded-lg px-3 py-1.5">
                    <span class="text-blue-500 font-bold text-xs">Raast</span>
                </div>
            </div>
        </div>
    </div>
</footer>

{{-- ════════════════════════════════════════════════════════════
     JAVASCRIPT
═════════════════════════════════════════════════════════════ --}}
<script>
$(function () {

    /* ── Sticky header shadow on scroll ─────────────────────── */
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 10) {
            $('#main-header').addClass('scrolled');
        } else {
            $('#main-header').removeClass('scrolled');
        }
    });

    /* ── Mobile hamburger drawer ─────────────────────────────── */
    function openDrawer() {
        $('#mobile-drawer').removeClass('hidden').attr('aria-hidden','false');
        $('body').addClass('overflow-hidden');
        setTimeout(() => $('#mobile-drawer').addClass('open'), 10);
    }
    function closeDrawer() {
        $('#mobile-drawer').removeClass('open');
        setTimeout(() => {
            $('#mobile-drawer').addClass('hidden').attr('aria-hidden','true');
            $('body').removeClass('overflow-hidden');
        }, 300);
    }

    $('#hamburger-btn').on('click', openDrawer);
    $('#drawer-close-btn, #mobile-drawer-overlay').on('click', closeDrawer);

    // Close drawer on Escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') closeDrawer();
    });

    /* ── Mobile search bar toggle ────────────────────────────── */
    $('#mobile-search-btn').on('click', function () {
        $('#mobile-search-bar').slideToggle(200);
    });

    /* ── Auto-dismiss flash toasts after 5s ─────────────────── */
    setTimeout(function () {
        $('.flash-toast').fadeOut(400, function () { $(this).remove(); });
    }, 5000);

});
</script>

</body>
</html>
