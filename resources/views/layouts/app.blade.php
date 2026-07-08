<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<!-- Include Alpine.js Core Script (Must be inside <head>) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Include Alpine.js Collapse Plugin (Accordions ki smooth opening ke liye) -->
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>

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

        /* ===== PREMIUM CARD STYLING ===== */
        .card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 31, 84, 0.08);
            border: 1px solid rgba(0, 31, 84, 0.06);
            overflow: hidden;
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0, 31, 84, 0.12);
        }

        /* ===== PRIMARY CTA BUTTON STYLING ===== */
        .primary-btn {
            background: #001F54;
            color: #ffffff;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            padding: 12px 20px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
        }

        .primary-btn:hover {
            background: #003B7A;
        }

        .primary-btn:focus {
            outline: 3px solid rgba(0, 31, 84, 0.25);
            outline-offset: 2px;
        }

        /* ===== PREMIUM BADGES ===== */
        .badge {
            background: #001F54;
            color: #ffffff;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }

        .badge-orange {
            background: #ff7a00;
            color: #ffffff;
        }

        /* ===== RESPONSIVE GRID LAYOUT ===== */
        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 28px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        @media (max-width: 1024px) {

            .grid-4,
            .grid-3 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {

            .grid-4,
            .grid-3 {
                grid-template-columns: 1fr;
            }
        }

        /* ===== IMAGE HANDLING DESIGN SYSTEM ===== */
        .card-img-box {
            width: 100%;
            /* aspect-ratio: 1 / 1;
            display: flex;
            align-items: center; */
            /* justify-content: center; */
            overflow: hidden;
            background: #f8fafc;
            /* Slate 50 background */
            margin: 0;
            padding: 0;
            /* border-bottom: 1px solid rgba(0, 31, 84, 0.06); */
        }

        .card-img-contain {
            width: 100%;
            max-height: 200px;
            /* object-fit: contain; */
            /* padding: 16px; */
            transition: transform 0.35s ease;
            aspect-ratio: 16/12;
        }

        .card-img-cover {
            width: 100%;
            max-height: 200px;
            aspect-rartio: 16/12;
            padding: 0;
            transition: transform 0.35s ease;
        }

        .card:hover .card-img-contain,
        .card:hover .card-img-cover,
        .group:hover .card-img-contain,
        .group:hover .card-img-cover {
            transform: scale(1.05);
        }

        /* Default fallback styling */
        .product-image img,
        .category-image img,
        .school-logo img,
        .logo-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .product-image,
        .category-image,
        .school-logo,
        .logo-box {
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: transparent;
        }

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

            @php
                $wishlistCount = 0;
                if (auth()->check()) {
                    $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                } else {
                    $wishlistCount = \App\Models\Wishlist::where('session_id', session()->getId())->count();
                }
            @endphp
            <div class="flex items-center gap-6 text-slate-700">
                <a href="#" class="flex flex-col items-center text-xs"><i class="fa-regular fa-user text-lg"></i>Login /
                    Register</a>
                <a href="{{ route('wishlist.index') }}" class="relative flex flex-col items-center text-xs"><i
                        class="fa-regular fa-heart text-lg"></i>Wishlist<span
                        class="absolute -top-1 right-2 bg-gold-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center wishlist-badge"
                        style="{{ $wishlistCount == 0 ? 'display: none;' : '' }}">{{ $wishlistCount }}</span></a>

                {{-- {{ route('cart.index') }} --}}
                <a href="#" class="cart relative flex flex-col items-center text-xs"><i
                        class="fa-solid fa-cart-shopping text-lg"></i>Cart<span
                        class="absolute -top-1 right-2 bg-gold-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center"
                        id="cart_count">0</span></a>
            </div>
        </div>

        {{-- nav --}}
        <nav class="max-w-7xl mx-auto px-4 flex items-center gap-2 relative pb-2">
            {{-- Rest of the Nav Links --}}
            <div class="category-dropdown relative">
                <a href="{{ route('schools.index') }}"
                    class="px-4 py-2.5 text-sm font-medium text-slate-700 transition-colors flex items-center rounded-md">
                    <i class="fa-solid fa-school mr-1"></i>
                    <span>Shop by School</span>
                    <i
                        class="categoryChevronIcon fa-solid fa-chevron-down ml-2 text-xs transition-transform duration-200"></i>
                </a>

                <div class="categoryDropdownMenu absolute left-0 w-[490px]  hidden z-50">

                    <div class="mt-2 rounded-xl shadow-2xl border border-slate-200 bg-white">
                        <div class="grid grid-cols-[180px_1fr]">

                            {{-- Left Side --}}
                            <div class="p-5 border-r border-slate-200">

                                <div class="">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-[#001F54]">
                                        <i class="fa-solid fa-school text-lg"></i>
                                    </div>

                                    <div>
                                        <h3 class="font-semibold text-[15px] text-[#1D3557]">
                                            Shop By School
                                        </h3>

                                        <p class="text-xs text-gray-500 leading-5 mt-2">
                                            Choose your school to find class-wise books,
                                            uniforms & school-specific items.
                                        </p>
                                    </div>
                                </div>

                            </div>

                            {{-- Right Side --}}
                            <div class="py-3">

                                <div class="max-h-[260px] overflow-y-auto">

                                    @forelse($mainSchools as $school)

                                        <a href="{{ route('schools.show', $school->slug) }}"
                                            class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition">

                                            <div
                                                class="w-11 h-11 rounded-full border border-gray-200 overflow-hidden bg-white flex items-center justify-center shrink-0">

                                                @if($school->logo)
                                                    <img src="{{ asset('storage/' . $school->logo) }}"
                                                        class="w-full h-full object-cover" alt="{{ $school->name }}">
                                                @else
                                                    <i class="fa-solid fa-school text-[#001F54]"></i>
                                                @endif

                                            </div>

                                            <span class="text-[14px] font-medium text-[#22324C] leading-5">
                                                {{ $school->name }}
                                            </span>

                                        </a>

                                    @empty

                                        <div class="px-5 py-4 text-sm text-gray-400">
                                            No schools found.
                                        </div>

                                    @endforelse

                                </div>

                                @if($mainSchools->count())

                                    <div class="border-t mt-2">

                                        <a href="{{ route('schools.index') }}"
                                            class="flex items-center justify-center py-4 text-sm font-semibold text-[#3559C7] hover:bg-gray-50">

                                            View All Schools
                                            <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>

                                        </a>

                                    </div>

                                @endif

                            </div>

                        </div>
                    </div>

                </div>
            </div>

            @foreach ($mainCategories as $mainCategory)
                <div class="category-dropdown relative">
                    <a href="{{ route('category.show', $mainCategory->slug) }}"
                        class="px-4 py-2.5 inline-block text-sm font-medium text-slate-700 transition-colors flex items-center rounded-md">
                        <span>{{ ucfirst($mainCategory->name) }}</span>
                        <i
                            class="categoryChevronIcon fa-solid fa-chevron-down ml-2 text-xs transition-transform duration-200"></i>
                    </a>

                    @if(count($mainCategory->children) > 0)
                        <div
                            class="categoryDropdownMenu absolute left-0 w-64 hidden opacity-0 transition-all duration-200 -translate-y-2 z-[99]">

                            <div class="bg-white rounded-xl shadow-xl border border-slate-200/80 mt-2">
                                @forelse ($mainCategory->children as $category)
                                    <a href="{{ route('category.show', $category->slug) }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-blue-900 hover:bg-slate-50 transition border-b border-slate-50 last:border-0">

                                        <span
                                            class="w-8 h-8 shrink-0 rounded-full overflow-hidden bg-slate-50 flex items-center justify-center border border-slate-100">
                                            @if ($category->image)
                                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                                    class="w-full h-full object-cover" loading="lazy">
                                            @else
                                                <i class="fa-solid fa-school text-sm text-[#001F54]"></i>
                                            @endif
                                        </span>

                                        <span class="font-semibold leading-tight text-slate-800">
                                            {{ ucfirst($category->name) }}
                                        </span>
                                    </a>
                                    @if ($category->allChildren->count())
                                        @foreach ($category->allChildren as $child)
                                            @include('admin.categories.link_category', ['cat' => $child])
                                        @endforeach
                                    @endif
                                @empty
                                    <div class="px-4 py-3 text-xs text-slate-400 italic">
                                        No Sub-Category Found
                                    </div>
                                @endforelse

                                <div class="border-t border-slate-100 mt-1 pt-1">
                                    <a href="{{ route('category.show', $mainCategory->slug) }}"
                                        class="flex items-center justify-center text-center py-2 text-xs font-bold text-blue-700 hover:bg-slate-50 transition w-full">
                                        View All {{ ucfirst($mainCategory->name) }} &nbsp;→
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endif
                </div>

            @endforeach
            <a href="#"
                class="ml-auto bg-[#ff7a00] hover:bg-[#e06c00] text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md">
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
                    <a href="{{ route('about') }}">
                        <li>About Us</li>
                    </a>
                    {{-- <a href="{{ route('shop-by-school') }}">
                        <li>Shop by School</li>
                    </a> --}}
                    {{-- <a href="{{route('shop-by-category')}}">
                        <li>Shop by Category</li>
                    </a> --}}
                    <a href="{{ route('returns-refunds') }}">
                        <li>Returns & Refunds</li>
                    </a>
                    {{-- <a href="{{ route('faqs')}}">
                        <li>FAQs</li>
                    </a> --}}
                    {{-- <li>About Us</li> --}}
                    {{-- <li>Shop by Category</li> --}}
                    {{-- <li>Track Order</li> --}}
                    {{-- <li>Returns & Refunds</li> --}}
                    <a href="{{ route('contact') }}">
                        <li>Contact Us</li>
                    </a>
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
        $(function () {

            // Toggle dropdown
            // Click: Toggle pinned state
            $(document).on('click', '.category-dropdown > a', function (e) {
                e.stopPropagation();

                const $dropdown = $(this).closest('.category-dropdown');

                if ($dropdown.hasClass('clicked-open')) {
                    $dropdown.removeClass('clicked-open');
                    closeMenu($dropdown);
                } else {
                    // Close all other dropdowns
                    $('.category-dropdown.clicked-open').each(function () {
                        $(this).removeClass('clicked-open');
                        closeMenu($(this));
                    });

                    $dropdown.addClass('clicked-open');
                    openMenu($dropdown);
                }
            });

            // Hover
            $(document).on('mouseenter', '.category-dropdown', function () {
                openMenu($(this));
            });

            // Leave
            $(document).on('mouseleave', '.category-dropdown', function () {
                // Don't close if it was opened by click
                if (!$(this).hasClass('clicked-open')) {
                    closeMenu($(this));
                }
            });

            // Outside click
            $(document).on('click', function () {
                $('.category-dropdown.clicked-open').each(function () {
                    $(this).removeClass('clicked-open');
                    closeMenu($(this));
                });
            });

            // Close when clicking outside
            $(document).on('click', function () {
                $('.category-dropdown').each(function () {
                    closeMenu($(this));
                });
            });

            // Prevent closing when clicking inside menu
            $(document).on('click', '.categoryDropdownMenu', function (e) {
                e.stopPropagation();
            });

            // Close on ESC
            $(document).on('keydown', function (e) {
                if (e.key === 'Escape') {
                    $('.category-dropdown').each(function () {
                        closeMenu($(this));
                    });
                }
            });

            function openMenu($dropdown) {
                const $menu = $dropdown.find('.categoryDropdownMenu');
                const $button = $dropdown.children('a');
                const $chevron = $dropdown.find('.categoryChevronIcon');

                $menu.removeClass('hidden');

                setTimeout(function () {
                    $menu.removeClass('opacity-0 -translate-y-2')
                        .addClass('opacity-100 translate-y-0');
                }, 10);

                $button.addClass('bg-navy-800 text-white shadow-md');
                $chevron.addClass('rotate-180');
            }

            function closeMenu($dropdown) {
                const $menu = $dropdown.find('.categoryDropdownMenu');
                const $button = $dropdown.children('a');
                const $chevron = $dropdown.find('.categoryChevronIcon');

                $menu.removeClass('opacity-100 translate-y-0')
                    .addClass('opacity-0 -translate-y-2');

                $button.removeClass('bg-navy-800 text-white shadow-md');
                $chevron.removeClass('rotate-180');

                setTimeout(function () {
                    $menu.addClass('hidden');
                }, 200);
            }

        });
    </script>
    <script src="/js/cart.js"></script>

    <!-- Wishlist Universal Handler -->
    <script>
        $(document).ready(function () {
            $(document).on('click', '.wishlist-toggle-btn', function (e) {
                e.preventDefault();
                var btn = $(this);
                var url = btn.data('url');
                var icon = btn.find('i');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            if (response.inWishlist) {
                                btn.removeClass('text-slate-400').addClass('text-rose-500');
                                icon.removeClass('fa-regular').addClass('fa-solid');
                            } else {
                                btn.removeClass('text-rose-500').addClass('text-slate-400');
                                icon.removeClass('fa-solid').addClass('fa-regular');
                            }

                            if (response.count !== undefined) {
                                var badge = $('.wishlist-badge');
                                badge.text(response.count);
                                if (response.count === 0) {
                                    badge.hide();
                                } else {
                                    badge.show();
                                }
                            }
                        }
                    },
                    error: function () {
                        alert('Something went wrong. Please try again.');
                    }
                });
            });
        });
    </script>

</body>

</html>