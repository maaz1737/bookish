<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- SEO: dynamic per-page meta --}}
    <title>{{ $seo['title'] ?? 'Bookish | The Everyday Store' }}</title>
    <meta name="description"
        content="{{ $seo['description'] ?? 'School books, bundles, uniforms & accessories in Pakistan.' }}">
    <meta name="keywords" content="{{ $seo['keywords'] ?? 'school books Pakistan, book bundle, school uniforms' }}">
    {{-- OpenGraph for WhatsApp / Facebook previews --}}
    <meta property="og:title" content="{{ $seo['title'] ?? 'Bookish' }}">
    <meta property="og:description" content="{{ $seo['description'] ?? '' }}">
    <meta property="og:type" content="website">

    <!-- Tailwind CSS & jQuery -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- swiper cdns  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col antialiased">
    <header class="border-b border-gray-200 bg-white">

        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center gap-14">

            <div>
                <h1 class="text-2xl font-extrabold text-blue-900">
                    Bookish <span class="italic text-yellow-500">& Beyond</span>
                </h1>
                <p class="text-xs text-gray-500">
                    School Essentials, Baby Wear & Gifts
                </p>
            </div>

            <div class="hidden md:block flex-1">
                <div class="relative">

                    <input type="text" placeholder="Search books, uniforms, bags..."
                        class="w-full border rounded-lg px-4 py-3">

                    <button
                        class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-900 text-white px-3 py-2 rounded-lg">
                        🔍
                    </button>

                </div>
            </div>

            <div class="flex items-center">

                {{-- <a href="#" class="flex flex-col items-center text-navy text-xs font-medium hidden sm:flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-0.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A7 7 0 0112 15a7 7 0 016.879 2.804M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z">
                        </path>
                    </svg>
                    Login / Register
                </a> --}}

                <a href="{{ route('cart.index') }}" class="relative flex flex-col items-center  text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-0.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M7 13L5.4 5M10 21a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z">
                        </path>
                    </svg>
                    Cart
                    <span
                        class="absolute -top-1 -right-2 bg-gold text-navy text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center bg-yellow-500">0</span>
                </a>

            </div>

        </div>

    </header>

    <!-- NAVIGATION -->

    <nav class="border-b bg-white">

        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center gap-6">

            <button class="bg-blue-900 text-white px-5 py-3 rounded-lg font-medium shrink-0">
                ☰ Shop By Category
            </button>

            <ul class="hidden lg:flex flex-1 justify-between gap-8 font-medium">

                <li>
                    <a href="{{ route('schools.index') }}" class="hover:text-blue-900 font-bold">
                        Schools
                    </a>
                </li>

                <li>
                    <a href="{{ route('category.show', 'books') }}" class="hover:text-blue-900 font-bold">
                        Books
                    </a>
                </li>

                <li>
                    <a href="{{ route('category.show', 'uniforms') }}" class="hover:text-blue-900 font-bold">
                        Uniforms
                    </a>
                </li>

                <li>
                    <a href="{{ route('category.show', 'uniforms') }}" class="hover:text-blue-900 font-bold">
                        Bags & Bottles
                    </a>
                </li>

                <li>
                    <a href="{{ route('category.show', 'uniforms') }}" class="hover:text-blue-900 font-bold">
                        Baby Wear
                    </a>
                </li>
                <li>
                    <a href="{{ route('category.show', 'uniforms') }}" class="hover:text-blue-900 font-bold">
                        Gifts
                    </a>
                </li>

                <li>
                    <a href="{{ route('category.show', 'accessories') }}" class="hover:text-blue-900 font-bold">
                        Accessories
                    </a>
                </li>

            </ul>

            <button class="bg-yellow-400 text-blue-900 px-5 py-3 rounded-lg font-semibold shrink-0">
                🎁 Offers
            </button>

        </div>

    </nav>


    <!-- FLASH NOTIFICATION TOASTERS SYSTEM -->
    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-4">
        @if (session('success'))
            <div
                class="alert-box flex items-center justify-between p-4 mb-4 text-emerald-800 bg-emerald-50 border border-emerald-200/60 rounded-2xl shadow-sm transition duration-300">
                <div class="flex items-center gap-2 text-sm font-semibold">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()"
                    class="text-emerald-500 hover:text-emerald-800 text-xs font-bold px-2">Dismiss</button>
            </div>
        @endif

        @if (session('error'))
            <div
                class="alert-box flex items-center justify-between p-4 mb-4 text-red-800 bg-red-50 border border-red-200/60 rounded-2xl shadow-sm transition duration-300">
                <div class="flex items-center gap-2 text-sm font-semibold">
                    <span>⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()"
                    class="text-red-500 hover:text-red-800 text-xs font-bold px-2">Dismiss</button>
            </div>
        @endif
    </div>

    <!-- MAIN VIEW CONTAINER CONTENT -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <footer class="bg-blue-900 text-white mt-20">

        <div class="max-w-7xl mx-auto px-4 py-12 grid md:grid-cols-5 gap-10">

            <div class="md:col-span-2">

                <h3 class="text-3xl font-bold">
                    Bookish
                    <span class="italic text-yellow-400">
                        & Beyond
                    </span>
                </h3>

                <p class="mt-4 text-gray-300">
                    Your one-stop destination for school books,
                    uniforms and accessories.
                </p>

            </div>

            <div>

                <h4 class="font-bold mb-4">
                    Quick Links
                </h4>

                <ul class="space-y-2 text-gray-300">

                    <li>Home</li>
                    <li>Schools</li>
                    <li>Categories</li>
                    <li>Contact Us</li>

                </ul>

            </div>

            <div>

                <h4 class="font-bold mb-4">
                    Categories
                </h4>

                <ul class="space-y-2 text-gray-300">

                    <li>Books</li>
                    <li>Uniforms</li>
                    <li>Accessories</li>

                </ul>

            </div>

            <div>

                <h4 class="font-bold mb-4">
                    Contact Us
                </h4>

                <ul class="space-y-3 text-gray-300">

                    <li>📞 +92 300 1234567</li>
                    <li>✉️ support@bookish.pk</li>
                    <li>📍 Lahore, Pakistan</li>

                </ul>

            </div>

        </div>

        <div class="border-t border-white/10">

            <div class="max-w-7xl mx-auto px-4 py-5 flex justify-between items-center text-sm text-gray-400">

                <p>
                    © {{ date('Y') }} Bookish & Beyond. All Rights Reserved.
                </p>

                <div class="flex gap-3">

                    <span class="bg-white text-blue-900 px-2 py-1 rounded">
                        VISA
                    </span>

                    <span class="bg-white text-red-600 px-2 py-1 rounded">
                        Mastercard
                    </span>

                    <span class="bg-white text-green-600 px-2 py-1 rounded">
                        Easypaisa
                    </span>

                </div>

            </div>

        </div>

    </footer>
    <!-- Toggle Script Engine Module for Navigation Actions -->
    <script>
        $(document).ready(function() {
            // Mobile navigation menu trigger function toggler
            $('#mobile-menu-btn').on('click', function() {
                $('#mobile-menu').toggleClass('hidden');
            });
        });
    </script>
</body>

</html>
