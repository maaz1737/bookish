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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            50: '#f0f4fa',
                            100: '#dbe4f3',
                            600: '#1e3a8a',
                            700: '#172f6e',
                            800: '#0f2350',
                            900: '#0a1a3d'
                        },
                        gold: {
                            400: '#f5b942',
                            500: '#f59e0b',
                            600: '#d97706'
                        },
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif']
                    }
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

    <style>
        /* From Uiverse.io by xXJollyHAKERXx */
        .spinner {
            width: 18px;
            height: 18px;
            background-image: linear-gradient(rgb(186, 66, 255) 35%, rgb(0, 225, 255));
            border-radius: 50%;
            animation: spinning82341 1.2s linear infinite;
            box-shadow:
                0 -1px 4px rgb(186, 66, 255),
                0 1px 4px rgb(0, 225, 255);
        }

        .spinner1 {
            width: 14px;
            height: 14px;
            margin: 2px;
            background: white;
            /* or your button background */
            border-radius: 50%;
        }

        @keyframes spinning82341 {
            to {
                transform: rotate(360deg);
            }
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
                    class="filter-search flex-1 px-4 py-2 text-sm outline-none">
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

                {{-- {{ route('cart.index') }} --}}
                <a href="#" class="cart relative flex flex-col items-center text-xs"><i
                        class="fa-solid fa-cart-shopping text-lg"></i>Cart<span
                        class="absolute -top-1 right-2 bg-gold-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center"
                        id="cart_count">0</span></a>
            </div>
        </div>

        {{-- nav --}}
        <nav class="max-w-7xl mx-auto px-4 pb-4 flex items-center gap-2 flex-wrap relative">

            {{-- Shop All Categories Dropdown Wrapper --}}
            <div class="relative z-50">
                {{-- Trigger Button --}}
                <button id="categoryDropdownBtn" type="button"
                    class="text-white bg-navy-800 px-5 py-2.5 rounded-md text-sm font-semibold flex items-center gap-2 transition duration-200 cursor-pointer select-none">
                    <i id="categoryBtnIcon" class="fa-solid fa-bars transition-transform duration-200"></i>
                    <span>Shop All Categories</span>
                    <i id="categoryChevronIcon"
                        class="fa-solid fa-chevron-down ml-2 text-xs transition-transform duration-200"></i>
                </button>

                {{-- Dropdown Menu Panel --}}
                <div id="categoryDropdownMenu"
                    class="absolute left-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-slate-200/80 py-2 hidden opacity-0 transition-all duration-200 -translate-y-2">

                    <div class="px-4 py-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 block">
                        Available Categories
                    </div>

                    <div class="max-h-80 overflow-y-auto">
                        @if (isset($categories) && $categories->count() > 0)
                            @foreach ($categories as $category)
                                <a href="{{ route('category.show', $category->slug) }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-blue-900 hover:bg-slate-50 transition border-b border-slate-50 last:border-0">
                                    <span
                                        class="w-7 h-7 shrink-0 rounded-full bg-slate-50 flex items-center justify-center text-slate-500 border border-slate-100">
                                        <i class="fa-solid fa-book text-xs"></i>
                                    </span>
                                    <span class="font-semibold leading-tight text-slate-800">{{ $category->name }}</span>
                                </a>
                            @endforeach
                        @else
                            <div class="px-4 py-3 text-xs text-slate-400 italic">No categories found</div>
                        @endif
                    </div>

                    <div class="border-t border-slate-100 mt-1 pt-1">
                        <a href="#categories-section"
                            class="flex items-center justify-center text-center py-2 text-xs font-bold text-blue-950 hover:bg-slate-50 transition w-full">
                            View All Categories &nbsp;→
                        </a>
                    </div>
                </div>
            </div>

            {{-- Rest of the Nav Links --}}
            <a href="{{ route('schools.index', 'schools')}}"
                class="px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-navy-800">
                <i class="fa-solid fa-school text-navy-600 mr-1"></i> Shop by School
            </a>
            <a href="{{ route('category.show', 'books') }}"
                class="px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-navy-800">
                <i class="fa-solid fa-book text-navy-600 mr-1"></i> Books
            </a>
            <a href="{{ route('category.show', 'uniforms') }}"
                class="px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-navy-800">
                <i class="fa-solid fa-shirt text-navy-600 mr-1"></i> Uniforms
            </a>
            <a href="#" class="px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-navy-800">
                <i class="fa-solid fa-bag-shopping text-navy-600 mr-1"></i> Bags & Bottles
            </a>
            <a href="#" class="px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-navy-800">
                <i class="fa-solid fa-gift text-navy-600 mr-1"></i> Gifts
            </a>
            <a href="#"
                class="ml-auto bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-md text-sm font-semibold transition">
                <i class="fa-solid fa-tag mr-1"></i> Offers
            </a>
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


    <!-- Overlay -->
    <div id="cartOverlay" class="fixed inset-0 bg-black/40 hidden z-[99999]">
    </div>

    <!-- Cart Sidebar -->
    <div id="cartDrawer" class="fixed top-0 right-0 h-screen w-[380px] bg-white shadow-xl
           translate-x-full transition-transform duration-300 ease-in-out
           z-[999999]">

        <div class="flex flex-col h-full bg-white">

            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-3 border-b">
                <h2 class="text-[15px] font-semibold text-gray-800">
                    Review Your Cart ({{ count($carts['items']) }})
                </h2>

                <button id="closeCart" class="text-gray-500 text-xl leading-none">
                    ×
                </button>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto">

                <div class="px-3 py-3 h-full" id="cart-container">
                </div>

            </div>

            <!-- Footer -->
            <div class="border-t bg-white">

                <!-- Discount -->
                <button class="w-full flex items-center justify-between px-4 py-3 text-[13px] text-gray-700">

                    <span>Got a discount code?</span>

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>

                </button>

                <div class="border-t"></div>

                <!-- Total -->
                <div class="px-4 py-3 flex justify-between items-start">

                    <div>

                        <p class="font-semibold text-[13px]">
                            Subtotal
                        </p>

                        <p class="text-[10px] text-gray-500 mt-1">
                            Shipping & taxes may be re-calculated at checkout
                        </p>

                    </div>

                    <div class="font-semibold text-[13px]" id="cart_total">
                        Rs {{ $carts['total'] }}
                    </div>

                </div>

                <!-- Checkout -->
                <div class="px-3 pb-3">
                    <a href="{{ url('/checkout') }}"
                        class="w-full block h-10 rounded bg-[#6C63FF] hover:bg-[#5e54f6] text-white text-sm font-medium flex items-center justify-center">
                        🛒 Checkout
                    </a>
                </div>

            </div>

        </div>
    </div>


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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('categoryDropdownBtn');
            const menu = document.getElementById('categoryDropdownMenu');
            const icon = document.getElementById('categoryBtnIcon');
            const chevron = document.getElementById('categoryChevronIcon');

            if (btn && menu) {
                // Toggle dropdown open/close
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const isHidden = menu.classList.contains('hidden');

                    if (isHidden) {
                        openMenu();
                    } else {
                        closeMenu();
                    }
                });

                // Close when clicking anywhere outside the dropdown
                document.addEventListener('click', function (e) {
                    if (!menu.contains(e.target) && !btn.contains(e.target)) {
                        closeMenu();
                    }
                });

                // Close on ESC keypress
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        closeMenu();
                    }
                });
            }

            function openMenu() {
                menu.classList.remove('hidden');
                btn.classList.add('bg-navy-900', 'shadow-md');
                icon.classList.add('rotate-90');
                chevron.classList.add('rotate-180');

                // Fast timeout to let browser register the layout change for transition
                setTimeout(() => {
                    menu.classList.remove('opacity-0', '-translate-y-2');
                    menu.classList.add('opacity-100', 'translate-y-0');
                }, 10);
            }

            function closeMenu() {
                menu.classList.remove('opacity-100', 'translate-y-0');
                menu.classList.add('opacity-0', '-translate-y-2');
                btn.classList.remove('bg-navy-900', 'shadow-md');
                icon.classList.remove('rotate-90');
                chevron.classList.remove('rotate-180');

                // Wait for tailwind transition animation before hiding complete display
                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 200);
            }
        });
    </script>

    <script>
        const storageUrl =
            "{{ app()->environment('production') ? asset('storage/') : asset('storage/') }}";
    </script>
    <script src="/js/cart.js"></script>


</body>

</html>