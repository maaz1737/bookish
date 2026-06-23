@extends('layouts.app')

@section('content')
    <style>
        /* Swiper Custom Pagination Styles */
        .heroSwiper .swiper-pagination-bullet,
        .schoolSwiper .swiper-pagination-bullet {
            width: 10px;
            height: 10px;
            background: #cbd5e1;
            opacity: 1;
        }

        .heroSwiper .swiper-pagination-bullet-active,
        .schoolSwiper .swiper-pagination-bullet-active {
            background: #1e3a8a;
            width: 28px;
            border-radius: 999px;
        }

        /* Swiper Navigation Buttons Custom Positioning */
        .swiper-button-prev {
            left: -35px;
            top: 50% !important;
            transform: translate(0%, -50%);
        }

        .swiper-button-next {
            right: -35px;
            top: 50% !important;
            transform: translate(0%, -50%);
        }

        @media (max-width: 768px) {
            .swiper-button-prev,
            .swiper-button-next {
                display: none;
            }
        }

        .category-prev.swiper-button-disabled,
        .category-next.swiper-button-disabled {
            display: none;  
        }
    </style>

    <section class="max-w-7xl mx-auto px-4 pt-6 relative">
    @if ($heroBanners->count() > 0)
        <div class="swiper heroSwiper overflow-hidden rounded-2xl shadow-md border border-slate-100/80">
            <div class="swiper-wrapper">
                @foreach ($heroBanners as $banner)
                    <div class="swiper-slide overflow-hidden rounded-xl bg-gradient-to-br from-slate-50 via-blue-50/40 to-slate-100/80">

                        <div class="grid grid-cols-1 md:grid-cols-12 items-center min-h-[500px] md:h-[540px]">

                            <div class="col-span-1 md:col-span-6 lg:col-span-7 h-[240px] sm:h-[300px] md:h-full w-full relative order-1 md:order-2 p-4 md:p-0 flex items-center justify-center">
                                <img src="{{ app()->environment('production')
                                    ? asset('storage/app/public/' . $banner->image_path)
                                    : asset('storage/' . $banner->image_path) }}"
                                    alt="{{ $banner->title ?? 'Banner Asset' }}"
                                    class="w-full h-full max-h-[220px] sm:max-h-[280px] md:max-h-none object-contain md:object-right mix-blend-multiply transition-all duration-300">
                            </div>
                            <div class="col-span-1 md:col-span-6 lg:col-span-5 px-6 pb-12 pt-4 md:py-10 md:pl-16 md:pr-4 space-y-6 text-slate-900 z-10 order-2 md:order-1 text-center md:text-left flex flex-col justify-center">

                                @if ($banner->top_tagline)
                                    <div class="inline-flex self-center md:self-start items-center gap-1.5 text-xs md:text-sm font-bold tracking-wider text-amber-600 bg-amber-50 px-2.5 py-1 rounded-md border border-amber-200/60 uppercase select-none">
                                        <span></span> {{ $banner->top_tagline }}
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
                                        <a href="{{ $banner->link }}"
                                            class="flex-1 inline-flex items-center justify-center bg-blue-950 hover:bg-blue-900 text-white font-bold text-xs md:text-sm px-4 py-3.5 rounded-xl shadow transition duration-300 text-center whitespace-nowrap">
                                            Shop by School &nbsp;→
                                        </a>
                                    @else
                                        <a href="{{ route('schools.index') }}"
                                            class="flex-1 inline-flex items-center justify-center bg-blue-950 hover:bg-blue-900 text-white font-bold text-xs md:text-sm px-4 py-3.5 rounded-xl shadow transition duration-300 text-center whitespace-nowrap">
                                            Shop by School &nbsp;→
                                        </a>
                                    @endif

                                    <a href="#categories-section"
                                        class="flex-1 inline-flex items-center justify-center bg-white hover:bg-slate-50 text-blue-950 border border-slate-200 font-bold text-xs md:text-sm px-4 py-3.5 rounded-xl shadow-sm transition duration-300 text-center whitespace-nowrap">
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
</section>

    <section class="max-w-7xl mx-auto px-4 py-16">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-blue-900">
                🏫 Popular Schools
            </h2>
            <a href="{{ route('schools.index') }}" class="font-semibold text-blue-900 hover:underline">
                View All →
            </a>
        </div>

        <div class="relative">
            <div class="swiper-button-prev !text-blue-900 !w-12 !h-12 bg-white rounded-full shadow-lg border after:!text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
            </div>

            <div class="swiper-button-next !text-blue-900 !w-12 !h-12 bg-white rounded-full shadow-lg border after:!text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18l6-6-6-6" />
                </svg>
            </div>

            <div class="swiper schoolSwiper">
                <div class="swiper-wrapper mb-6">
                    @foreach ($schools as $school)
                        <div class="swiper-slide pb-4">
                            <a href="{{ route('schools.show', $school) }}"
                                class="block bg-white rounded-2xl border p-6 shadow hover:shadow-xl transition h-full group">
                                <div class="flex gap-4 items-center">
                                    <div class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center text-3xl transition group-hover:scale-105">
                                        🏫
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-lg text-gray-900 group-hover:text-blue-900">
                                            {{ $school->name }}
                                        </h3>
                                        <p class="text-gray-500 text-sm">
                                            Books & Uniforms Available
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-5 bg-blue-900 group-hover:bg-blue-950 text-white text-center py-3 rounded-lg font-medium transition">
                                    View Classes →
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination mt-8"></div>
            </div>
        </div>
    </section>

    <section id="categories-section" class="py-10 max-w-7xl mx-auto px-4 scroll-mt-6">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="flex items-center gap-2 text-2xl font-bold text-brand">🛍️ Shop by Category</h2>
            <a href="#" class="text-sm font-medium text-brand hover:underline">View All Categories →</a>
        </div>

        <div class="relative">
            <button class="category-prev absolute -left-4 top-1/2 -translate-y-1/2 z-20 bg-white border border-gray-200 rounded-full w-9 h-9 flex items-center justify-center shadow hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
            </button>

            <div class="swiper categorySwiper">
                <div class="swiper-wrapper">
                    @foreach ($categories as $category)
                        <a href="{{ route('category.show', $category->slug) }}" class="swiper-slide h-auto block group">
                            <div class="flex h-full flex-col rounded-xl border border-slate-200 bg-white p-4 text-center shadow-sm hover:shadow-md transition">

                                <div class="mb-3 grid aspect-square place-items-center rounded-lg bg-brand-cream overflow-hidden">
                                    <img class="w-full h-full object-cover transition duration-300 group-hover:scale-105"
                                        src="{{ app()->environment('production')
                                            ? url('storage/app/public/' . $category->image)
                                            : asset('storage/' . $category->image) }}"
                                        alt="{{ $category->name }}">
                                </div>

                                <h3 class="font-bold text-gray-900 group-hover:text-blue-900">
                                    {{ $category->name }}
                                </h3>

                                <p class="mt-1 text-xs font-medium text-slate-500 line-clamp-2">
                                    {{ $category->description }}
                                </p>

                                <div class="mt-auto">
                                    <button class="mt-3 w-full bg-blue-900 text-white text-center rounded-md px-3 py-2 text-sm font-medium group-hover:bg-blue-950 transition">
                                        Shop {{ \Illuminate\Support\Str::limit($category->name, 9, '') }} →
                                    </button>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <button class="category-next absolute -right-4 top-1/2 -translate-y-1/2 z-20 bg-white border border-gray-200 rounded-full w-9 h-9 flex items-center justify-center shadow hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18l6-6-6-6" />
                </svg>
            </button>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-4">
        <div class="grid grid-cols-2 gap-4 rounded-2xl bg-red-100 p-6 md:grid-cols-4">
            <div class="flex items-start gap-3">
                <div class="rounded-lg bg-white p-2 text-2xl">🚚</div>
                <div>
                    <p class="font-bold text-brand">Fast Delivery</p>
                    <p class="text-xs text-slate-500">Nationwide delivery across Pakistan</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="rounded-lg bg-white p-2 text-2xl">📦</div>
                <div>
                    <p class="font-bold text-brand">Complete Bundles</p>
                    <p class="text-xs text-slate-500">Class-wise book packages &amp; uniform sets</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="rounded-lg bg-white p-2 text-2xl">🔒</div>
                <div>
                    <p class="font-bold text-brand">Secure Payments</p>
                    <p class="text-xs text-slate-500">100% secure checkout experience</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="rounded-lg bg-white p-2 text-2xl">📞</div>
                <div>
                    <p class="font-bold text-brand">Easy Returns</p>
                    <p class="text-xs text-slate-500">Hassle-free returns within 7 days</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 pt-6 pb-12">
        <div class="flex flex-col items-center gap-4 rounded-xl bg-blue-100 p-6 md:flex-row">
            <div class="flex items-center gap-3">
                <div class="grid h-10 w-10 place-items-center rounded-full bg-white text-brand">✉️</div>
                <div>
                    <p class="font-semibold">Subscribe to our newsletter</p>
                    <p class="text-xs text-slate-500">Get updates on new arrivals, offers and more.</p>
                </div>
            </div>
            <div class="flex flex-1 gap-2 w-full md:ml-6">
                <input type="email" placeholder="Enter your email"
                    class="flex-1 rounded-md border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand">
                <button class="rounded-md bg-blue-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-800 transition">Subscribe</button>
            </div>
            <div class="flex items-center gap-3 mt-4 md:mt-0">
                <span class="text-sm font-medium text-brand">Follow Us</span>
                <div class="bg-blue-700 hover:bg-blue-800 rounded-full w-8 h-8 flex items-center justify-center transition cursor-pointer">
                    <a class="text-white text-sm font-bold">f</a>
                </div>
                <div class="bg-blue-700 hover:bg-blue-800 rounded-full w-8 h-8 flex items-center justify-center transition cursor-pointer">
                    <a class="text-white text-xs font-bold">ig</a>
                </div>
                <div class="bg-blue-700 hover:bg-blue-800 rounded-full w-8 h-8 flex items-center justify-center transition cursor-pointer">
                    <a class="text-white text-sm font-bold">w</a>
                </div>
            </div>
        </div>
    </section>

    <script>
        new Swiper(".heroSwiper", {
            slidesPerView: 1,
            loop: true,
            autoplay: {
                delay: 4500,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });

        new Swiper(".schoolSwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                }
            }
        });

        new Swiper(".categorySwiper", {
            slidesPerView: 2,
            spaceBetween: 16,
            loop: false,
            navigation: {
                nextEl: ".category-next",
                prevEl: ".category-prev",
            },
            watchOverflow: true,
            breakpoints: {
                640: {
                    slidesPerView: 3
                },
                768: {
                    slidesPerView: 4
                },
                1024: {
                    slidesPerView: 6
                }
            }
        });
    </script>
@endsection