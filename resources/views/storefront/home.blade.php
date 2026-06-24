@extends('layouts.app')

@section('content')

    {{-- ===== HERO SECTION ===== --}}
    {{-- <section class="max-w-7xl mx-auto px-4 pt-6 mb-12 relative">
        @if ($heroBanners->count() > 0)
            <div class="swiper heroSwiper overflow-hidden rounded-2xl shadow-md border border-slate-100/80">
                <div class="swiper-wrapper">
                    @foreach ($heroBanners as $banner)
                        <div class="swiper-slide overflow-hidden rounded-xl bg-gradient-to-br from-slate-50 via-blue-50/40 to-slate-100/80">
                            
                            <div class="flex flex-col md:flex-row items-center min-h-[500px] md:h-[540px] w-full gap-6 p-6 md:p-0">
                                
                                <div class="w-full md:w-1/2 lg:w-5/12 px-2 md:pl-16 md:pr-4 space-y-6 text-slate-900 z-10 order-2 md:order-1 text-center md:text-left flex flex-col justify-center">

                                    @if ($banner->top_tagline)
                                        <div class="inline-flex self-center md:self-start items-center gap-1.5 text-xs md:text-sm font-bold tracking-wider text-amber-600 bg-amber-50 px-2.5 py-1 rounded-md border border-amber-200/60 uppercase select-none">
                                            {{ $banner->top_tagline }}
                                        </div>
                                    @endif

                                    @if ($banner->main_headline)
                                        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black text-blue-950 leading-[1.25] tracking-tight">
                                            {!! preg_replace(
                                                ['/\bYo\b/i', '/In One Place/i', '/One Place/i', '/Family Needs/i'],
                                                [
                                                    '<span class="bg-indigo-600 text-white inline-flex items-center justify-center px-1.5 py-0.5 rounded-sm mx-0.5 font-black select-none">Yo</span>',
                                                    ' <span class="text-amber-500">$0</span>',
                                                    '<span class="text-amber-500">$0</span>',
                                                    '<span class="text-blue-950">$0</span>',
                                                ],
                                                e($banner->main_headline),
                                            ) !!}
                                        </h1>
                                    @endif

                                    @if ($banner->subheadline || $banner->sub_headline)
                                        <p class="text-xs sm:text-sm md:text-base text-slate-600 font-medium leading-relaxed max-w-md mx-auto md:mx-0 block">
                                            {{ $banner->subheadline ?? $banner->sub_headline }}
                                        </p>
                                    @endif

                                    <div class="pt-2 flex flex-col sm:flex-row gap-2 sm:gap-3 w-full max-w-md mx-auto md:mx-0">
                                        @if ($banner->link)
                                            <a href="{{ $banner->link }}" class="flex-1 inline-flex items-center justify-center bg-blue-950 hover:bg-blue-900 text-white font-bold text-xs md:text-sm px-4 py-3.5 rounded-xl shadow transition duration-300 text-center whitespace-nowrap">
                                                Shop by School &nbsp;→
                                            </a>
                                        @else
                                            <a href="{{ route('schools.index') }}" class="flex-1 inline-flex items-center justify-center bg-blue-950 hover:bg-blue-900 text-white font-bold text-xs md:text-sm px-4 py-3.5 rounded-xl shadow transition duration-300 text-center whitespace-nowrap">
                                                Shop by School &nbsp;→
                                            </a>
                                        @endif

                                        <a href="#categories-section" class="flex-1 inline-flex items-center justify-center bg-white hover:bg-slate-50 text-blue-950 border border-slate-200 font-bold text-xs md:text-sm px-4 py-3.5 rounded-xl shadow-sm transition duration-300 text-center whitespace-nowrap">
                                            Shop All Categories &nbsp;→
                                        </a>
                                    </div>

                                    <div class="pt-4 border-t border-slate-200/60 grid grid-cols-3 gap-2 text-left max-w-md mx-auto md:mx-0">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 shrink-0 rounded-full bg-white flex items-center justify-center shadow-sm">
                                                <i class="fa-solid fa-shield-halved text-[11px] text-blue-950"></i>
                                            </div>
                                            <div>
                                                <div class="font-bold text-[11px] text-slate-900 leading-tight">100% Original</div>
                                                <div class="text-[9px] text-gray-500 font-medium">Authentic</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 shrink-0 rounded-full bg-white flex items-center justify-center shadow-sm">
                                                <i class="fa-solid fa-truck text-[11px] text-blue-950"></i>
                                            </div>
                                            <div>
                                                <div class="font-bold text-[11px] text-slate-900 leading-tight">Fast Delivery</div>
                                                <div class="text-[9px] text-gray-500 font-medium">Pakistan</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 shrink-0 rounded-full bg-white flex items-center justify-center shadow-sm">
                                                <i class="fa-solid fa-rotate-left text-[11px] text-blue-950"></i>
                                            </div>
                                            <div>
                                                <div class="font-bold text-[11px] text-slate-900 leading-tight">Easy Returns</div>
                                                <div class="text-[9px] text-gray-500 font-medium">7 Days</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full md:w-1/2 lg:w-7/12 h-[260px] sm:h-[320px] md:h-full relative order-1 md:order-2 flex items-center justify-center md:justify-end p-4 md:pr-12">
                                    <img src="{{ app()->environment('production')
                                        ? asset('storage/app/public/' . $banner->image_path)
                                        : asset('storage/' . $banner->image_path) }}"
                                        alt="{{ $banner->title ?? 'Banner Asset' }}"
                                        class="max-w-full max-h-full md:w-auto h-auto object-contain mix-blend-multiply transition-all duration-300">
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination !bottom-4"></div>
            </div>
        @else
            <div class="overflow-hidden rounded-2xl shadow-sm border border-slate-100">
                <img src="{{ asset('storage/logo/paf-banner.png') }}" alt="Default Fallback Banner" class="w-full object-cover">
            </div>
        @endif
    </section> --}}
