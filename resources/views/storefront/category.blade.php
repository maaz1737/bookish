@extends('layouts.app')

@section('content')

    @php
        $isSubcategoryPage = isset($subcategory) && $subcategory;
        $isParentPage = !$isSubcategoryPage && isset($category) && $category;
    @endphp
    {{-- Breadcrumb --}}
    <nav class="text-xs text-slate-500 mb-5 flex items-center gap-2 flex-wrap">
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

    {{-- ===== HERO HEADER (matches banner design) ===== --}}
    <section
        class="relative overflow-hidden mb-10 rounded-[28px] bg-gradient-to-br from-navy-50 to-slate-100 px-8 px-8 md:px-4py-2 md:py-4">

        {{-- Decorative dots (bottom-left) --}}
        {{-- <div class="absolute left-2 bottom-4 grid grid-cols-4 gap-2 opacity-70 pointer-events-none">
            @for ($i = 0; $i < 12; $i++)
                <span class="w-1.5 h-1.5 rounded-full bg-[#ff7a00]/40"></span>
            @endfor
        </div> --}}
        {{-- Decorative dots (bottom-left) - Triangle Shape --}}
        <div class="absolute left-2 bottom-4 flex flex-col gap-2 opacity-70 pointer-events-none">
            @for ($row = 2; $row <= 4; $row++)
                <div class="flex gap-2">
                    @for ($dot = 0; $dot < $row; $dot++)
                        <span class="w-1.5 h-1.5 rounded-full bg-[#ff7a00]/40"></span>
                    @endfor
                </div>
            @endfor
        </div>

        {{-- Decorative sparkle --}}
        <div class="absolute right-[38%] top-10 text-[#ff7a00] text-2xl pointer-events-none hidden md:block">✦</div>

        <div class="grid md:grid-cols-12 items-center gap-8 relative z-10">
            @php
                $heroImage = $isSubcategoryPage ? $subcategory->image ?? null : $category->image ?? null;
                $heroName = $isSubcategoryPage ? $subcategory->name : $category->name ?? 'Category';
                $heroDesc = $isSubcategoryPage ? $subcategory->description ?? '' : $category->description ?? '';
            @endphp

            <div class="md:col-span-7 flex flex-col justify-center py-12">


                {{-- Heading --}}
                <h1 class="text-4xl md:text-5xl font-extrabold text-[#001F54] leading-tight tracking-tight">
                    {{ $heroName }}
                </h1>

                {{-- Description --}}
                @if ($heroDesc)
                    <p class="text-slate-600 text-sm md:text-base mt-4 max-w-md leading-relaxed">
                        {{ $heroDesc }}
                    </p>
                @endif

                {{-- CTA Button --}}
                <div class="mt-4">
                    <a href="#products"
                        class="inline-flex items-center gap-2 bg-[#001F54] hover:bg-[#001440] text-white font-semibold text-sm px-4 py-2 rounded-xl transition-colors">
                        Explore
                        {{ $isSubcategoryPage ? $subcategory->name : ($isParentPage ? $category->name : 'Products') }}
                        <i class="fa-solid fa-arrow-right text-xs mb-[-3px]"></i>
                    </a>
                </div>
            </div>

            @if ($heroImage)
                <div class="md:col-span-5 flex justify-center"
                    style="
                    background: url({{ url('storage/' . $heroImage) }});
                    background-repeat: no-repeat;
                    background-size: contain;
                    height: 100%;
                    background-position: center;">
                    {{-- <img src="{{ url('storage/' . $heroImage) }}" alt="{{ $heroName }}"
                        class="max-h-64 md:max-h-80 object-contain drop-shadow-xl"> --}}
                </div>
            @endif
        </div>
    </section>

    {{-- =====================================================
         PARENT CATEGORY PAGE — subcategory sections with products
    ====================================================== --}}
    @if ($isParentPage)
        @php $hasAnyProduct = false; @endphp

        @if ($category->children->count())
            <div class="space-y-14" id="products">
                @foreach ($category->children as $sub)
                    @if ($sub->products->count())
                        @php $hasAnyProduct = true; @endphp
                        <section>
                            {{-- Section Heading --}}
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
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
            <section class="mt-14" id="products">
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
                <a href="{{ route('products.index') }}"
                    class="bg-navy-800 mt-6 text-white rounded-xl px-4 py-2 inline-flex">Browse All Products</a>
            </div>
        @endif
    @endif

    {{-- =====================================================
         SUBCATEGORY PAGE — paginated product list
    ====================================================== --}}
    @if ($isSubcategoryPage)
        @if (isset($products) && $products->count())
            <div class="grid-4" id="products">
                @foreach ($products as $product)
                    @include('storefront.partials.product-card', ['product' => $product])
                @endforeach
            </div>
            @if ($products->hasPages())
                <div class="mt-12 flex justify-center">{{ $products->links() }}</div>
            @endif
        @else
            <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-16 text-center" id="products">
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
