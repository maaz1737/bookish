@extends('layouts.app')

@section('content')


    {{-- ===== HERO BANNER ===== --}}
    @if ($heroBanners->count() > 0)
        <section class="rounded-[24px] overflow-hidden bg-gradient-to-br from-navy-50 to-slate-100 mb-10 relative">
            <div class="swiper heroSwiper">
                <div class="swiper-wrapper">
                    @foreach ($heroBanners as $banner)
                        <div class="swiper-slide">
                            @if ($banner->link)
                                <a href="{{ $banner->link }}" class="block">
                            @endif
                                <div class="grid md:grid-cols-2 gap-8 items-center p-8 md:p-12">
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
                                        <div class="flex gap-4 mt-6">
                                            <a href="#school-section"
                                                class="px-6 py-3 bg-navy-800 text-white rounded-xl shadow-md hover:shadow-lg">
                                                Shop by School <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                                            </a>
                                            <a href="#category-section"
                                                class="inline-flex items-center justify-center border-2 border-[#001F54] text-[#001F54] hover:bg-[#001F54] hover:text-white px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-200">
                                                Shop All Categories
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
                                @if ($banner->link)
                                    </a>
                                @endif
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination !bottom-4"></div>
            </div>
        </section>
    @endif


    {{-- ===== POPULAR SCHOOLS ===== --}}
    <section class="mb-12" id="school-section">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-[#001F54] flex items-center gap-2">
                <i class="fa-solid fa-school text-[#001F54]"></i> Popular Schools
            </h2>
            <a href="{{ route('schools.index') }}"
                class="text-[#001F54] hover:text-[#ff7a00] font-semibold text-sm flex items-center gap-1 transition-colors">
                View All Schools <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid-3">
            @foreach ($schools as $school)
                <div class="school-card card p-6 flex flex-col justify-between h-full group filter-con">
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
                    <a href="{{ route('schools.show', $school) }}" class="primary-btn w-full justify-center">
                        Explore Now →
                    </a>
                </div>
            @endforeach
        </div>
    </section>


    {{-- ===== TRENDING NOW ===== --}}
    @if (isset($bestSellers) && $bestSellers->count())
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-[#001F54] flex items-center gap-2">
                    <i class="fa-solid fa-fire text-[#ff7a00]"></i> Trending Now
                </h2>
                <a href="{{ route('products.index') }}"
                    class="text-[#001F54] hover:text-[#ff7a00] font-semibold text-sm flex items-center gap-1 transition-colors">
                    View All Products <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="grid-3">
                @foreach ($bestSellers as $index => $product)
                    @php
                        $badgeClass = 'badge';
                        if ($product->discount_price && $product->price > 0) {
                            $pct = round((($product->price - $product->discount_price) / $product->price) * 100);
                            $badgeText = "Save {$pct}%";
                            $badgeClass = 'badge badge-orange';
                        } elseif ($product->is_best_seller) {
                            $badgeText = 'Best Seller';
                        } else {
                            $badgeText = $index % 2 === 0 ? 'New Arrival' : 'Top Trend';
                        }

                        $inWishlist = false;
                        if (auth()->check()) {
                            $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                        } else {
                            $inWishlist = \App\Models\Wishlist::where('session_id', session()->getId())->where('product_id', $product->id)->exists();
                        }
                    @endphp


                    @include('partials.product-card', ['product' => $product])

                @endforeach
            </div>
        </section>
    @endif


    {{-- ===== SHOP BY CATEGORY ===== --}}
    <section class="mb-12" id="category-section">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-[#001F54] flex items-center gap-2">
                <i class="fa-solid fa-layer-group text-[#001F54]"></i> Shop by Category
            </h2>
            <a href="{{ route('categories.index') }}"
                class="text-[#001F54] hover:text-[#ff7a00] font-semibold text-sm flex items-center gap-1 transition-colors">
                View All Categories <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid-4">
            @foreach ($categories as $category)
                <div class="category-card card flex flex-col justify-between h-full group filter-con">
                    <div>
                        <div class="card-img-box">
                            @if ($category->image ?? false)
                                <img src="{{ url('storage/' . $category->image) }}" alt="{{ $category->name }} category"
                                    class="card-img-cover" loading="lazy" />
                            @else
                                <i class="fa-solid fa-book text-4xl text-[#001F54] opacity-30"></i>
                            @endif
                        </div>
                        <div class="p-5 pb-2">
                            <h3 class="text-base font-bold text-[#001F54] text-center filter-name">
                                {{ $category->name }}
                            </h3>
                        </div>
                    </div>
                    <div class="px-5 pb-5">
                        <a href="{{ route('category.show', $category->slug) }}" class="primary-btn block">
                            Explore Now →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>


    {{-- ===== SMART SAVER BUNDLES ===== --}}
    @if (isset($bundles) && $bundles->count())
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-[#001F54] flex items-center gap-2">
                    <i class="fa-solid fa-boxes-stacked text-[#001F54]"></i> Smart Saver Bundles
                </h2>
                <a href="{{ route('bundles.index') }}"
                    class="text-[#001F54] hover:text-[#ff7a00] font-semibold text-sm flex items-center gap-1 transition-colors">
                    View All Bundles <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="grid-4">
                @foreach ($bundles as $bundle)
                    @php
                        $discount = (float) ($bundle->discount ?? 0);
                        $products = $bundle->products;
                        $prodImages = $products->filter(fn($p) => !empty($p->images))->take(4)->values();
                        $imgCount = $prodImages->count();
                        $imgSrc = fn($path) => url('storage/' . $path);
                    @endphp

                    <div class="bundle-card card flex flex-col relative group h-full filter-con">

                        <!-- Badges -->
                        @if ($discount > 0)
                            <span class="badge badge-orange absolute top-4 left-4 z-20 shadow-md">
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
                        <div
                            class="relative overflow-hidden bg-gradient-to-br from-slate-50 via-blue-50/40 to-indigo-50 h-[200px] w-full">
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
                                            class="flex items-center justify-center p-3 border-white/60
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                {{ $loop->index === 0 ? 'border-r border-b' : '' }}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                {{ $loop->index === 1 ? 'border-b' : '' }}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                {{ $loop->index === 2 ? 'border-r' : '' }}">
                                            <img src="{{ $imgSrc($prod->images[0]) }}"
                                                class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-500"
                                                alt="{{ $prod->name }}" loading="lazy" />
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Bundle Card Content -->
                        <div class="p-5 flex flex-col flex-grow justify-between">
                            <div>
                                <h3 class="text-[#001F54] font-bold text-base leading-tight mb-1 filter-name">
                                    {{ $bundle->name }}
                                </h3>
                                <p class="text-xs text-slate-400 mb-3 line-clamp-1">
                                    {{ $products->pluck('name')->join(' + ') }}
                                </p>
                            </div>
                            <div class="mb-4">
                                <span class="text-lg font-bold text-[#001F54]">
                                    PKR {{ number_format($bundle->final_price) }}
                                </span>
                                @if ($bundle->total_price > 0 && $bundle->total_price != $bundle->final_price)
                                    <span class="text-xs text-slate-400 line-through ml-2">
                                        PKR {{ number_format($bundle->total_price) }}
                                    </span>
                                @endif
                            </div>

                            <form action="{{ route('cart.addBundle', $bundle) }}" method="POST" class="w-full mt-auto">
                                @csrf
                                <button type="submit" class="primary-btn w-full justify-center">
                                    <i class="fa-solid fa-cart-shopping text-sm"></i> Add Bundle to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif


    {{-- ===== TRUST / BENEFITS STRIP ===== --}}
    <section
        class="bg-white rounded-[20px] shadow-[0_8px_24px_rgba(0,31,84,0.04)] border border-slate-100 p-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6 text-sm mb-12">
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
                <b class="text-[#001F54] font-bold block text-sm">Fast & Reliable Delivery</b>
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


    {{-- Swiper --}}
    <script>
        new Swiper('.heroSwiper', {
            loop: true,
            pagination: { el: '.swiper-pagination', clickable: true },
            autoplay: { delay: 4500 },
        });
    </script>

    {{-- Live Search Filter --}}
    <script>
        $(document).ready(function () {
            // Prevent form submit from reloading the page
            $(".filter-search").closest("form").on("submit", function (e) {
                e.preventDefault();
            });

            $(".filter-search").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $(".filter-con").each(function () {
                    var text = $(this).find(".filter-name").text().toLowerCase();
                    $(this).toggle(text.indexOf(value) > -1);
                });
            });
        });
    </script>

@endsection