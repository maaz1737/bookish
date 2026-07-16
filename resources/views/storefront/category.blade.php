@extends('layouts.app')

@section('content')

    {{-- ===================== BREADCRUMB ===================== --}}
    <nav aria-label="Breadcrumb" class="text-xs text-slate-500 mb-6 flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-[#001F54] transition-colors">Home</a>
        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
        <a href="{{ route('categories.index') }}" class="hover:text-[#001F54] transition-colors">Categories</a>

        @if($category->parent)
            <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
            <a href="{{ route('category.show', $category->parent->slug) }}"
               class="hover:text-[#001F54] transition-colors">{{ $category->parent->name }}</a>
            <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
            <span class="font-semibold text-[#001F54]">{{ $category->name }}</span>
        @else
            <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
            <span class="font-semibold text-[#001F54]">{{ $category->name }}</span>
        @endif
    </nav>

    {{-- ===================== PAGE HEADER ===================== --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-3">
        {{-- Left: Title + description --}}
        <div>
            <h1 class="flex items-center gap-2 text-2xl md:text-3xl font-extrabold text-[#001F54] leading-tight">
                <span class="w-1 h-8 bg-[#ff7a00] rounded-full inline-block shrink-0"></span>
                {{ $category->name }}
            </h1>
            @if($category->description)
                <p class="text-sm text-slate-500 mt-1.5 ml-4">{{ $category->description }}</p>
            @endif
        </div>

        {{-- Right: Sort Dropdown --}}
        @php
            $totalProductCount = 0;
            if ($category->children->count()) {
                foreach ($category->children as $sub) {
                    $totalProductCount += $sub->childProducts->count();
                }
            }
            $totalProductCount += $category->products->count();
            $totalProductCount += $category->childProducts->count();
        @endphp

        <div class="flex items-center gap-3 shrink-0">
            <form method="GET" action="{{ url()->current() }}" id="cat-sort-form" class="relative inline-flex items-center">
                <select name="sort" id="cat-sort-select"
                    onchange="document.getElementById('cat-sort-form').submit()"
                    class="appearance-none bg-white border border-slate-200 text-sm text-slate-800 font-semibold rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#001F54]/20 cursor-pointer shadow-sm min-w-[180px]">
                    <option value="latest"     {{ ($sort ?? 'latest') === 'latest'     ? 'selected' : '' }}>Sort by: Popularity</option>
                    <option value="price_asc"  {{ ($sort ?? '') === 'price_asc'        ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ ($sort ?? '') === 'price_desc'       ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name_asc"   {{ ($sort ?? '') === 'name_asc'         ? 'selected' : '' }}>Name: A – Z</option>
                </select>
                <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </div>
            </form>
        </div>
    </div>

    {{-- Product count row --}}
    <div class="flex items-center justify-between mb-6">
        {{-- @if($category->description)
            <p class="text-xs text-slate-500">{{ $category->description }}</p>
        @else
            <span></span>
        @endif --}}
        <span class="text-sm font-medium text-slate-500">{{ $totalProductCount }} Products</span>
    </div>

    {{-- ===================== CHILDREN SUBCATEGORY SECTIONS ===================== --}}
    @if ($category->children->count())
        <div class="space-y-14">
            @foreach ($category->children as $sub)
                @if ($sub->childProducts->count())
                    <section>
                        {{-- Sub-section Heading --}}
                        <div class="flex flex-row sm:items-center justify-between gap-2 mb-5">
                            <h2 class="flex items-center gap-2 text-xl md:text-2xl font-bold text-[#001F54]">
                                <span class="w-1 h-7 bg-[#ff7a00] rounded-full inline-block shrink-0"></span>
                                {{ $sub->name }}
                            </h2>
                            <a href="{{ route('category.show', $sub->slug) }}"
                               class="flex items-center gap-1 whitespace-nowrap text-sm font-semibold text-[#001F54] transition-colors hover:text-[#ff7a00]">
                                View All <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>

                        {{-- Product Grid --}}
                        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                            @foreach ($sub->childProducts as $product)
                                @include('storefront.partials.product-card', ['product' => $product])
                            @endforeach
                        </div>
                    </section>
                @endif
            @endforeach
        </div>
    @endif

    {{-- ===================== DIRECT PRODUCTS (if any) ===================== --}}
    @if ($category->products->count())
        <section id="products" class="{{ $category->children->count() ? 'mt-14' : '' }}">
            @if ($category->children->count())
                <div class="mb-5 pb-1 border-b-2 border-slate-100">
                    <h2 class="flex items-center gap-2 text-xl md:text-2xl font-bold text-[#001F54]">
                        <span class="w-1 h-7 bg-[#ff7a00] rounded-full inline-block shrink-0"></span>
                        All Products
                    </h2>
                </div>
            @endif
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                @foreach ($category->products as $product)
                    @include('storefront.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </section>
    @endif

    {{-- ===================== CHILD PRODUCTS (leaf category) ===================== --}}
    @if ($category->childProducts->count())
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6 {{ ($category->children->count() || $category->products->count()) ? 'mt-14' : '' }}">
            @foreach ($category->childProducts as $product)
                @include('storefront.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    @endif

    {{-- ===================== EMPTY STATE ===================== --}}
    @if (!$category->children->count() && !$category->products->count() && !$category->childProducts->count())
        <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-16 text-center" id="products">
            <div class="text-7xl mb-4 opacity-60">📦</div>
            <h2 class="text-2xl font-bold text-[#001F54] mb-2">No Products Found</h2>
            <p class="text-slate-500 max-w-md mx-auto">
                No products have been added to this category yet. Please check back later.
            </p>
            <div class="mt-4">
                <a href="{{ route('products.index') }}" class="primary-btn px-3">Browse All Products</a>
            </div>
        </div>
    @endif

    {{-- ===================== TRUST SECTION ===================== --}}
    @include('partials.trust-section')

@endsection