<section class="max-w-7xl mx-auto px-4 pt-6 mb-12 relative">
    @if ($heroBanners->count() > 0)
        <div class="swiper heroSwiper overflow-hidden rounded-2xl shadow-md border border-slate-100/50">
            <div class="swiper-wrapper">
                @foreach ($heroBanners as $banner)
                    <div class="swiper-slide overflow-hidden rounded-xl bg-[#f0f3fc]">
                        
                        <div class="flex flex-col md:flex-row items-center justify-between min-h-[500px] md:h-[540px] w-full gap-8 p-6 sm:p-8 md:p-12">
                            
                            <div class="w-full md:w-7/12 lg:w-6/12 space-y-6 text-slate-900 z-10 order-2 md:order-1 text-center md:text-left flex flex-col justify-center">
                                
                                <p class="text-amber-500 font-bold text-xs md:text-sm tracking-wider uppercase select-none flex items-center justify-center md:justify-start gap-1.5">
                                    <i class="fa-solid fa-star text-xs"></i> WELCOME TO BOOKISH & BEYOND
                                </p>
                                
                                <h2 class="text-2xl sm:text-4xl md:text-4xl lg:text-[50px] font-black text-blue-950 leading-[1.2] tracking-tight max-w-full">
                                    Everything Your Family Needs,<br class="hidden lg:inline" />
                                    <span class="lg:block lg:mt-2">In <span class="text-amber-500">One Place</span></span>
                                </h2>
                                
                                <p class="text-xs sm:text-sm md:text-base text-slate-600 font-medium leading-relaxed max-w-md mx-auto md:mx-0">
                                    Books, Uniforms, Bags, Baby Wear & Thoughtful Gifts – All Handpicked for Quality You Can Trust.
                                </p>
                                
                                <div class="pt-2 flex flex-wrap md:flex-nowrap gap-3 w-full max-w-md mx-auto md:mx-0 justify-center md:justify-start">
                                    <a href="{{ $banner->link ?? route('schools.index') }}" class="bg-blue-950 hover:bg-blue-900 text-white font-bold text-xs md:text-sm px-6 py-3.5 rounded-xl shadow transition duration-300 text-center whitespace-nowrap inline-flex items-center gap-2">
                                        Shop by School &nbsp;→
                                    </a>
                                    <a href="#categories-section" class="bg-white hover:bg-slate-50 text-blue-950 border border-slate-200 font-bold text-xs md:text-sm px-6 py-3.5 rounded-xl shadow-sm transition duration-300 text-center whitespace-nowrap inline-flex items-center gap-2">
                                        Shop All Categories &nbsp;→
                                    </a>
                                </div>
                                
                                <div class="pt-6 border-t border-slate-200/40 grid grid-cols-3 gap-4 text-left max-w-xl mx-auto md:mx-0">
                                    <div class="flex items-center gap-2">
                                        <div class="w-9 h-9 shrink-0 rounded-full bg-white flex items-center justify-center shadow-sm">
                                            <i class="fa-solid fa-shield-halved text-xs text-blue-950"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-[10px] md:text-xs text-slate-900 leading-tight">100% Original</div>
                                            <div class="text-[9px] md:text-[10px] text-gray-500 font-medium">Authentic Products</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-9 h-9 shrink-0 rounded-full bg-white flex items-center justify-center shadow-sm">
                                            <i class="fa-solid fa-truck text-xs text-blue-950"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-[10px] md:text-xs text-slate-900 leading-tight">Fast Delivery</div>
                                            <div class="text-[9px] md:text-[10px] text-gray-500 font-medium">Across Pakistan</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-9 h-9 shrink-0 rounded-full bg-white flex items-center justify-center shadow-sm">
                                            <i class="fa-solid fa-rotate-left text-xs text-blue-950"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-[10px] md:text-xs text-slate-900 leading-tight">Easy Returns</div>
                                            <div class="text-[9px] md:text-[10px] text-gray-500 font-medium">Within 7 Days</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full md:w-5/12 lg:w-5/12 h-[240px] sm:h-[300px] md:h-full relative order-1 md:order-2 flex items-center justify-center md:justify-end p-2">
                                <img src="{{ app()->environment('production')
                                    ? asset('storage/app/public/' . $banner->image_path)
                                    : asset('storage/' . $banner->image_path) }}"
                                    alt="{{ $banner->title ?? 'Admin Banner Image' }}"
                                    class="max-w-full max-h-[90%] md:max-h-full md:w-auto h-auto object-contain mix-blend-multiply transition-all duration-300 filter drop-shadow-[0_12px_24px_rgba(15,23,42,0.05)]">
                            </div>
                            @if ($banner->link)</a>@endif
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
            <h2 class="text-2xl font-bold text-navy-900 flex items-center gap-2"><i class="fa-solid fa-bag-shopping text-navy-700"></i> Popular Schools</h2>
            <a href="#" class="bg-navy-800 text-white px-4 py-2 rounded-md text-sm">View All Schools <i class="fa-solid fa-arrow-right ml-1"></i></a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach ($schools as $i => $school)
                @php $bg = ['bg-navy-50', 'bg-amber-50', 'bg-rose-50'][$i % 3]; @endphp
                <a href="{{ route('schools.show', $school) }}" class="{{ $bg }} rounded-xl p-5">
                    <div class="flex items-start gap-4">
                        <div class="logo-box">
                            @if($school->logo ?? false)
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
                    <span href="#" class="mt-5 block text-center bg-navy-800 text-white py-2.5 rounded-md text-sm font-semibold">View Classes <i class="fa-solid fa-arrow-right ml-1"></i></span>
                 </a>
            @endforeach
        </div>
    </section>

    {{-- ===== SHOP BY CATEGORY ===== --}}
    <section class="mb-12" id="category-section">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-2xl font-bold text-navy-900 flex items-center gap-2"><i class="fa-solid fa-bag-shopping text-navy-700"></i> Shop by Category</h2>
            <a href="#" class="bg-navy-800 text-white px-4 py-2 rounded-md text-sm">View All Categories <i class="fa-solid fa-arrow-right ml-1"></i></a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-12">
            @foreach ($categories as $category)
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-md transition filter-con">
                    {{-- FIXED IMAGE BOX: all category images render at same size --}}
                    <div class="card-img-box bg-slate-50">
                        <img class="card-img" src="{{ app()->environment('production')
                        ? url('storage/app/public/' . $category->image)
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
                         <a href="{{ route('category.show', $category->slug) }}" class="mt-3 inline-flex items-center text-sm font-semibold text-navy-700">Explore Now <i class="fa-solid fa-arrow-right ml-1"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>



    @php
