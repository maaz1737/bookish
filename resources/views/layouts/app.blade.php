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

    <!-- Base Configuration Custom Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col antialiased">

    <!-- NAVIGATION HEADER -->
    <nav class="bg-white/90 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                <!-- Logo Area -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="block transform hover:scale-105 transition duration-200">
                        <img src="{{ asset(app()->environment('local') ? 'storage/logo/logo.png' : 'public/storage/logo/logo.png') }}"
                            alt="Bookish Logo" class="w-28 sm:w-32 h-auto object-contain">
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden md:flex items-center gap-8 text-sm font-semibold tracking-wide">
                    <a href="{{ route('home') }}"
                        class="{{ request()->routeIs('home') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }} transition-colors duration-200">
                        Home
                    </a>
                    <a href="{{ route('schools.index') }}"
                        class="{{ request()->routeIs('schools.*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }} transition-colors duration-200">
                        Schools
                    </a>
                    <a href="{{ route('category.show', 'books') }}"
                        class="text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                        Books
                    </a>
                    <a href="{{ route('category.show', 'uniforms') }}"
                        class="text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                        Uniforms
                    </a>
                    <a href="{{ route('category.show', 'accessories') }}"
                        class="text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                        Accessories
                    </a>
                    <a href="{{ Route::has('contact') ? route('contact') : '#contact' }}"
                        class="{{ request()->routeIs('contact') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }} transition-colors duration-200">
                        Contact
                    </a>
                </div>

                <!-- Action Button Area (Cart & Mobile Toggle) -->
                <div class="flex items-center gap-4">
                    <!-- Cart Button Desktop/Mobile -->
                    <a href="{{ route('cart.index') }}"
                        class="relative p-2.5 text-gray-600 hover:text-indigo-600 bg-gray-50 hover:bg-indigo-50 rounded-xl transition duration-200 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <!-- Dynamic indicator badge context example -->
                        <span
                            class="absolute top-1 right-1 w-2.5 h-2.5 bg-indigo-600 border-2 border-white rounded-full"></span>
                    </a>

                    <!-- Mobile Menu Button Burger Toggle -->
                    <button id="mobile-menu-btn" type="button"
                        class="md:hidden p-2.5 rounded-xl text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 focus:outline-none transition duration-200">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Dynamic Sidebar Drawer Content Layer -->
        <div id="mobile-menu"
            class="hidden md:hidden border-t border-gray-100 bg-white/95 backdrop-blur-md px-4 pt-2 pb-6 space-y-2 shadow-inner">
            <a href="{{ route('home') }}"
                class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Home</a>
            <a href="{{ route('schools.index') }}"
                class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Schools</a>
            <a href="{{ route('category.show', 'books') }}"
                class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Books</a>
            <a href="{{ route('category.show', 'uniforms') }}"
                class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Uniforms</a>
            <a href="{{ route('category.show', 'accessories') }}"
                class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Accessories</a>
            <a href="{{ Route::has('contact') ? route('contact') : '#contact' }}"
                class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Contact</a>
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

    <!-- PREMIUM CONTEXTUAL FOOTER SECTION -->
    <footer class="bg-gray-900 text-gray-300 border-t border-gray-800 mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10 lg:gap-12">
                <!-- Brand Profile info block -->
                <div class="space-y-4">
                    <h3
                        class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 tracking-tight">
                        Bookish.
                    </h3>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Pakistan's premium school resource marketplace. Ordering class-specific book sets, standard
                        tailored uniforms, and student kits made effortless.
                    </p>
                </div>

                <!-- Footer Quick Links -->
                <div>
                    <h4 class="font-bold text-white text-sm uppercase tracking-wider mb-5">Quick Links</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('home') }}"
                                class="hover:text-indigo-400 transition-colors duration-200 flex items-center gap-1">Home</a>
                        </li>
                        <li><a href="{{ route('schools.index') }}"
                                class="hover:text-indigo-400 transition-colors duration-200">Partner Schools</a></li>
                        <li><a href="{{ route('cart.index') }}"
                                class="hover:text-indigo-400 transition-colors duration-200">Shopping Cart</a></li>
                        <li><a href="{{ Route::has('contact') ? route('contact') : '#contact' }}"
                                class="hover:text-indigo-400 transition-colors duration-200">Get Help Support</a></li>
                    </ul>
                </div>

                <!-- Footer Category Index Navigation -->
                <div>
                    <h4 class="font-bold text-white text-sm uppercase tracking-wider mb-5">Categories</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('category.show', 'books') }}"
                                class="hover:text-indigo-400 transition-colors duration-200">Textbooks & Bundles</a>
                        </li>
                        <li><a href="{{ route('category.show', 'uniforms') }}"
                                class="hover:text-indigo-400 transition-colors duration-200">Campus Uniforms</a></li>
                        <li><a href="{{ route('category.show', 'accessories') }}"
                                class="hover:text-indigo-400 transition-colors duration-200">Stationery Kits</a></li>
                    </ul>
                </div>

                <!-- Contact details column panel -->
                <div>
                    <h4 class="font-bold text-white text-sm uppercase tracking-wider mb-5">Official Support</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-center gap-2">📧 <span>support@bookish.pk</span></li>
                        <li class="flex items-center gap-2">📞 <span>+92 320 4735908</span></li>
                        <li class="flex items-center gap-2">📍 <span>Lahore, Pakistan</span></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Intellectual property legal copyrights section line -->
            <div
                class="border-t border-gray-800/80 mt-16 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
                <p>© {{ date('Y') }} Bookish. Inc. All Rights Reserved.</p>
                <div class="flex items-center gap-4">
                    <span class="hover:text-gray-400 cursor-pointer">Privacy Policy</span>
                    <span>•</span>
                    <span class="hover:text-gray-400 cursor-pointer">Terms of Service</span>
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
