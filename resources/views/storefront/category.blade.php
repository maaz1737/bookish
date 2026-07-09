@extends('layouts.app')

@section('content')

    @php
        $isSubcategoryPage = isset($subcategory) && $subcategory;
        $isParentPage = !$isSubcategoryPage && isset($category) && $category;
    @endphp

    {{-- ===== BREADCRUMB ===== --}}
    {{-- <nav class="text-xs text-slate-500 mb-6 flex items-center gap-2 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-[#001F54] transition-colors">Home</a>
        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
        <a href="{{ route('categories.index') }}" class="hover:text-[#001F54] transition-colors">Categories</a>
        @if ($isSubcategoryPage)
            @php $crumbParent = $subcategory->parent ?? null; @endphp
            @if ($crumbParent)
                <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                <a href="{{ route('category.show', $crumbParent->slug) }}" class="hover:text-[#001F54] transition-colors">{{ $crumbParent->name }}</a>
            @endif
            <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
            <span class="text-[#001F54] font-semibold">{{ $subcategory->name }}</span>
        @elseif ($isParentPage)
            <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
            <span class="text-[#001F54] font-semibold">{{ $category->name }}</span>
        @endif
    </nav> --}}

    {{-- ===== HERO HEADER ===== --}}
    <section
        class=" overflow-hidden mb-4">
        <div class="grid md:grid-cols-12 items-start gap-8 relative z-10">
            @php
                $heroImage = $isSubcategoryPage ? $subcategory->image ?? null : $category->image ?? null;
                $heroName = $isSubcategoryPage ? $subcategory->name : $category->name ?? 'Category';
                $heroDesc = $isSubcategoryPage ? $subcategory->description ?? '' : $category->description ?? '';
            @endphp

            <div class="md:col-span-7 flex flex-col justify-center">
                <nav class="text-xs text-slate-500 mb-6 flex items-center gap-2 flex-wrap">
                    <a href="{{ route('home') }}" class="hover:text-[#001F54] transition-colors">Home</a>
                    <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                    <a href="{{ route('categories.index') }}" class="hover:text-[#001F54] transition-colors">Categories</a>
                    @if ($isSubcategoryPage)
                        @php $crumbParent = $subcategory->parent ?? null; @endphp
                        @if ($crumbParent)
                            <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                            <a href="{{ route('category.show', $crumbParent->slug) }}"
                                class="hover:text-[#001F54] transition-colors">{{ $crumbParent->name }}</a>
                        @endif
                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                        <span class="text-[#001F54] font-semibold">{{ $subcategory->name }}</span>
                    @elseif ($isParentPage)
                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                        <span class="text-[#001F54] font-semibold">{{ $category->name }}</span>
                    @endif
                </nav>
                <h1 class="text-4xl md:text-5xl font-extrabold text-[#001F54] leading-tight tracking-tight">
                    {{ $heroName }}
                </h1>
                @if ($heroDesc)
                    <p class="text-slate-600 text-sm md:text-base mt-3 max-w-xl leading-relaxed">
                        {{ $heroDesc }}
                    </p>
                @endif

                {{-- Subcategory chips (parent page only) --}}
                {{-- @if ($isParentPage && $category->children->count())
                    <div class="flex flex-wrap gap-2 mt-6">
                        @foreach ($category->children as $child)
                            <a href="{{ route('category.show', $child->slug) }}"
                               class="inline-flex items-center gap-1.5 bg-[#001F54]/5 hover:bg-[#ff7a00] hover:text-white text-[#001F54] text-xs font-semibold px-4 py-2 rounded-full transition-all duration-200 border border-[#001F54]/10 hover:border-transparent">
                                {{ $child->name }}
                            </a>
                        @endforeach
                    </div>
                @endif --}}
            </div>

            @if ($heroImage)
                <div class="md:col-span-5 flex justify-center">
                    <img src="{{ url('storage/' . $heroImage) }}" alt="{{ $heroName }}"
                        class="max-h-56 md:max-h-64">
                </div>
            @endif
        </div>
        {{-- <div
            class="absolute -top-12 -right-12 w-64 h-64 bg-gradient-to-br from-[#001F54]/5 to-transparent rounded-full pointer-events-none">
        </div> --}}
    </section>

    {{-- =====================================================
         PARENT CATEGORY PAGE — subcategory sections with products
    ====================================================== --}}
    @if ($isParentPage)
        @php $hasAnyProduct = false; @endphp

        @if ($category->children->count())
            <div class="space-y-14">
                @foreach ($category->children as $sub)
                    @if ($sub->products->count())
                        @php $hasAnyProduct = true; @endphp
                        <section>
                            {{-- Section Heading --}}
                            <div
                                class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                                <h2 class="text-xl sm:text-2xl font-extrabold text-[#001F54] flex items-center gap-3">
                                    <span class="w-1 h-7 bg-[#ff7a00] rounded-full inline-block shrink-0"></span>
                                    {{ $sub->name }}
                                </h2>
                                <a href="{{ route('category.show', $sub->slug) }}"
                                    class="text-[#001F54] hover:text-[#ff7a00] font-bold text-sm flex items-center gap-1 transition-colors shrink-0">
                                    View All <i class="fa-solid fa-arrow-right text-xs"></i>
                                </a>
                            </div>

                            {{-- Product Grid --}}
                            <div class="grid-4">
                                @foreach ($sub->products as $product)
                                    @include('storefront.partials.product-card', ['product' => $product])
                                @endforeach
                            </div>
                        </section>
                    @endif
                @endforeach
            </div>
        @endif

        {{-- Direct products under parent --}}
        @if (isset($directProducts) && $directProducts->count())
            @php $hasAnyProduct = true; @endphp
            <section class="mt-14">
                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6 pb-3 border-b-2 border-slate-100">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-[#001F54] flex items-center gap-3">
                        <span class="w-1 h-7 bg-[#ff7a00] rounded-full inline-block shrink-0"></span>
                        All Products
                    </h2>
                </div>
                <div class="grid-4">
                    @foreach ($directProducts as $product)
                        @include('storefront.partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Empty State --}}
        @if (!$hasAnyProduct)
            <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-16 text-center">
                <div class="text-7xl mb-4 opacity-60">📦</div>
                <h2 class="text-2xl font-bold text-[#001F54] mb-2">No Products Yet</h2>
                <p class="text-slate-500 max-w-md mx-auto">Products for this category haven't been added yet. Please check
                    back soon.</p>
                <a href="{{ route('products.index') }}" class="bg-navy-800 mt-6 text-white rounded-xl px-4 py-2 inline-flex">Browse All Products</a>
            </div>
        @endif
    @endif

    {{-- =====================================================
         SUBCATEGORY PAGE — paginated product list
    ====================================================== --}}
    @if ($isSubcategoryPage)
        @if (isset($products) && $products->count())
            <div class="grid-4">
                @foreach ($products as $product)
                    @include('storefront.partials.product-card', ['product' => $product])
                @endforeach
            </div>
            @if ($products->hasPages())
                <div class="mt-12 flex justify-center">{{ $products->links() }}</div>
            @endif
        @else
            <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-16 text-center">
                <div class="text-7xl mb-4 opacity-60">📦</div>
                <h2 class="text-2xl font-bold text-[#001F54] mb-2">No Products Found</h2>
                <p class="text-slate-500 max-w-md mx-auto">No products have been added to this category yet. Please check
                    back later.</p>
                <a href="{{ route('products.index') }}" class="primary-btn mt-6 inline-flex">Browse All Products</a>
            </div>
        @endif
    @endif

    {{-- ===== TRUST STRIP ===== --}}
    <section
        class="bg-white rounded-[20px] shadow-[0_8px_24px_rgba(0,31,84,0.04)] border border-slate-100 p-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6 text-sm mt-14">
        <div class="flex gap-4 items-start p-2">
            <div class="w-12 h-12 shrink-0 bg-[#001F54]/5 rounded-xl flex items-center justify-center text-[#001F54]">
                <i class="fa-solid fa-shield-halved text-xl"></i>
            </div>
            <div>
                <b class="text-[#001F54] font-bold block text-sm">100% Original Products</b>
                <p class="text-xs text-slate-500 mt-1 leading-normal">Sourced from authorized suppliers</p>
            </div>
        </div>
        <div class="flex gap-4 items-start p-2">
            <div class="w-12 h-12 shrink-0 bg-[#001F54]/5 rounded-xl flex items-center justify-center text-[#001F54]">
                <i class="fa-solid fa-truck text-xl"></i>
            </div>
            <div>
                <b class="text-[#001F54] font-bold block text-sm">Fast &amp; Reliable Delivery</b>
                <p class="text-xs text-slate-500 mt-1 leading-normal">Across Pakistan</p>
            </div>
        </div>
        <div class="flex gap-4 items-start p-2">
            <div class="w-12 h-12 shrink-0 bg-[#001F54]/5 rounded-xl flex items-center justify-center text-[#001F54]">
                <i class="fa-solid fa-lock text-xl"></i>
            </div>
            <div>
                <b class="text-[#001F54] font-bold block text-sm">Secure Payments</b>
                <p class="text-xs text-slate-500 mt-1 leading-normal">Multiple payment options</p>
            </div>
        </div>
        <div class="flex gap-4 items-start p-2">
            <div class="w-12 h-12 shrink-0 bg-[#001F54]/5 rounded-xl flex items-center justify-center text-[#001F54]">
                <i class="fa-solid fa-rotate-left text-xl"></i>
            </div>
            <div>
                <b class="text-[#001F54] font-bold block text-sm">Easy Returns</b>
                <p class="text-xs text-slate-500 mt-1 leading-normal">Hassle-free returns within 7 days</p>
            </div>
        </div>
        <div class="flex gap-4 items-start p-2">
            <div class="w-12 h-12 shrink-0 bg-[#001F54]/5 rounded-xl flex items-center justify-center text-[#001F54]">
                <i class="fa-solid fa-headset text-xl"></i>
            </div>
            <div>
                <b class="text-[#001F54] font-bold block text-sm">Dedicated Support</b>
                <p class="text-xs text-slate-500 mt-1 leading-normal">We're here to help you anytime</p>
            </div>
        </div>
    </section>

@endsection