$bestSellers = collect([
    (object)[
        'name' => 'School Backpack',
        'price' => 3500,
        'reviews_count' => 24,
        'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600'
    ],
    (object)[
        'name' => 'Kids Water Bottle',
        'price' => 1200,
        'reviews_count' => 18,
        'image' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=600'
    ],
    (object)[
        'name' => 'Color Pencil Pack',
        'price' => 850,
        'reviews_count' => 31,
        'image' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=600'
    ],
    (object)[
        'name' => 'School Uniform',
        'price' => 2800,
        'reviews_count' => 12,
        'image' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=600'
    ],
    (object)[
        'name' => 'Lunch Box',
        'price' => 1500,
        'reviews_count' => 27,
        'image' => 'https://images.unsplash.com/photo-1553531889-56cc480ac5cb?w=600'
    ],
]);
@endphp

    {{-- ===== BEST SELLERS ===== --}}
    @if(isset($bestSellers) && $bestSellers->count())
        <section class="mb-12">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-2xl font-bold text-navy-900 flex items-center gap-2"><i class="fa-solid fa-star text-gold-500"></i> Best Sellers</h2>
                <a href="#" class="bg-navy-800 text-white px-4 py-2 rounded-md text-sm">View All Products <i class="fa-solid fa-arrow-right ml-1"></i></a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach ($bestSellers as $product)
                    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-md transition relative filter-con">
                        <button class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-slate-400 hover:text-rose-500 z-10"><i class="fa-regular fa-heart"></i></button>
                        {{-- FIXED IMAGE BOX --}}
                        <div class="card-img-box p-5 bg-slate-50">
                            <img class="card-img" src="{{ asset( $product->image) }}" alt="{{ $product->name }}">
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-navy-900 text-sm filter-name">{{ $product->name }}</h3>
                            <div class="flex items-center gap-1 text-gold-500 text-xs mt-1">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                                <span class="text-slate-500 ml-1">({{ $product->reviews_count ?? 0 }})</span>
                            </div>
                            <p class="mt-2 font-bold text-navy-900">PKR {{ number_format($product->price) }}</p>
                            <button class="mt-3 w-full border border-navy-200 text-navy-800 py-2 rounded-md text-sm font-semibold hover:bg-navy-50">
                                <i class="fa-solid fa-cart-shopping mr-1"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif


    {{-- ===== TRUST BAR ===== --}}
    <section class="max-w-7xl mx-auto px-4 ">
        <div class="bg-white rounded-xl border border-slate-200 p-6 grid grid-cols-2 md:grid-cols-5 gap-6 text-sm">
            <div class="flex gap-3"><i class="fa-solid fa-shield-halved text-2xl text-navy-700 shrink-0"></i><div><b>100% Original Products</b><p class="text-xs text-slate-500 mt-0.5">Sourced from authorized suppliers</p></div></div>
            <div class="flex gap-3"><i class="fa-solid fa-truck text-2xl text-navy-700 shrink-0"></i><div><b>Fast & Reliable Delivery</b><p class="text-xs text-slate-500 mt-0.5">Across Pakistan</p></div></div>
            <div class="flex gap-3"><i class="fa-solid fa-lock text-2xl text-navy-700 shrink-0"></i><div><b>Secure Payments</b><p class="text-xs text-slate-500 mt-0.5">Multiple payment options</p></div></div>
            <div class="flex gap-3"><i class="fa-solid fa-rotate-left text-2xl text-navy-700 shrink-0"></i><div><b>Easy Returns</b><p class="text-xs text-slate-500 mt-0.5">Hassle-free returns within 7 days</p></div></div>
            <div class="flex gap-3"><i class="fa-solid fa-headset text-2xl text-navy-700 shrink-0"></i><div><b>Dedicated Support</b><p class="text-xs text-slate-500 mt-0.5">We're here to help you anytime</p></div></div>
        </div>
    </section>

    <script>
        new Swiper('.heroSwiper', {
            loop: true,
            pagination: { el: '.swiper-pagination', clickable: true },
            autoplay: { delay: 4500 },
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
