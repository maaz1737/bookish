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
            border-radius: 8px;
            font-size: 16px;
            border: none;
            font-weight: 500;
            padding: 8px 0px;
            transition: all 0.2s ease;
            cursor: pointer;
            text-align: center;
            width: 100%;
        }

        .primary-btn:hover {
            background: #000654;
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
            box-shadow:
                0 -1px 4px rgb(186, 66, 255),
                0 1px 4px rgb(0, 225, 255);
            display: grid;
            place-items: center;
            animation: spinning82341 1.2s linear infinite;
            transform-origin: 50% 50%;
            /* vertical-align: middle; */
            /* spin around its own center */
            will-change: transform;
        }

        .spinner1 {
            width: 14px;
            height: 14px;
            background: white;
            /* match parent bg for the "ring" illusion */
            border-radius: 50%;
        }

        @keyframes spinning82341 {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
    <style>
        .product-card {
            /* min-width: 380px; */
            width: 100%;
            border: 1px solid #f0f0f0;
            border-radius: 8px;
            overflow: hidden;
        }

        .product-card:hover {
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
        }

        .image-container {
            /* aspect-ratio: 4/ 3;
        width: 100%;
        overflow: hidden;
        background: #f4f4f5; */
            width: 100%;
            background-position: center !important;
            background-repeat: no-repeat !important;
            background-size: cover !important;
            aspect-ratio: 19 / 13 !important;

        }

        /* .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;

    } */

        .product-info {
            color: navy;
            padding: 11px 10px;
            font-weight: 600;
            font-size: 20px;

        }

        .amount {
            display: flex;
            gap: 12px;
            padding: 3px 0px 10px 0px;
            align-items: end;
            font-weight: 600;
            font-size: 18px
        }

        .prev-amount {
            font-size: 14px;
            font-weight: 500;
            text-decoration: line-through;
            color: gray;
            padding-bottom: 2px;
        }

        .filter-card:hover .filter-name {
            color: rgb(12, 12, 204);
            text-decoration: underline;
        }

        .school-card:hover {
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">


    {{-- ===== TOP UTILITY BAR ===== --}}
    <div class="bg-navy-800 text-white text-xs hidden md:block">
        <div class="max-w-7xl mx-auto px-4 py-2 flex flex-wrap items-center justify-between gap-2">
            <span><i class="fa-solid fa-truck-fast text-gold-400 mr-2"></i>Free Delivery on Orders Above PKR 3000</span>
            <span class="hidden md:inline"><i class="fa-solid fa-shield-halved text-gold-400 mr-2"></i>100% Original
                Products</span>
            <span><i class="fa-solid fa-phone text-gold-400 mr-2"></i>Customer Support 0320-4735908</span>
        </div>
    </div>
    <marquee class="bg-navy-800 text-white text-xs block md:hidden"">
        <div class=" max-w-7xl mx-auto px-4 py-2 flex items-center justify-between gap-8">
            <span><i class="fa-solid fa-truck-fast text-gold-400 mr-2"></i>Free Delivery on Orders Above PKR 3000</span>
            <span class="hidden md:inline"><i class="fa-solid fa-shield-halved text-gold-400 mr-2"></i>100% Original
                Products</span>
            <span><i class="fa-solid fa-phone text-gold-400 mr-2"></i>Customer Support : 0321 1234567</span>
        </div>
    </marquee>

    {{-- ===== HEADER ===== --}}
    <header class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 flex items-center gap-2 xs:gap-6  justify-between">
            <a href="{{ url('/') }}" class="shrink-0">
                {{-- <h1 class="text-xl sm:text-2xl font-extrabold text-navy-800">Bookish <span class="text-gold-500">&
                        Beyond</span>
                </h1>
                <p class="text-[12px] sm:text-xs text-slate-500">School Essentials<span class="hidden sm:inline">,
                        Baby
                        Wear & Gifts</span> </p> --}}
                <div class="w-24 h-24 bg-contain bg-center bg-no-repeat"
                    style="background-image: url('{{ asset('images/bookish_logo.jpg') }}');">
                </div>
            </a>

            <form action="#" class="w-2/3 hidden lg:flex border border-slate-300 rounded-lg overflow-hidden">
                <input type="text" placeholder="Search books, uniforms, bags, accessories..."
                    class="filter-search flex-1 px-4 py-2 text-sm outline-none">
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
                {{-- <a href="#" class="hidden sm:flex flex-col items-center text-xs">
                    <i class="fa-regular fa-user text-lg"></i>
                    <span class="hidden lg:inline">Login / Register</span>
                </a> --}}
                <a href="{{ route('wishlist.index') }}" class="relative flex flex-col items-center text-xs"><i
                        class="fa-regular fa-heart text-lg"></i>
                    <span class="hidden lg:inline">Wishlist</span>
                    <span
                        class="absolute -top-1 right-2 bg-gold-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center wishlist-badge"
                        style="{{ $wishlistCount == 0 ? 'display: none;' : '' }}">{{ $wishlistCount }}</span></a>

                {{-- {{ route('cart.index') }} --}}
                <a href="#" class="cart relative flex flex-col items-center text-xs"><i
                        class="fa-solid fa-cart-shopping text-lg"></i>
                    <span class="hidden lg:inline">Cart</span>
                    <span
                        class="absolute -top-1 right-2 bg-gold-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center"
                        id="cart_count">0</span></a>
                <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-md text-slate-700 hover:bg-slate-100"
                    aria-label="Open menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- nav --}}
        <nav class="max-w-7xl hidden  mx-auto px-4 lg:flex items-center gap-2 relative pb-2">
            {{-- Rest of the Nav Links --}}
            <div class="category-dropdown relative">
                <a href="#"
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

                                                @if ($school->logo)
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

                                @if ($mainSchools->count())
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

                    @if (count($mainCategory->children) > 0)
                        <div
                            class="categoryDropdownMenu absolute left-0 w-64 hidden opacity-0 transition-all duration-200 -translate-y-2 z-[99]">

                            <div class="bg-white rounded-xl shadow-xl border border-slate-200/80 mt-2">
                                @forelse ($mainCategory->children as $category)
                                    <a href="{{ route('category.show', $category->slug) }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-blue-900 hover:bg-slate-50 transition border-b border-slate-50 last:border-0">

                                        <span
                                            class="w-8 h-8 shrink-0 rounded-full overflow-hidden bg-slate-50 flex items-center justify-center border border-slate-100">
                                            @if ($category->image)
                                                <img src="{{ asset('storage/' . $category->image) }}"
                                                    alt="{{ $category->name }}" class="w-full h-full object-cover"
                                                    loading="lazy">
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
    <!-- Overlay -->
    <div id="mobileOverlay" class="fixed inset-0 bg-black/50 hidden z-[998] lg:hidden">
    </div>

    <!-- Sidebar -->
    <div id="mobileSidebar"
        class="fixed top-0 right-0 h-screen w-[320px] max-w-[90vw] bg-white shadow-2xl z-[999]
    translate-x-full transition-transform duration-300 lg:hidden flex flex-col">

        <!-- Header -->
        <div class="flex items-center justify-between p-5 border-b">

            <h2 class="font-bold text-xl text-[#001F54]">
                Bookish
            </h2>

            <button id="closeMobileMenu">
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>

        </div>

        <!-- Menu -->
        <div class="overflow-y-auto flex-1">

            <!-- Schools -->

            <div class="border-b">

                <button class="mobileDropdownBtn w-full flex justify-between items-center px-5 py-4 font-semibold">

                    <span>
                        <i class="fa-solid fa-school mr-2"></i>
                        Shop by School
                    </span>

                    <i class="fa-solid fa-chevron-down duration-300"></i>

                </button>

                <div class="mobileDropdown hidden">

                    @foreach ($mainSchools as $school)
                        <a href="{{ route('schools.show', $school->slug) }}"
                            class="flex items-center gap-3 px-8 py-3 hover:bg-slate-50">

                            @if ($school->logo)
                                <img src="{{ asset('storage/' . $school->logo) }}"
                                    class="w-9 h-9 rounded-full object-cover">
                            @else
                                <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center">

                                    <i class="fa-solid fa-school"></i>

                                </div>
                            @endif

                            {{ $school->name }}

                        </a>
                    @endforeach

                    <a href="{{ route('schools.index') }}" class="block px-8 py-3 font-semibold text-blue-700">

                        View All Schools →

                    </a>

                </div>

            </div>

            <!-- Categories -->

            @foreach ($mainCategories as $mainCategory)
                <div class="border-b">

                    <button class="mobileDropdownBtn w-full flex justify-between items-center px-5 py-4">

                        <span>

                            {{ ucfirst($mainCategory->name) }}

                        </span>

                        @if ($mainCategory->children->count())
                            <i class="fa-solid fa-chevron-down duration-300"></i>
                        @endif

                    </button>

                    @if ($mainCategory->children->count())
                        <div class="mobileDropdown hidden">

                            @foreach ($mainCategory->children as $category)
                                <a href="{{ route('category.show', $category->slug) }}"
                                    class="block px-8 py-3 hover:bg-slate-50">

                                    {{ ucfirst($category->name) }}

                                </a>

                                @foreach ($category->allChildren as $child)
                                    @include('admin.categories.link_category', ['cat' => $child])
                                @endforeach
                            @endforeach

                            <a href="{{ route('category.show', $mainCategory->slug) }}"
                                class="block px-8 py-3 font-semibold text-blue-700">

                                View All

                            </a>

                        </div>
                    @endif

                </div>
            @endforeach

            <!-- Offers -->

            <a href="#" class="block m-5 rounded-lg bg-orange-500 text-white text-center py-3 font-semibold">

                Offers

            </a>

        </div>

    </div>
    {{-- ===== FLASH MESSAGES ===== --}}
    @if (session('success'))
        <div
            class="max-w-7xl mx-auto w-full px-4 mt-4 bg-green-50 border border-green-200 text-green-800 rounded-md p-3 text-sm">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div
            class="max-w-7xl mx-auto w-full px-4 mt-4 bg-red-50 border border-red-200 text-red-800 rounded-md p-3 text-sm">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    {{-- ===== MAIN ===== --}}
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 py-3  md:py-8">
        @yield('content')
    </main>


    <!-- Overlay -->
    <div id="cartOverlay" class="fixed inset-0 bg-black/40 hidden z-[99999]">
    </div>

    <!-- Cart Sidebar -->
    {{-- <div id="cartDrawer"
        class="fixed top-0 right-0 h-screen w-full md:w-[380px] bg-white shadow-xl
           translate-x-full transition-transform duration-300 ease-in-out
           z-[999999]">

        <div class="flex flex-col h-full bg-white">

            <div class="flex items-center justify-between px-4 py-3 border-b">
                <h2 class="text-[15px] font-semibold text-gray-800">
                    Review Your Cart (<span id="review_cart">{{ count($carts['items']) }}</span>)
                </h2>
                <button id="closeCart" class="text-gray-500 text-xl leading-none">
                    ×
                </button>
            </div>

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
                        class="w-full h-11 rounded-xl bg-[#163A6B] hover:bg-[#102F59] text-white text-sm font-semibold flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[#163A6B]/30">
                        🛒 Checkout
                    </a>
                </div>
                <div class="px-3 pb-3">
                    <a href="{{ route('cart.index') }}"
                        class="w-full h-11 rounded-xl bg-white hover:bg-gray-50 border border-[#163A6B] text-[#163A6B] text-sm font-semibold flex items-center justify-center gap-2 shadow-sm hover:shadow-md transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[#163A6B]/30">
                        🛒 Add to Cart
                    </a>
                </div> 
                <div class="grid grid-cols-2 gap-3 px-3 pb-3 md:flex md:flex-col md:gap-2">

                    <a href="{{ route('cart.index') }}"
                        class="w-full h-11 rounded-xl bg-white hover:bg-gray-50 border border-[#163A6B] text-[#163A6B] text-sm font-semibold flex items-center justify-center gap-2 shadow-sm hover:shadow-md transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[#163A6B]/30 order-1 md:order-2">
                        🛒 Add to Cart
                    </a>

                    <a href="{{ url('/checkout') }}"
                        class="w-full h-11 rounded-xl bg-[#163A6B] hover:bg-[#102F59] text-white text-sm font-semibold flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[#163A6B]/30 order-2 md:order-1">
                        💳 Checkout
                    </a>

                </div>

            </div>

        </div>
    </div> --}}

    <div id="cartDrawer"
        class="fixed top-0 right-0 min-h-screen h-full w-full md:w-[380px] bg-white shadow-xl
           translate-x-full transition-transform duration-300 ease-in-out
           z-[999999] overflow-y-auto">

        <div class="flex flex-col h-auto min-h-full bg-white">

            <div class="flex items-center justify-between px-4 py-3 border-b shrink-0">
                <h2 class="text-[15px] font-semibold text-gray-800">
                    Review Your Cart (<span id="review_cart">{{ count($carts['items']) }}</span>)
                </h2>
                <button id="closeCart" class="text-gray-500 text-xl leading-none px-2 py-1">
                    ×
                </button>
            </div>

            <div class="flex-1">
                <div class="px-3 py-3" id="cart-container">
                    {{-- Cart Items --}}
                </div>
            </div>

            <div class="border-t bg-white mt-auto">

                <button class="w-full flex items-center justify-between px-4 py-3 text-[13px] text-gray-700">
                    <span>Got a discount code?</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div class="border-t"></div>

                <div class="px-4 py-3 flex justify-between items-start">
                    <div>
                        <p class="font-semibold text-[13px]">Subtotal</p>
                        <p class="text-[10px] text-gray-500 mt-1">Shipping &amp; taxes may be re-calculated at checkout
                        </p>
                    </div>

                    <div class="flex items-center gap-1">
                        <span class="text-[11px] font-semibold text-slate-500 tracking-wider">PKR</span>

                        <p class="text-sm font-semibold text-[#0a1f44]" id="cart_total">
                            {{ number_format($carts['total']) }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 px-3 pb-3 md:flex md:flex-col md:gap-2">
                    {{-- Add to Cart Button --}}
                    <a href="/"
                        class="w-full h-11 rounded-xl bg-white hover:bg-gray-50 border border-[#163A6B] text-[#163A6B] text-sm font-semibold flex items-center justify-center gap-2 shadow-sm hover:shadow-md transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[#163A6B]/30 order-1 md:order-2">
                        🛒 Continue Shoping
                    </a>

                    {{-- Checkout Button --}}
                    <a href="{{ url('/checkout') }}"
                        class="w-full h-11 rounded-xl bg-[#163A6B] hover:bg-[#102F59] text-white text-sm font-semibold flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[#163A6B]/30 order-2 md:order-1">
                        💳 Checkout
                    </a>
                </div>

            </div>

        </div>
    </div>


    {{-- ===== FOOTER ===== --}}
    <footer class="bg-navy-900 text-slate-300 mt-2 md:mt-6">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10">

                <!-- Company -->
                <div class="sm:col-span-2">

                    <div>
                        <div class="w-24 h-24 bg-contain bg-center bg-no-repeat"
                    style="background-image: url('{{ asset('images/bookish_logo3.jpg') }}');">
                </div>
                    </div>

                    <p class="mt-4 text-slate-400 leading-7 max-w-md">
                        School essentials, baby wear & gifts. We provide quality books,
                        uniforms, school accessories, baby wear, gifts and much more.
                    </p>

                    <div class="flex flex-wrap gap-3 mt-6">

                        <a href="#"
                            class="w-10 h-10 rounded-full bg-navy-800 hover:bg-gold-500 transition flex items-center justify-center">

                            <i class="fa-brands fa-facebook-f"></i>

                        </a>

                        <a href="#"
                            class="w-10 h-10 rounded-full bg-navy-800 hover:bg-gold-500 transition flex items-center justify-center">

                            <i class="fa-brands fa-instagram"></i>

                        </a>

                        <a href="#"
                            class="w-10 h-10 rounded-full bg-navy-800 hover:bg-gold-500 transition flex items-center justify-center">

                            <i class="fa-brands fa-whatsapp"></i>

                        </a>

                        <a href="#"
                            class="w-10 h-10 rounded-full bg-navy-800 hover:bg-gold-500 transition flex items-center justify-center">

                            <i class="fa-brands fa-youtube"></i>

                        </a>

                    </div>

                </div>

                <!-- Quick Links -->
                <div>

                    <h4 class="text-white font-semibold text-lg mb-4">
                        Quick Links
                    </h4>

                    <ul class="space-y-3">

                        <li>
                            <a href="{{ route('about') }}" class="hover:text-gold-500 transition">
                                About Us
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('returns-refunds') }}" class="hover:text-gold-500 transition">
                                Returns & Refunds
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('contact') }}" class="hover:text-gold-500 transition">
                                Contact Us
                            </a>
                        </li>

                    </ul>

                </div>

                <!-- Shop -->
                <div>

                    <h4 class="text-white font-semibold text-lg mb-4">
                        Shop
                    </h4>

                    <ul class="space-y-3">

                 @foreach ($mainCategories as $mainCategory)
    <li>
        <a href="{{ route('category.show', $mainCategory->slug) }}"
            class="hover:text-gold-500">
            {{ ucfirst($mainCategory->name) }}
        </a>
    </li>

    @if ($mainCategory->children->count())
        @foreach ($mainCategory->children as $category)
            <li>
                <a href="{{ route('category.show', $category->slug) }}"
                    class="hover:text-gold-500">
                    {{ ucfirst($category->name) }}
                </a>
            </li>
        @endforeach
    @endif
