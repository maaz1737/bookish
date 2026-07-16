@extends('layouts.app')

@section('content')


    {{-- ===== HERO BANNER ===== --}}
    @if ($heroBanners->count() > 0)
        <section
            class="rounded-[24px] overflow-hidden bg-transparent sm:bg-gradient-to-br sm:from-navy-50 sm:to-slate-100 mb-10 relative filter-container">
            <div class="swiper heroSwiper filter-card">
                <div class="swiper-wrapper">
                    @foreach ($heroBanners as $banner)
                        <div class="swiper-slide">
                            <div class="grid md:grid-cols-2 gap-8 items-center xs:p-4 sm:p-8 md:p-12">
                                <div class="z-10">
                                    <span
                                        class="text-[#ff7a00] text-sm font-bold tracking-wider uppercase flex items-center gap-1.5">
                                        <i class="fa-solid fa-star"></i> Welcome to Bookish & Beyond
                                    </span>
                                    <h2 class="text-3xl md:text-5xl font-extrabold text-[#001F54] mt-3 leading-tight font-sans">
                                        Everything Your Family Needs, <br>
                                        <span class="text-[#ff7a00]">In One Place.</span>
                                    </h2>
                                    <p class="mt-4 text-slate-600 max-w-md text-sm md:text-base leading-relaxed">
                                        Books, Uniforms, Bags, Attar & Thoughtful Gifts – All Handpicked for Quality You Can
                                        Trust.
                                    </p>
                                    <div class="flex flex-col sm:flex-row sm:flex-wrap gap-3 sm:gap-4 mt-6 w-full ">
                                        <a href="{{ route('schools.index') }}"
                                            class="inline-flex items-center justify-center whitespace-nowrap 
                                            w-full sm:w-auto
                                            px-4 py-2.5 text-sm rounded-lg
                                            bg-navy-800 text-white shadow-md hover:shadow-lg
                                            transition-all duration-200
                                            lg:px-6 lg:py-3 lg:text-base lg:rounded-xl hover:bg-[#223a8f]">
                                            Shop by School <i class="fa-solid fa-arrow-right ml-1.5 text-xs"></i>
                                        </a>

                                        <a href="{{ route('categories.index') }}"
                                            class="inline-flex items-center justify-center whitespace-nowrap
                                            w-full sm:w-auto
                                             border-2 border-[#001F54] text-[#001F54]
                                            hover:bg-[#001F54] hover:text-white
                                             px-4 py-2.5 text-sm rounded-lg font-semibold
                                             transition-all duration-200
                                            lg:px-6 lg:py-3 lg:text-base lg:rounded-xl">
                                            Browse All Categories
                                        </a>
                                    </div>


                                    {{-- Hero Bottom Trust Strip --}}
                                    <div class="flex flex-wrap gap-x-6 gap-y-2 mt-10 text-xs md:text-sm text-slate-700">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-shield-halved text-[#001F54]"></i>
                                            <span><b>100% Original</b></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-truck text-[#001F54]"></i>
                                            <span><b>Fast Delivery</b></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-rotate-left text-[#001F54]"></i>
                                            <span><b>Easy Returns</b></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-lock text-[#001F54]"></i>
                                            <span><b>Secure Payments</b></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-center md:justify-end">
                                    <div class="w-full max-w-[480px] aspect-[5/4] flex items-center justify-center p-4">
                                        <img class="max-h-full max-w-full object-contain"
                                            src="{{ asset('storage/' . $banner->image_path) }}"
                                            alt="Everything Your Family Needs, In One Place" loading="eager">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination !bottom-4"></div>
            </div>
        </section>
    @endif


    {{-- ===== POPULAR SCHOOLS ===== --}}
    {{-- <section class="mb-12 filter-container" id="school-section">
        <div class="flex items-center justify-between mb-6">
            <h2 class="flex items-center gap-2 text-xl md:text-2xl font-bold text-[#001F54]">
                <i class="fa-solid fa-school text-[#001F54]"></i> Popular Schools
            </h2>
            <a href="{{ route('schools.index') }}"
                class="flex items-center gap-1 whitespace-nowrap text-sm font-semibold text-[#001F54] transition-colors hover:text-[#ff7a00]">
                <span>View All <span class="hidden md:inline">Schools</span></span> <i
                    class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid-3">
            @foreach ($schools as $school)
            <a href="{{ route('schools.show', $school) }}"
                class="school-card card p-6 flex flex-col justify-between h-full group filter-card">
                <div>
                    <div
                        class="w-20 h-20 bg-slate-50 rounded-2xl p-2 mb-4 border border-slate-100 flex items-center justify-center overflow-hidden transition-all duration-300 group-hover:scale-105">
                        @if ($school->logo ?? false)
                        <img src="{{ asset('storage/' . $school->logo) }}" alt="{{ $school->name }} emblem"
                            class="max-w-full max-h-full object-contain" loading="lazy" />
                        @else
                        <i class="fa-solid fa-school text-3xl text-[#001F54]"></i>
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-[#001F54] leading-tight mb-2 filter-name">
                        {{ $school->name }}
                    </h3>
                    <p class="text-sm text-slate-500 mb-6">
                        Shop books, uniforms & essentials
                    </p>
                </div>
                <button class="primary-btn w-full justify-center hover:bg-[#223a8f]">
                    Explore Now →
                </button>
            </a>
            @endforeach
        </div>
    </section> --}}


    {{-- ===== TRENDING NOW ===== --}}
    @if (isset($bestSellers) && $bestSellers->count())
        <section class="mb-8 md:mb-12 filter-container">
            <div class="flex items-center justify-between gap-3 mb-4 md:mb-6">

                <!-- Section Title -->
                <h2 class="flex items-center gap-2 text-xl md:text-2xl font-bold text-[#001F54]">
                    <i class="fa-solid fa-fire text-[#ff7a00] text-lg md:text-xl"></i>
                    Trending Now
                </h2>

                <!-- View All -->
                <a href="{{ route('products.index') }}"
                    class="flex items-center gap-1 whitespace-nowrap text-sm font-semibold text-[#001F54] transition-colors hover:text-[#ff7a00]">
                    View All
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>

            </div>
            <!-- Products -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-3 gap-4 md:gap-6">
                @foreach ($bestSellers as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </section>
    @endif


    {{-- ===== SHOP BY CATEGORY ===== --}}

    @if($categories->count())
        <section class="mb-12 filter-container" id="category-section">
            <div class="flex items-center justify-between mb-6">
                <h2 class="flex items-center gap-2 text-xl md:text-2xl font-bold text-[#001F54]">
                    <i class="fa-solid fa-layer-group text-[#001F54]"></i> Shop by Category
                </h2>
                <a href="{{ route('categories.index') }}"
                    class="flex items-center gap-1 whitespace-nowrap text-sm font-semibold text-[#001F54] transition-colors hover:text-[#ff7a00]">
                    <span>View All <span class="hidden md:inline">Categories</span></span> <i
                        class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
            <div class="grid-3">
                @foreach ($categories as $category)
                    @include('partials.category-card', ['category' => $category])
                @endforeach
            </div>
        </section>


    @endif


    {{-- ===== SMART SAVER BUNDLES ===== --}}
    @if ($bundles->count())
        <section class="filter-container">
            <div class="flex items-center justify-between mb-6">
                <h2 class="flex items-center gap-2 text-xl md:text-2xl font-bold text-[#001F54]">
                    <i class="fa-solid fa-boxes-stacked text-[#001F54]"></i> Smart Saver Bundles
                </h2>
                <a href="{{ route('bundles.index') }}"
                    class="flex items-center gap-1 whitespace-nowrap text-sm font-semibold text-[#001F54] transition-colors hover:text-[#ff7a00]">
                    <span>View All <span class="hidden md:inline">Bundles</span></span> <i
                        class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="grid-3">
                @foreach ($bundles as $bundle)
                    @php
                        $discount = (float) ($bundle->discount ?? 0);
                        $products = $bundle->products;
                        $prodImages = $products->filter(fn($p) => !empty($p->images))->take(4)->values();
                        $imgCount = $prodImages->count();
                        $imgSrc = fn($path) => url('storage/' . $path);
                    @endphp

                    <div class="relative bundle-card card product-card filter-card">

                        <!-- Badges -->
                        @if ($discount > 0)
                            <span class="absolute top-4 left-4 z-10 bg-orange-200/80 text-orange-600 text-[10px] sm:text-xs font-bold px-2 py-1 rounded-full leading-none shadow-md border border-orange-300">
                                Save {{ rtrim(rtrim($discount, '0'), '.') }}%
                            </span>
                        @endif
                        @if ($products->count() > 0)
                            <span
                                class="absolute top-4 right-4 z-20 bg-white/90 text-[#001F54] text-[11px] font-bold px-2.5 py-1 rounded-full shadow-sm border border-slate-200">
                                {{ $products->count() }} Items
                            </span>
                        @endif

                        <!-- Bundle Collage Image Area -->
                        <div class="relative image-container">
                            @if ($imgCount === 0)
                                <div class="w-full h-full flex items-center justify-center opacity-30">
                                    <i class="fa-solid fa-boxes-stacked text-5xl text-[#001F54]"></i>
                                </div>

                            @elseif ($imgCount === 1)
                                <div class="w-full h-full flex items-center justify-center">
                                    <img src="{{ $imgSrc($prodImages[0]->images[0]) }}"
                                        class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-500"
                                        alt="{{ $prodImages[0]->name }}" loading="lazy" />
                                </div>

                            @elseif ($imgCount === 2)
                                <div class="flex h-full">
                                    @foreach ($prodImages as $prod)
                                        <div
                                            class="flex-1 flex items-center justify-center p-4 {{ !$loop->last ? 'border-r border-white/60' : '' }}">
                                            <img src="{{ $imgSrc($prod->images[0]) }}"
                                                class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-500"
                                                alt="{{ $prod->name }}" loading="lazy" />
                                        </div>
                                    @endforeach
                                </div>

                            @elseif ($imgCount === 3)
                                <div class="flex h-full">
                                    @foreach ($prodImages as $prod)
                                        <div
                                            class="flex-1 flex items-center justify-center p-3 {{ !$loop->last ? 'border-r border-white/60' : '' }}">
                                            <img src="{{ $imgSrc($prod->images[0]) }}"
                                                class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-500"
                                                alt="{{ $prod->name }}" loading="lazy" />
                                        </div>
                                    @endforeach
                                </div>

                            @else
                                <div class="grid grid-cols-2 grid-rows-2 h-full">
                                    @foreach ($prodImages as $prod)
                                        <div
                                            class="flex items-center justify-center p-3 border-white/60 {{ $loop->index === 0 ? 'border-r border-b' : '' }} {{ $loop->index === 1 ? 'border-b' : '' }} {{ $loop->index === 2 ? 'border-r' : '' }}">
                                            <img src="{{ $imgSrc($prod->images[0]) }}"
                                                class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-500"
                                                alt="{{ $prod->name }}" loading="lazy" />
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Bundle Card Content -->
                        <div class="product-info">
                            <div>
                                <h3
                                    class="text-sm font-bold text-[#0a1a3d] hover:text-[#1e3a8a] transition-colors leading-snug line-clamp-2 filter-name h-4 py-4 hover:underline">
                                    {{ ucfirst($bundle->name) }}
                                </h3>
                                <p class="text-xs text-slate-400 pb-1 line-clamp-1 h-6">
                                    {{ $products->pluck('name')->join(' + ') }}
                                </p>
                            </div>
                            <div class="mb-2 amount">
                                <span class="">
                                    PKR {{ number_format($bundle->final_price) }}
                                </span>
                                @if ($bundle->total_price > 0 && $bundle->total_price != $bundle->final_price)
                                    <span class="prev-amount">
                                        PKR {{ number_format($bundle->total_price) }}
                                    </span>
                                @endif
                            </div>

                            <form action="{{ route('cart.addBundle', $bundle) }}" method="POST" class="w-full mt-auto">
                                @csrf
                                <button type="submit"
                                    class="primary-btn relative w-full rounded-lg bg-[#001F54] py-2 md:py-2.5 text-sm md:text-base font-medium text-white transition-all duration-200 hover:bg-[#223a8f] hover:shadow-md active:scale-[0.98]">
                                    <i class="fa-solid fa-cart-shopping text-sm"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif


    {{-- ===== TRUST / BENEFITS STRIP ===== --}}

    @include('partials.trust-section')

@endsection