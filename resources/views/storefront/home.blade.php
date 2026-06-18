@extends('layouts.app')

@section('content')
    <style>
        .schoolSwiper .swiper-pagination-bullet {
            width: 10px;
            height: 10px;
            background: #cbd5e1;
            opacity: 1;
        }

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
    <section class="max-w-7xl mx-auto px-4 pt-6">

        <section class="mx-auto max-w-7xl px-4 pt-6">
            <div class="overflow-hidden rounded-2xl">
                <img src="{{ asset('storage/logo/paf-banner.png') }}" alt="Everything for School &amp; Beyond" class="w-full">
            </div>
        </section>

    </section>

    <!-- POPULAR SCHOOLS -->

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

            <!-- Left Arrow -->
            <div
                class="swiper-button-prev !text-blue-900 !w-12 !h-12 bg-white rounded-full shadow-lg border after:!text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
            </div>

            <!-- Right Arrow -->
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

                <!-- Dots -->
                <div class="swiper-pagination mt-8"></div>

            </div>

        </div>
    </section>

    <!-- CATEGORIES -->
    <section class="py-10">

        <div class="relative max-w-7xl mx-auto px-4">

            <!-- Prev -->
            <button
                class="category-prev absolute -left-4 top-1/2 -translate-y-1/2 z-20 bg-white border border-gray-200 rounded-full w-9 h-9 flex items-center justify-center shadow hover:bg-gray-50">
                ‹
            </button>

            <!-- Swiper -->
            <div class="swiper categorySwiper">
                <div class="swiper-wrapper">

                    <!-- Slide -->
                    <div class="swiper-slide">
                        <div class="flex flex-col rounded-xl border border-slate-200 bg-white p-4 text-center shadow-sm">
                            <div class="mb-3 grid aspect-square place-items-center rounded-lg bg-brand-cream text-5xl">
                                <img src="{{ asset('storage/logo/pdf-banner.png') }}" alt="">
                            </div>
                            <h3 class="font-bold">Books</h3>
                            <p class="mt-1 text-xs text-slate-500">Explore a wide range of books.</p><button
                                class="mt-3 rounded-md border border-slate-200 px-3 py-2 text-xs font-medium text-brand hover:bg-brand-cream">Shop
                                Books →</button>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="flex flex-col rounded-xl border border-slate-200 bg-white p-4 text-center shadow-sm">
                            <div class="mb-3 grid aspect-square place-items-center rounded-lg bg-brand-cream text-5xl">📚
                            </div>
                            <h3 class="font-bold">Books</h3>
                            <p class="mt-1 text-xs text-slate-500">Explore a wide range of books.</p><button
                                class="mt-3 rounded-md border border-slate-200 px-3 py-2 text-xs font-medium text-brand hover:bg-brand-cream">Shop
                                Books →</button>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="flex flex-col rounded-xl border border-slate-200 bg-white p-4 text-center shadow-sm">
                            <div class="mb-3 grid aspect-square place-items-center rounded-lg bg-brand-cream text-5xl">📚
                            </div>
                            <h3 class="font-bold">Books</h3>
                            <p class="mt-1 text-xs text-slate-500">Explore a wide range of books.</p><button
                                class="mt-3 rounded-md border border-slate-200 px-3 py-2 text-xs font-medium text-brand hover:bg-brand-cream">Shop
                                Books →</button>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="flex flex-col rounded-xl border border-slate-200 bg-white p-4 text-center shadow-sm">
                            <div class="mb-3 grid aspect-square place-items-center rounded-lg bg-brand-cream text-5xl">📚
                            </div>
                            <h3 class="font-bold">Books</h3>
                            <p class="mt-1 text-xs text-slate-500">Explore a wide range of books.</p><button
                                class="mt-3 rounded-md border border-slate-200 px-3 py-2 text-xs font-medium text-brand hover:bg-brand-cream">Shop
                                Books →</button>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="flex flex-col rounded-xl border border-slate-200 bg-white p-4 text-center shadow-sm">
                            <div class="mb-3 grid aspect-square place-items-center rounded-lg bg-brand-cream text-5xl">📚
                            </div>
                            <h3 class="font-bold">Books</h3>
                            <p class="mt-1 text-xs text-slate-500">Explore a wide range of books.</p><button
                                class="mt-3 rounded-md border border-slate-200 px-3 py-2 text-xs font-medium text-brand hover:bg-brand-cream">Shop
                                Books →</button>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="flex flex-col rounded-xl border border-slate-200 bg-white p-4 text-center shadow-sm">
                            <div class="mb-3 grid aspect-square place-items-center rounded-lg bg-brand-cream text-5xl">📚
                            </div>
                            <h3 class="font-bold">Books</h3>
                            <p class="mt-1 text-xs text-slate-500">Explore a wide range of books.</p><button
                                class="mt-3 rounded-md border border-slate-200 px-3 py-2 text-xs font-medium text-brand hover:bg-brand-cream">Shop
                                Books →</button>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="flex flex-col rounded-xl border border-slate-200 bg-white p-4 text-center shadow-sm">
                            <div class="mb-3 grid aspect-square place-items-center rounded-lg bg-brand-cream text-5xl">📚
                            </div>
                            <h3 class="font-bold">Books</h3>
                            <p class="mt-1 text-xs text-slate-500">Explore a wide range of books.</p><button
                                class="mt-3 rounded-md border border-slate-200 px-3 py-2 text-xs font-medium text-brand hover:bg-brand-cream">Shop
                                Books →</button>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="flex flex-col rounded-xl border border-slate-200 bg-white p-4 text-center shadow-sm">
                            <div class="mb-3 grid aspect-square place-items-center rounded-lg bg-brand-cream text-5xl">📚
                            </div>
                            <h3 class="font-bold">Books</h3>
                            <p class="mt-1 text-xs text-slate-500">Explore a wide range of books.</p><button
                                class="mt-3 rounded-md border border-slate-200 px-3 py-2 text-xs font-medium text-brand hover:bg-brand-cream">Shop
                                Books →</button>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="flex flex-col rounded-xl border border-slate-200 bg-white p-4 text-center shadow-sm">
                            <div class="mb-3 grid aspect-square place-items-center rounded-lg bg-brand-cream text-5xl">📚
                            </div>
                            <h3 class="font-bold">Books</h3>
                            <p class="mt-1 text-xs text-slate-500">Explore a wide range of books.</p><button
                                class="mt-3 rounded-md border border-slate-200 px-3 py-2 text-xs font-medium text-brand hover:bg-brand-cream">Shop
                                Books →</button>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="flex flex-col rounded-xl border border-slate-200 bg-white p-4 text-center shadow-sm">
                            <div class="mb-3 grid aspect-square place-items-center rounded-lg bg-brand-cream text-5xl">📚
                            </div>
                            <h3 class="font-bold">Books</h3>
                            <p class="mt-1 text-xs text-slate-500">Explore a wide range of books.</p><button
                                class="mt-3 rounded-md border border-slate-200 px-3 py-2 text-xs font-medium text-brand hover:bg-brand-cream">Shop
                                Books →</button>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Next -->
            <button
                class="category-next absolute -right-4 top-1/2 -translate-y-1/2 z-20 bg-white border border-gray-200 rounded-full w-9 h-9 flex items-center justify-center shadow hover:bg-gray-50">
                ›
            </button>

        </div>
    </section>


    {{-- <section class="max-w-7xl mx-auto px-4 py-16">

        <div class="bg-yellow-50 rounded-3xl p-10">

            <div>

                <div class="">

                    <div class="">
                        <div>
                            <div class="text-4xl">🚚</div>
                            <h3 class="font-bold mt-3">Fast Delivery</h3>
                            <p class="text-gray-500 text-sm">
                                Nationwide delivery across Pakistan.
                            </p>
                        </div>
                    </div>

                    <div class="">
                        <div>
                            <div class="text-4xl">📦</div>
                            <h3 class="font-bold mt-3">Complete Bundles</h3>
                            <p class="text-gray-500 text-sm">
                                Class-wise book packages.
                            </p>
                        </div>
                    </div>

                    <div class="">
                        <div>
                            <div class="text-4xl">🔒</div>
                            <h3 class="font-bold mt-3">Secure Payments</h3>
                            <p class="text-gray-500 text-sm">
                                Safe checkout experience.
                            </p>
                        </div>
                    </div>

                    <div class="">
                        <div>
                            <div class="text-4xl">↩️</div>
                            <h3 class="font-bold mt-3">Easy Returns</h3>
                            <p class="text-gray-500 text-sm">
                                Hassle-free returns.
                            </p>
                        </div>
                    </div>

                </div>

                <div class="feature-prev"></div>
                <div class="feature-next"></div>
                <div class="feature-pagination"></div>

            </div>

        </div>

    </section> --}}
    <script>
        function createSwiper(selector, config) {
            return new Swiper(selector, config);
        }

        createSwiper(".schoolSwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
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
    </script>
    <script>
        new Swiper(".categorySwiper", {
            slidesPerView: 2,
            spaceBetween: 16,
            loop: false,
            navigation: {
                nextEl: ".category-next",
                prevEl: ".category-prev",
            },

            pagination: {
                el: ".category-pagination",
                clickable: true,
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