@endforeach

                    </ul>

                </div>

                <!-- Contact -->
                <div>

                    <h4 class="text-white font-semibold text-lg mb-4">
                        Customer Service
                    </h4>

                    <ul class="space-y-4 text-sm">

                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-phone text-gold-400 mt-1"></i>
                            <span>+92 320 4735908</span>
                        </li>

                        <li class="flex items-start gap-3 break-all">
                            <i class="fa-solid fa-envelope text-gold-400 mt-1"></i>
                            <span>bookishsupport@gmail.com</span>
                        </li>

                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot text-gold-400 mt-1"></i>
                            <span>Lahore, Pakistan</span>
                        </li>

                        <li class="flex items-start gap-3">
                            <i class="fa-regular fa-clock text-gold-400 mt-1"></i>
                            <span>Mon – Sat (10:00 AM – 8:00 PM)</span>
                        </li>

                    </ul>

                </div>

            </div>

        </div>

        <div class="border-t border-navy-800">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">

                <p class="text-center text-xs sm:text-sm text-slate-400">
                    © {{ date('Y') }} Bookish & Beyond. All Rights Reserved.
                </p>

            </div>

        </div>

    </footer>


    <script src="/js/category-dropdown.js" defer></script>
    <script src="/js/cart.js" defer></script>


    <!-- Wishlist Universal Handler -->
    <script>
        $(document).ready(function() {
            $(document).on('click', '.wishlist-toggle-btn', function(e) {
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
                    success: function(response) {
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
                    error: function() {
                        alert('Something went wrong. Please try again.');
                    }
                });
            });
        });
    </script>
    <script>
        $(function() {

            // Open Sidebar

            $("#mobile-menu-btn").click(function() {

                $("#mobileOverlay").fadeIn(200);

                $("#mobileSidebar").removeClass("translate-x-full");

                $("body").css("overflow", "hidden");

            });

            // Close Sidebar

            $("#closeMobileMenu,#mobileOverlay").click(function() {

                $("#mobileOverlay").fadeOut(200);

                $("#mobileSidebar").addClass("translate-x-full");

                $("body").css("overflow", "");

            });

            // Accordion

            $(".mobileDropdownBtn").click(function() {

                let dropdown = $(this).next(".mobileDropdown");

                if (!dropdown.length)
                    return;

                dropdown.stop(true, true).slideToggle(250);

                $(this)
                    .find(".fa-chevron-down")
                    .toggleClass("rotate-180");

            });

        });

        $(".filter-search").change(function() {
            let inputVal = $(this).val();
        })
    </script>
    <script>
        // $(".filter-search").on("input", function () {
        //     let inputVal = $(this).val().toLowerCase();

        //     $(".filter-card").each(function () {
        //         let productName = $(this).find(".filter-name").text().toLowerCase();
        //         $(this).toggle(productName.includes(inputVal));
        //     });
        // });
    </script>


    <script>
        $(".filter-search").on("input", function() {
            let keyword = $(this).val().trim().toLowerCase();

            $(".filter-container").each(function() {
                let visibleCards = 0;

                $(this).find(".filter-card").each(function() {
                    let name = $(this).find(".filter-name").text().trim().toLowerCase();
                    let matched = name.includes(keyword);

                    $(this).toggle(matched);

                    if (matched) {
                        visibleCards++;
                    }
                });

                $(this).toggle(visibleCards > 0);
            });
        });
    </script>
</body>

</html>
