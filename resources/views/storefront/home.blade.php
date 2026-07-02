@extends('layouts.app')

@section('content')

    {{-- ===== HERO ===== --}}
    @if ($heroBanners->count() > 0)
        <section class="rounded-2xl overflow-hidden bg-gradient-to-br from-navy-50 to-slate-100 mb-10">
            <div class="swiper heroSwiper">
                <div class="swiper-wrapper">
                    @foreach ($heroBanners as $banner)
                        <div class="swiper-slide">
                            @if ($banner->link)
                                <a href="{{ $banner->link }}">
                            @endif
                                <div class="grid md:grid-cols-2 gap-6 items-center p-8 md:p-12">
                                    <div>
                                        <span class="text-gold-500 text-sm font-semibold"><i class="fa-solid fa-star"></i> WELCOME
                                            TO BOOKISH & BEYOND</span>
                                        <h2 class="text-3xl md:text-5xl font-extrabold text-navy-900 mt-3 leading-tight">
                                            Everything Your Family Needs, <br>
                                            In <span class="text-gold-500">One Place</span>
                                        </h2>
                                        <p class="mt-4 text-slate-600 max-w-md">Books, Uniforms, Bags, Baby Wear & Thoughtful
                                            Gifts – All Handpicked for Quality You Can Trust.</p>
                                        <div class="flex gap-3 mt-6">
                                            <a href="#school-section"
                                                class="bg-navy-800 text-white px-5 py-3 rounded-md font-semibold text-sm">Shop
                                                by School <i class="fa-solid fa-arrow-right ml-1"></i></a>
                                            <a href="#category-section"
                                                class="border border-navy-800 text-navy-800 px-5 py-3 rounded-md font-semibold text-sm">Shop
                                                All Categories <i class="fa-solid fa-arrow-right ml-1"></i></a>
                                        </div>
                                        <div class="flex flex-wrap gap-6 mt-8 text-sm">
                                            <div><i class="fa-solid fa-shield-halved text-navy-700"></i> <b>100%
                                                    Original</b><br><span class="text-xs text-slate-500">Authentic
                                                    Products</span></div>
                                            <div><i class="fa-solid fa-truck text-navy-700"></i> <b>Fast Delivery</b><br><span
                                                    class="text-xs text-slate-500">Across Pakistan</span></div>
                                            <div><i class="fa-solid fa-rotate-left text-navy-700"></i> <b>Easy
                                                    Returns</b><br><span class="text-xs text-slate-500">Within 7 Days</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-img-box" style="aspect-ratio: 5/4; background: transparent;">
                                        <img class="" src="{{ app()->environment('production')
                        ? asset('storage/' . $banner->image_path)
                        : asset('storage/banners/paf-banner-removebg.png') }}" alt="">
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


    {{-- ===== BEST SELLERS ===== --}}
    @if (isset($bestSellers) && $bestSellers->count())
        <section class="mb-12">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-2xl font-bold text-navy-900 flex items-center gap-2"><i
                        class="fa-solid fa-star text-gold-500"></i> Best Sellers</h2>
                <a href="{{ route('products.index') }}" class="bg-navy-800 text-white px-4 py-2 rounded-md text-sm">View All
                    Products <i class="fa-solid fa-arrow-right ml-1"></i></a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                @foreach ($bestSellers as $product)
                    <div
                        class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-md transition relative filter-con flex flex-col h-full">
                        <button
                            class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-slate-400 hover:text-rose-500 z-10"><i
                                class="fa-regular fa-heart"></i></button>

                        {{-- FIXED IMAGE BOX --}}
                        <a href="{{ route('product.show', $product) }}" class="block">
                            <div class="card-img-box p-5 bg-slate-50">
                                @if (isset($product->images) && count($product->images) > 0)
                                    <img class="card-img"
                                        src="{{ app()->environment('production') ? asset('storage/' . $product->images[0]) : asset('storage/' . $product->images[0]) }}"
                                        alt="{{ $product->name }}">
                                @else
                                    <div
                                        class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-500 text-sm border rounded">
                                        No Image
                                    </div>
                                @endif
                            </div>
                        </a>
                        <div class="p-4 flex flex-col flex-grow">
                            <a href="{{ route('product.show', $product) }}" class="hover:text-gold-500 transition">
                                <h3 class="font-semibold text-navy-900 text-sm filter-name line-clamp-2" style="min-height: 10px;">
                                    {{ $product->name }}
                                </h3>
                            </a>
                            <div class="flex items-center gap-1 text-gold-500 text-xs mt-1">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                                <span class="text-slate-500 ml-1">(0)</span>
                            </div>

                            <div class="mt-2 flex items-center gap-2 flex-wrap">
                                <span class="font-bold text-navy-900">
                                    PKR {{ number_format($product->discount_price ?? $product->price) }}
                                </span>
                                @if ($product->discount_price && $product->price)
                                    <span class="text-xs text-slate-400 line-through">
                                        PKR {{ number_format($product->price) }}
                                    </span>
                                @endif
                            </div>

                            <div class="mt-auto pt-3">
                                <form action="{{ route('cart.addProduct', $product) }}" method="POST" class="cart-form">
                                    @csrf
                                    <button type="submit"
                                        class="cart-add w-full border border-navy-200 text-navy-800 py-2 rounded-md text-sm font-semibold hover:bg-navy-50 flex justify-center items-center">
                                        <i class="fa-solid fa-cart-shopping mr-1"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif


    {{-- ===== POPULAR SCHOOLS ===== --}}
    <section class="mb-12" id="school-section">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-2xl font-bold text-navy-900 flex items-center gap-2"><i
                    class="fa-solid fa-bag-shopping text-navy-700"></i> Popular Schools</h2>
            <a href="#" class="bg-navy-800 text-white px-4 py-2 rounded-md text-sm">View All Schools <i
                    class="fa-solid fa-arrow-right ml-1"></i></a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach ($schools as $i => $school)
                @php $bg = ['bg-navy-50', 'bg-amber-50', 'bg-rose-50'][$i % 3]; @endphp
                <a href="{{ route('schools.show', $school) }}" class="{{ $bg }} rounded-xl p-5">
                    <div class="flex items-start gap-4">
                        <div class="logo-box">
                            @if ($school->logo ?? false)
                                <img src="{{ asset('storage/' . $school->logo) }}" alt="{{ $school->name }}">
                            @else
                                <i class="fa-solid fa-school text-2xl text-navy-700"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-navy-900 filter-name">{{ $school->name }}</h3>
                            <ul class="text-sm text-slate-600 mt-2 space-y-1">
                                <li><i class="fa-solid fa-book text-navy-600 mr-1"></i> Books</li>
                                <li><i class="fa-solid fa-shirt text-navy-600 mr-1"></i> Uniforms</li>
                                <li><i class="fa-solid fa-bag-shopping text-navy-600 mr-1"></i> Accessories</li>
                            </ul>
                        </div>
                    </div>
                    <span href="#"
                        class="mt-5 block text-center bg-navy-800 text-white py-2.5 rounded-md text-sm font-semibold">View
                        Classes <i class="fa-solid fa-arrow-right ml-1"></i></span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ===== SHOP BY CATEGORY ===== --}}
    <section class="mb-12" id="category-section">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-2xl font-bold text-navy-900 flex items-center gap-2"><i
                    class="fa-solid fa-bag-shopping text-navy-700"></i> Shop by Category</h2>
            <a href="#" class="bg-navy-800 text-white px-4 py-2 rounded-md text-sm">View All Categories <i
                    class="fa-solid fa-arrow-right ml-1"></i></a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-12">
            @foreach ($categories as $category)
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-md transition filter-con">
                    {{-- FIXED IMAGE BOX: all category images render at same size --}}
                    <div class="card-img-box bg-slate-50">
                        <img class="card-img" src="{{ app()->environment('production')
                ? url('storage/' . $category->image)
                : asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                    </div>
                    <div class="p-4">
                        <div class="flex items-center gap-2">
                            <span class="w-9 h-9 rounded-full bg-navy-50 flex items-center justify-center text-navy-700">
                                <i class="fa-solid fa-book"></i>
                            </span>

                            <div class="w-full">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="font-bold text-navy-900 leading-tight filter-name">
                                        {{ $category->name }}
                                    </h3>
                                </div>

                                <span class="inline-flex mt-1 text-xs bg-gray-100 rounded-full px-2 py-1 w-fit">
                                    Total Products: {{ $category->products_count }}
                                </span>

                                <p class="text-xs text-slate-500 mt-1">
                                    {{ \Illuminate\Support\Str::limit($category->description, 30, '') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center">
                            <a href="{{ route('category.show', $category->slug) }}"
                                class="mt-3 inline-flex items-center text-sm font-semibold text-navy-700">Explore Now <i
                                    class="fa-solid fa-arrow-right ml-1"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ===== SMART SAVER BUNDLES ===== --}}
    @if (isset($bundles) && $bundles->count())
        <section class="mb-12">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-2xl font-bold text-navy-900 flex items-center gap-2">
                    <i class="fa-solid fa-boxes-stacked text-[#0a1f44]"></i> Smart Saver Bundles
                </h2>
                <a href="{{ route('bundles.index') }}"
                    class="bg-navy-800 text-white px-4 py-2 rounded-md text-sm transition hover:bg-navy-700">
                    View All Bundles <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($bundles as $bundle)
                    @php
                        $discount = (float) ($bundle->discount ?? 0);
                        $products = $bundle->products;
                        $prodImages = $products->filter(fn($p) => !empty($p->images))->take(4)->values();
                        $imgCount = $prodImages->count();
                        $includedNames = $products->pluck('name')->join(' + ');
                        $imgHelper = fn($path) => app()->environment('production')
                            ? asset('storage/' . $path)
                            : asset('storage/' . $path);
                    @endphp
                    <div
                        class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full group">

                        {{-- ===== BUNDLE COLLAGE IMAGE AREA ===== --}}
                        <div class="relative overflow-hidden bg-gradient-to-br from-slate-50 via-blue-50/40 to-indigo-50 h-[200px]">

                            {{-- Discount Badge --}}
                            @if ($discount > 0)
                                <div
                                    class="absolute top-3 left-3 z-20 bg-gradient-to-r from-amber-400 to-orange-400 text-white text-[11px] font-black px-3 py-1 rounded-full shadow-md flex items-center gap-1">
                                    <i class="fa-solid fa-bolt text-[9px]"></i> Save {{ rtrim(rtrim($discount, '0'), '.') }}%
                                </div>
                            @endif

                            {{-- Bundle count pill --}}
                            @if ($products->count() > 0)
                                <div
                                    class="absolute top-3 right-3 z-20 bg-white/80 backdrop-blur-sm text-[#0a1f44] text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm border border-slate-200">
                                    {{ $products->count() }} items
                                </div>
                            @endif

                            @if ($imgCount === 0)
                                {{-- No images placeholder --}}
                                <div class="w-full h-full flex flex-col items-center justify-center gap-2 opacity-30">
                                    <i class="fa-solid fa-boxes-stacked text-5xl text-slate-400"></i>
                                    <span class="text-xs text-slate-400 font-medium">Bundle</span>
                                </div>

                            @elseif ($imgCount === 1)
                                {{-- Single product: centered full image --}}
                                <div class="w-full h-full flex items-center justify-center p-6">
                                    <img src="{{ $imgHelper($prodImages[0]->images[0]) }}"
                                        class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-500"
                                        alt="{{ $prodImages[0]->name }}"
                                        onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}'">
                                </div>

                            @elseif ($imgCount === 2)
                                {{-- Two products: equal halves with divider --}}
                                <div class="flex h-full">
                                    @foreach ($prodImages as $prod)
                                        <div
                                            class="flex-1 flex items-center justify-center p-4 {{ !$loop->last ? 'border-r border-white/60' : '' }}">
                                            <img src="{{ $imgHelper($prod->images[0]) }}"
                                                class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-500"
                                                alt="{{ $prod->name }}"
                                                onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}'">
                                        </div>
                                    @endforeach
                                </div>

                            @elseif ($imgCount === 3)
                                {{-- Three products: equal 3-column row --}}
                                <div class="flex h-full">
                                    @foreach ($prodImages as $prod)
                                        <div
                                            class="flex-1 flex items-center justify-center p-3 {{ !$loop->last ? 'border-r border-white/60' : '' }}">
                                            <img src="{{ $imgHelper($prod->images[0]) }}"
                                                class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-500"
                                                alt="{{ $prod->name }}"
                                                onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}'">
                                        </div>
                                    @endforeach
                                </div>

                            @else
                                {{-- Four products: 2×2 grid --}}
                                <div class="grid grid-cols-2 grid-rows-2 h-full">
                                    @foreach ($prodImages as $prod)
                                        <div
                                            class="flex items-center justify-center p-3
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            {{ $loop->index === 0 ? 'border-r border-b' : '' }}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            {{ $loop->index === 1 ? 'border-b' : '' }}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            {{ $loop->index === 2 ? 'border-r' : '' }}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            border-white/60">
                                            <img src="{{ $imgHelper($prod->images[0]) }}"
                                                class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-500"
                                                alt="{{ $prod->name }}"
                                                onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}'">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Card Content --}}
                        <div class="p-4 flex flex-col flex-grow">
                            <h3 class="font-bold text-[#0a1f44] text-base leading-tight">{{ $bundle->name }}</h3>
                            <p class="text-xs text-slate-400 mt-1 line-clamp-2">{{ $includedNames }}</p>

                            <div class="mt-3 flex items-baseline gap-2 flex-wrap">
                                <span class="font-extrabold text-[#0a1f44] text-xl">
                                    PKR {{ number_format($bundle->final_price) }}
                                </span>
                                @if ($bundle->total_price > 0 && $bundle->total_price != $bundle->final_price)
                                    <span class="text-xs text-slate-400 line-through">
                                        PKR {{ number_format($bundle->total_price) }}
                                    </span>
                                @endif
                            </div>

                            <div class="mt-auto pt-3">
                                <form action="{{ route('cart.addBundle', $bundle) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-[#0a1f44] hover:bg-[#0d2a5c] text-white py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
                                        <i class="fa-solid fa-cart-shopping"></i> Add Bundle to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ===== TRUST BAR ===== --}}
    <section class="bg-white rounded-xl border border-slate-200 p-6 grid grid-cols-2 md:grid-cols-5 gap-6 text-sm">
        <div class="flex gap-3"><i class="fa-solid fa-shield-halved text-2xl text-navy-700"></i>
            <div><b>100% Original Products</b>
                <p class="text-xs text-slate-500">Sourced from authorized suppliers</p>
            </div>
        </div>
        <div class="flex gap-3"><i class="fa-solid fa-truck text-2xl text-navy-700"></i>
            <div><b>Fast & Reliable Delivery</b>
                <p class="text-xs text-slate-500">Across Pakistan</p>
            </div>
        </div>
        <div class="flex gap-3"><i class="fa-solid fa-lock text-2xl text-navy-700"></i>
            <div><b>Secure Payments</b>
                <p class="text-xs text-slate-500">Multiple payment options</p>
            </div>
        </div>
        <div class="flex gap-3"><i class="fa-solid fa-rotate-left text-2xl text-navy-700"></i>
            <div><b>Easy Returns</b>
                <p class="text-xs text-slate-500">Hassle-free returns within 7 days</p>
            </div>
        </div>
        <div class="flex gap-3"><i class="fa-solid fa-headset text-2xl text-navy-700"></i>
            <div><b>Dedicated Support</b>
                <p class="text-xs text-slate-500">We're here to help you anytime</p>
            </div>
        </div>
    </section>

    <script>
        new Swiper('.heroSwiper', {
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            autoplay: {
                delay: 4500
            },
        });
    </script>


    <script>
        $(document).ready(function () {

            $(".filter-search").on("keyup", function () {
                var value = $(this).val().toLowerCase();

                $(".filter-con").each(function () {

                    let text = $(this).find(".filter-name").text().toLowerCase();

                    if (text.indexOf(value) > -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }

                });
            });

        });
    </script>
@endsection