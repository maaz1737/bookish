@extends('layouts.app')

@section('content')

    {{-- Breadcrumb --}}
    <nav class="text-sm text-slate-500 mb-6 flex items-center gap-2">
        <a href="{{ url('/') }}" class="hover:text-navy-600 transition-colors">Home</a>
        <span class="text-navy-800">/</span>
        <span class="text-navy-800 font-medium">Trending Now</span>
    </nav>

    {{-- Page Title --}}
    <div class="mb-2">
        <div class="flex items-center gap-2 mb-1">
            <span class="text-2xl">🔥</span>
            <h1 class="text-2xl font-extrabold text-navy-800 tracking-tight">Trending Now</h1>
        </div>
        <p class="text-slate-500 text-sm ml-9">Explore high-quality school essentials, books, uniforms, bags, and baby wear.
        </p>
    </div>

    {{-- Count Row + Sort --}}
    <div class="flex items-center justify-between mt-6 mb-6">
        <p class="text-sm font-semibold text-slate-600">
            {{ $products->total() }} Popular Products
        </p>
        <form method="GET" action="{{ route('products.index') }}" id="sort-form">
            <div class="relative inline-flex items-center">
                <label class="text-sm text-slate-500 mr-2 font-medium whitespace-nowrap"></label>
                <select name="sort" id="sort-select"
                    onchange="document.getElementById('sort-form').submit()"
                    class="appearance-none bg-white border border-slate-200 text-sm text-slate-900 font-semibold rounded-xl px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-slate-900/20 cursor-pointer shadow-sm">
                    <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Sort by: Popularity</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A–Z</option>
                </select>
                <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </div>
            </div>
        </form>
    </div>

    {{-- Products Grid --}}
    @if ($products->count())
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
            @foreach ($products as $product)
                @include('storefront.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    @else
        {{-- Empty State --}}
        <div class="bg-white rounded-3xl p-12 text-center">
            <div class="text-6xl mb-5">📦</div>
            <h2 class="text-3xl font-bold mb-3">No Products Found</h2>
            <p class="text-gray-500 max-w-lg mx-auto">No products have been added yet. Please check back later.</p>
        </div>
    @endif

    {{-- Pagination --}}
    @if ($products->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @endif

@endsection
