@extends('layouts.app')

@section('content')
    <style>
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
    </style>

    <section class="max-w-7xl mx-auto px-4 pt-6 relative">
        @if ($heroBanners->count() > 0)
            <div class="swiper heroSwiper overflow-hidden rounded-2xl">
                <div class="swiper-wrapper">
                    @foreach ($heroBanners as $banner)
                        <div class="swiper-slide">
                            @if ($banner->link)
                                <a href="{{ $banner->link }}">
                            @endif
                            <img src="{{ asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title ?? 'Banner' }}"
                                class="w-full object-cover aspect-[3/1]">
                            @if ($banner->link)
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination !bottom-4"></div>
            </div>
        @else
            <div class="overflow-hidden rounded-2xl">
                <img src="{{ asset('storage/logo/paf-banner.png') }}" alt="Default Banner" class="w-full">
            </div>
        @endif
    </section>

    <section class="max-w-7xl mx-auto px-4 py-16">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-blue-900">
                🏫 Popular Schools
            </h2>
            <a href="{{ route('schools.index') }}" class="font-semibold text-blue-900">
                View All →
            </a>
        </div>

        <div class="relative">
            <div
                class="swiper-button-prev !text-blue-900 !w-12 !h-12 bg-white rounded-full shadow-lg border after:!text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
            </div>

            <div
                class="swiper-button-next !text-blue-900 !w-12 !h-12 bg-white rounded-full shadow-lg border after:!text-lg">
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
                                class="block bg-white rounded-2xl border p-6 shadow hover:shadow-xl transition h-full">
                                <div class="flex gap-4 items-center">
                                    <div
                                        class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center text-3xl">
                                        🏫
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-lg">
                                            {{ $school->name }}
                                        </h3>
                                        <p class="text-gray-500 text-sm">
                                            Books & Uniforms Available
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-5 bg-blue-900 text-white text-center py-3 rounded-lg font-medium">
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

    <section class="py-10">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="flex items-center gap-2 text-2xl font-bold text-brand">🛍️ Shop by Category</h2>
            <a href="#" class="text-sm font-medium text-brand">View All Categories →</a>
        </div>
        <div class="relative max-w-7xl mx-auto px-4">
            <button
                class="category-prev absolute -left-4 top-1/2 -translate-y-1/2 z-20 bg-white border border-gray-200 rounded-full w-9 h-9 flex items-center justify-center shadow hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
            </button>

            <div class="swiper categorySwiper">
                <div class="swiper-wrapper">

                    @foreach ($categories as $category)
                        <div class="swiper-slide h-auto">
                            <div
                                class="flex h-full flex-col rounded-xl border border-slate-200 bg-white p-4 text-center shadow-sm">

                                <div class="mb-3 grid aspect-square place-items-center rounded-lg bg-brand-cream text-5xl">
                                    <img class="w-full h-full" src="{{ asset('storage/logo/paf-banner.png') }}"
                                        alt="">
                                </div>

                                <h3 class="font-bold">
                                    {{ $category->name }}
                                </h3>

                                <p class="mt-1 text-xs font-bold text-slate-500">
                                    {{ \Illuminate\Support\Str::limit($category->description, 60, '') }}
                                </p>

                                <!-- PUSH BUTTON TO BOTTOM -->
                                <div class="mt-auto">
                                    <button
                                        class="mt-3 w-full bg-blue-900 text-white text-center rounded-md border border-slate-200 px-3 py-2 text-sm font-light hover:bg-brand-cream">
                                        Shop {{ \Illuminate\Support\Str::limit($category->name, 9, '') }} →
                                    </button>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button
                class="category-next absolute -right-4 top-1/2 -translate-y-1/2 z-20 bg-white border border-gray-200 rounded-full w-9 h-9 flex items-center justify-center shadow hover:bg-gray-50">
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

    <section class="mx-auto max-w-7xl px-4 pt-6">
        <div class="flex flex-col items-center gap-4 rounded-xl bg-blue-100 p-6 md:flex-row">
            <div class="flex items-center gap-3">
                <div class="grid h-10 w-10 place-items-center rounded-full bg-white text-brand">✉️</div>
                <div>
                    <p class="font-semibold">Subscribe to our newsletter</p>
                    <p class="text-xs text-slate-500">Get updates on new arrivals, offers and more.</p>
                </div>
            </div>
            <div class="flex flex-1 gap-2 md:ml-6">
                <input type="email" placeholder="Enter your email"
                    class="flex-1 rounded-md border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand">
                <div class="bg-blue-700 rounded-lg px-4">
                    <button class="rounded-md bg-brand px-5 py-2.5 text-sm font-semibold text-white">Subscribe</button>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium text-brand">Follow Us</span>
                <div class="bg-blue-700 rounded-full">
                    <a class="grid h-8 w-8 place-items-center rounded-full bg-brand text-white">f</a>
                </div>
                <div class="bg-blue-700 rounded-full">
                    <a class="grid h-8 w-8 place-items-center rounded-full bg-brand text-white">ig</a>
                </div>
                <div class="bg-blue-700 rounded-full">
                    <a class="grid h-8 w-8 place-items-center rounded-full bg-brand text-white">w</a>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Hero Slider Initialization
        new Swiper(".heroSwiper", {
            slidesPerView: 1,
            loop: true,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });

        // Schools Slider Initialization
        new Swiper(".schoolSwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            // autoplay: {
            //     delay: 4000,
            //     disableOnInteraction: false,
            // },
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

        // Categories Slider Initialization
        new Swiper(".categorySwiper", {
            slidesPerView: 2,
            spaceBetween: 16,
            loop: false,
            navigation: {
                nextEl: ".category-next",
                prevEl: ".category-prev",
            },
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
