<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- SEO: dynamic per-page meta (Section 14) --}}
    <title>{{ $seo['title'] ?? 'Bookish | The Everyday Store' }}</title>
    <meta name="description" content="{{ $seo['description'] ?? 'School books, bundles, uniforms & accessories in Pakistan.' }}">
    <meta name="keywords" content="{{ $seo['keywords'] ?? 'school books Pakistan, book bundle, school uniforms' }}">
    {{-- OpenGraph for WhatsApp / Facebook previews --}}
    <meta property="og:title" content="{{ $seo['title'] ?? 'Bookish' }}">
    <meta property="og:description" content="{{ $seo['description'] ?? '' }}">
    <meta property="og:type" content="website">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">
<nav class="bg-white shadow sticky top-0 z-10">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
        <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">Bookish</a>
        <div class="flex items-center gap-4 text-sm">
            <a href="{{ route('schools.index') }}" class="hover:text-indigo-600">Schools</a>
            <a href="{{ route('category.show', 'uniforms') }}" class="hover:text-indigo-600">Uniforms</a>
            <a href="{{ route('category.show', 'accessories') }}" class="hover:text-indigo-600">Accessories</a>
            <a href="{{ route('cart.index') }}" class="hover:text-indigo-600">Cart</a>
            @auth
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button class="text-gray-500">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-indigo-600">Login</a>
            @endauth
        </div>
    </div>
</nav>

<main class="max-w-6xl mx-auto px-4 py-8">
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif
    @yield('content')
</main>

<footer class="text-center text-gray-400 text-sm py-8">© {{ date('Y') }} Bookish — shopbookish.com</footer>
</body>
</html>
