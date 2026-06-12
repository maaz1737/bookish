<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- SEO: dynamic per-page meta (Section 14) --}}
    <title>{{ $seo['title'] ?? 'Bookish | The Everyday Store' }}</title>
    <meta name="description"
        content="{{ $seo['description'] ?? 'School books, bundles, uniforms & accessories in Pakistan.' }}">
    <meta name="keywords" content="{{ $seo['keywords'] ?? 'school books Pakistan, book bundle, school uniforms' }}">
    {{-- OpenGraph for WhatsApp / Facebook previews --}}
    <meta property="og:title" content="{{ $seo['title'] ?? 'Bookish' }}">
    <meta property="og:description" content="{{ $seo['description'] ?? '' }}">
    <meta property="og:type" content="website">
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-20">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="text-3xl font-bold text-indigo-600">
                    Bookish
                </a>

                <!-- Navigation -->
                <div class="hidden md:flex items-center gap-8 font-medium">
                    <a href="{{ route('schools.index') }}" class="hover:text-indigo-600 transition">
                        Schools
                    </a>

                    <a href="{{ route('category.show', 'uniforms') }}" class="hover:text-indigo-600 transition">
                        Uniforms
                    </a>

                    <a href="{{ route('category.show', 'accessories') }}" class="hover:text-indigo-600 transition">
                        Accessories
                    </a>

                    <a href="{{ route('cart.index') }}" class="hover:text-indigo-600 transition">
                        Cart
                    </a>
                </div>

                <!-- Login -->
                <div>
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
                            Login
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-6xl mx-auto w-full px-4 py-8">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white mt-20">

        <div class="max-w-7xl mx-auto px-6 py-12">

            <div class="grid md:grid-cols-4 gap-8">

                <div>
                    <h3 class="text-2xl font-bold text-indigo-400">
                        Bookish
                    </h3>

                    <p class="mt-4 text-gray-400">
                        Your one-stop destination for school books,
                        uniforms and accessories.
                    </p>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>

                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('schools.index') }}">Schools</a></li>
                        <li><a href="{{ route('cart.index') }}">Cart</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Categories</h4>

                    <ul class="space-y-2 text-gray-400">
                        <li>Books</li>
                        <li>Uniforms</li>
                        <li>Accessories</li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Contact</h4>

                    <ul class="space-y-2 text-gray-400">
                        <li>support@bookish.pk</li>
                        <li>+92 300 1234567</li>
                        <li>Pakistan</li>
                    </ul>
                </div>

            </div>

            <div class="border-t border-gray-800 mt-10 pt-6 text-center text-gray-500">
                © {{ date('Y') }} Bookish. All Rights Reserved.
            </div>

        </div>

    </footer>
</body>

</html>
