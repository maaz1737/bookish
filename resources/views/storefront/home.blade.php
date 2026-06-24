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
                                    <img class=""
                                        src="{{ app()->environment('production')
                                            ? asset('storage/app/public/' . $banner->image_path)
                                            : asset('storage/banners/paf-banner-removebg.png') }}"
                                        alt="">
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

        <div class="grid grid-cols-2 md:grid-cols-4 gap-12">
            @foreach ($categories as $category)
                <div
                    class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-md transition filter-con">
                    {{-- FIXED IMAGE BOX: all category images render at same size --}}
                    <div class="card-img-box bg-slate-50">
                        <img class="card-img"
                            src="{{ app()->environment('production')
                                ? url('storage/app/public/' . $category->image)
                                : asset('storage/' . $category->image) }}"
                            alt="{{ $category->name }}">
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



    @php
        $bestSellers = collect([
            (object) [
                'name' => 'School Backpack',
                'price' => 3500,
                'reviews_count' => 24,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600',
            ],
            (object) [
                'name' => 'Kids Water Bottle',
                'price' => 1200,
                'reviews_count' => 18,
                'image' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=600',
            ],
            (object) [
                'name' => 'Color Pencil Pack',
                'price' => 850,
                'reviews_count' => 31,
                'image' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=600',
            ],
            (object) [
                'name' => 'School Uniform',
                'price' => 2800,
                'reviews_count' => 12,
                'image' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=600',
            ],
            (object) [
                'name' => 'Lunch Box',
                'price' => 1500,
                'reviews_count' => 27,
                'image' => 'https://images.unsplash.com/photo-1553531889-56cc480ac5cb?w=600',
            ],
        ]);
    @endphp

    {{-- ===== BEST SELLERS ===== --}}
    @if (isset($bestSellers) && $bestSellers->count())
        <section class="mb-12">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-2xl font-bold text-navy-900 flex items-center gap-2"><i
                        class="fa-solid fa-star text-gold-500"></i> Best Sellers</h2>
                <a href="#" class="bg-navy-800 text-white px-4 py-2 rounded-md text-sm">View All Products <i
                        class="fa-solid fa-arrow-right ml-1"></i></a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach ($bestSellers as $product)
                    <div
                        class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-md transition relative filter-con">
                        <button
                            class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-slate-400 hover:text-rose-500 z-10"><i
                                class="fa-regular fa-heart"></i></button>
                        {{-- FIXED IMAGE BOX --}}
                        <div class="card-img-box p-5 bg-slate-50">
                            <img class="card-img" src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-navy-900 text-sm filter-name">{{ $product->name }}</h3>
                            <div class="flex items-center gap-1 text-gold-500 text-xs mt-1">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star-half-stroke"></i>
                                <span class="text-slate-500 ml-1">({{ $product->reviews_count ?? 0 }})</span>
                            </div>
                            <p class="mt-2 font-bold text-navy-900">PKR {{ number_format($product->price) }}</p>
                            <button
                                class="mt-3 w-full border border-navy-200 text-navy-800 py-2 rounded-md text-sm font-semibold hover:bg-navy-50">
                                <i class="fa-solid fa-cart-shopping mr-1"></i> Add to Cart
                            </button>
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
        $(document).ready(function() {

            $(".filter-search").on("keyup", function() {
                var value = $(this).val().toLowerCase();

                $(".filter-con").each(function() {

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
