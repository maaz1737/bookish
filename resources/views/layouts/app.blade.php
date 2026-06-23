<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $seo['title'] ?? 'Bookish & Beyond | School Essentials, Baby Wear & Gifts' }}</title>
    <meta name="description"
        content="{{ $seo['description'] ?? 'School books, bundles, uniforms & accessories in Pakistan.' }}">
    <meta name="keywords" content="{{ $seo['keywords'] ?? 'school books Pakistan, book bundle, school uniforms' }}">
    <meta property="og:title" content="{{ $seo['title'] ?? 'Bookish & Beyond' }}">
    <meta property="og:description" content="{{ $seo['description'] ?? '' }}">
    <meta property="og:type" content="website">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { 50: '#f0f4fa', 100: '#dbe4f3', 600: '#1e3a8a', 700: '#172f6e', 800: '#0f2350', 900: '#0a1a3d' },
                        gold: { 400: '#f5b942', 500: '#f59e0b', 600: '#d97706' },
                    },
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] }
                }
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
        }

        /* ===== FIXED IMAGE CARD CONTAINER =====
           Any image (large or small) is centered and scaled to fit the same box.
           Use class="card-img-box" on the wrapper and class="card-img" on <img>. */
        .card-img-box {
            width: 100%;
            aspect-ratio: 1 / 0.8;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #fff;
        }

        .card-img-box .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .35s ease;
        }

        .card-img-box:hover .card-img {
            transform: scale(1.05);
        }

        /* logo / circular image box for school cards */
        .logo-box {
            width: 64px;
            height: 64px;
            border-radius: 9999px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            border: 1px solid #e5e7eb;
        }

        .logo-box img {
            max-width: 80%;
            max-height: 80%;
            object-fit: contain;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

    {{-- ===== TOP UTILITY BAR ===== --}}
    <div class="bg-navy-800 text-white text-xs">
        <div class="max-w-7xl mx-auto px-4 py-2 flex flex-wrap items-center justify-between gap-2">
            <span><i class="fa-solid fa-truck-fast text-gold-400 mr-2"></i>Free Delivery on Orders Above PKR 3000</span>
            <span class="hidden md:inline"><i class="fa-solid fa-shield-halved text-gold-400 mr-2"></i>100% Original
                Products</span>
            <span><i class="fa-solid fa-phone text-gold-400 mr-2"></i>Customer Support 0321 1234567</span>
        </div>
    </div>

    {{-- ===== HEADER ===== --}}
    <header class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center gap-6">
            <a href="{{ url('/') }}" class="shrink-0">
                <h1 class="text-2xl font-extrabold text-navy-800">Bookish <span class="text-gold-500">& Beyond</span>
                </h1>
                <p class="text-xs text-slate-500">School Essentials, Baby Wear & Gifts</p>
            </a>

            <form action="#" class="flex-1 hidden md:flex border border-slate-300 rounded-lg overflow-hidden">
                <input type="text" placeholder="Search books, uniforms, bags, accessories..."
                    class="flex-1 px-4 py-2 text-sm outline-none">
                <select class="border-l border-slate-300 px-3 text-sm bg-white">
                    <option>All Categories</option>
                </select>
                <button class="bg-navy-800 text-white px-5"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>

            <div class="flex items-center gap-6 text-slate-700">
                <a href="#" class="flex flex-col items-center text-xs"><i class="fa-regular fa-user text-lg"></i>Login /
                    Register</a>
                <a href="#" class="relative flex flex-col items-center text-xs"><i
                        class="fa-regular fa-heart text-lg"></i>Wishlist<span
                        class="absolute -top-1 right-2 bg-gold-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center">0</span></a>
                <?php
$cart = session('cart', []);

$totalQty = array_sum(array_column($cart, 'quantity'));
                        ?>
                <a href="#" class="relative flex flex-col items-center text-xs"><i
                        class="fa-solid fa-cart-shopping text-lg"></i>Cart<span
                        class="absolute -top-1 right-2 bg-gold-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center">{{ $totalQty ?? 0 }}</span></a>
            </div>
        </div>

        {{-- nav --}}
        <nav class="max-w-7xl mx-auto px-4 pb-4 flex items-center gap-2 flex-wrap">
            <button class="bg-navy-800 text-white px-5 py-2.5 rounded-md text-sm font-semibold flex items-center gap-2">
                <i class="fa-solid fa-bars"></i> Shop All Categories <i class="fa-solid fa-arrow-right ml-2"></i>
            </button>
            <a href="#" class="px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-navy-800"><i
                    class="fa-solid fa-school text-navy-600 mr-1"></i> Shop by School</a>
            <a href="#" class="px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-navy-800"><i
                    class="fa-solid fa-book text-navy-600 mr-1"></i> Books</a>
            <a href="#" class="px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-navy-800"><i
                    class="fa-solid fa-shirt text-navy-600 mr-1"></i> Uniforms</a>
            <a href="#" class="px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-navy-800"><i
                    class="fa-solid fa-bag-shopping text-navy-600 mr-1"></i> Bags & Bottles</a>
            <a href="#" class="px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-navy-800"><i
                    class="fa-solid fa-gift text-navy-600 mr-1"></i> Gifts</a>
            <a href="#"
                class="ml-auto bg-gold-500 hover:bg-gold-600 text-white px-5 py-2.5 rounded-md text-sm font-semibold"><i
                    class="fa-solid fa-tag mr-1"></i> Offers</a>
        </nav>
    </header>

    {{-- ===== FLASH MESSAGES ===== --}}
    @if (session('success'))
        <div
            class="max-w-7xl mx-auto w-full px-4 mt-4 bg-green-50 border border-green-200 text-green-800 rounded-md p-3 text-sm">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="max-w-7xl mx-auto w-full px-4 mt-4 bg-red-50 border border-red-200 text-red-800 rounded-md p-3 text-sm">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    {{-- ===== MAIN ===== --}}
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 py-8">
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-navy-900 text-slate-300 mt-12">
        <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-2 md:grid-cols-5 gap-8 text-sm">
            <div class="col-span-2">
                <h3 class="text-white text-lg font-bold">Bookish <span class="text-gold-500">& Beyond</span></h3>
                <p class="mt-3 text-slate-400 leading-relaxed">School essentials, baby wear & gifts. We offer quality
                    items for school, studies, uniforms, books, baby wear, gifts and more.</p>
                <div class="flex gap-3 mt-4">
                    <a href="#"
                        class="w-8 h-8 rounded-full bg-navy-800 flex items-center justify-center hover:bg-gold-500"><i
                            class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"
                        class="w-8 h-8 rounded-full bg-navy-800 flex items-center justify-center hover:bg-gold-500"><i
                            class="fa-brands fa-instagram"></i></a>
                    <a href="#"
                        class="w-8 h-8 rounded-full bg-navy-800 flex items-center justify-center hover:bg-gold-500"><i
                            class="fa-brands fa-whatsapp"></i></a>
                    <a href="#"
                        class="w-8 h-8 rounded-full bg-navy-800 flex items-center justify-center hover:bg-gold-500"><i
                            class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Quick Links</h4>
                <ul class="space-y-2">
                    <li>About Us</li>
                    <li>Shop by Category</li>
                    <li>Track Order</li>
                    <li>Returns & Refunds</li>
                    <li>FAQs</li>
                    <li>Contact Us</li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Shop</h4>
                <ul class="space-y-2">
                    <li>Books</li>
                    <li>Uniforms</li>
                    <li>Bags & Bottles</li>
                    <li>Baby Wear</li>
                    <li>Accessories</li>
                    <li>Gifts</li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Customer Service</h4>
                <ul class="space-y-2">
                    <li><i class="fa-solid fa-phone text-gold-400 mr-2"></i>+92 300 1234567</li>
                    <li><i class="fa-solid fa-envelope text-gold-400 mr-2"></i>support@bookish.pk</li>
                    <li><i class="fa-solid fa-location-dot text-gold-400 mr-2"></i>Lahore, Pakistan</li>
                    <li><i class="fa-regular fa-clock text-gold-400 mr-2"></i>Mon - Sat (10AM - 8PM)</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-navy-800">
            <div class="max-w-7xl mx-auto px-4 py-4 text-center text-xs text-slate-400">
                © {{ date('Y') }} Bookish & Beyond. All Rights Reserved.
            </div>
        </div>
    </footer>
</body>

</html>