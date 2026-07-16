@extends('layouts.app')

@section('content')

    {{-- ===================== BREADCRUMB ===================== --}}
    <nav aria-label="Breadcrumb" class="text-xs text-slate-500 mb-6 flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-[#001F54] transition-colors">Home</a>
        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
        <a href="{{ route('categories.index') }}" class="hover:text-[#001F54] transition-colors">Categories</a>
        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
        <span class="font-semibold text-[#001F54]">All Categories</span>
    </nav>

    {{-- ===================== PAGE HEADER ===================== --}}
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-[#001F54] mb-2">
            All Categories
        </h1>
        <p class="text-slate-500 text-sm max-w-3xl leading-relaxed">
            Browse school essentials, bags, bottles, uniforms, books and everyday picks for students and families.
        </p>
    </div>

    {{-- ===================== SECTIONS LIST ===================== --}}
    <div class="space-y-14 mb-14">
        {{-- Loop through only Parent Categories --}}
        @foreach ($parentCategories as $parent)
            @php
                // Collect direct products and products from subcategories
                $parentProducts = collect();
                
                // Add direct products of parent category
                if ($parent->products) {
                    $parentProducts = $parentProducts->merge($parent->products);
                }
                
                // Add products from subcategories (children)
                if ($parent->children) {
                    foreach ($parent->children as $child) {
                        if ($child->childProducts) {
                            $parentProducts = $parentProducts->merge($child->childProducts);
                        }
                    }
                }
                
                // Keep unique products and get the first 3
                $parentProducts = $parentProducts->unique('id')->take(3);
            @endphp

            @if ($parentProducts->isNotEmpty())
                <section>
                    {{-- Heading Row --}}
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-5">
                        <h2 class="flex items-center gap-2 text-xl md:text-2xl font-bold text-[#001F54]">
                            <span class="w-1 h-7 bg-[#ff7a00] rounded-full inline-block shrink-0"></span>
                            {{ $parent->name }}
                        </h2>
                        <a href="{{ route('category.show', $parent->slug) }}"
                           class="flex items-center gap-1 text-sm font-semibold text-[#001F54] hover:text-[#ff7a00] transition-colors">
                            View All <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                    {{-- Product Grid --}}
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                        @foreach ($parentProducts as $product)
                            @include('storefront.partials.product-card', ['product' => $product])
                        @endforeach
                    </div>
                </section>
            @endif
        @endforeach

        {{-- All Products Section --}}
        @if ($allProducts->isNotEmpty())
            <section>
                {{-- Heading Row --}}
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-5">
                    <h2 class="flex items-center gap-2 text-xl md:text-2xl font-bold text-[#001F54]">
                        <span class="w-1 h-7 bg-[#ff7a00] rounded-full inline-block shrink-0"></span>
                        All Products
                    </h2>
                    <a href="{{ route('products.index') }}"
                       class="flex items-center gap-1 text-sm font-semibold text-[#001F54] hover:text-[#ff7a00] transition-colors">
                        View All <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                {{-- Product Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                    @foreach ($allProducts as $product)
                        @include('storefront.partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    {{-- ===================== TRUST SECTION ===================== --}}
    @include('partials.trust-section')

@endsection