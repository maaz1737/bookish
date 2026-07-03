@extends('layouts.app')

@section('title', 'Smart Saver Bundles — School Essentials | Bookish & Beyond')
@section('meta_description', 'Save big on school books, uniforms, bags and complete academic bundles. Shop Smart Saver Bundles at Bookish & Beyond.')

@section('content')
    <!-- Header Section -->
    <section class="bg-gradient-to-r from-indigo-900 via-navy-800 to-indigo-900 text-white rounded-3xl p-8 sm:p-12 mb-8 shadow-sm relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-amber-400/10 via-transparent to-transparent pointer-events-none"></div>
        <div class="max-w-3xl relative z-10">
            <span class="text-amber-400 text-xs font-extrabold uppercase tracking-wider bg-amber-400/15 border border-amber-400/30 rounded-full px-3, py-1 inline-block mb-3">
                <i class="fa-solid fa-bolt mr-1"></i> Special Offers
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-3 leading-tight">
                Smart Saver Bundles
            </h1>
            <p class="text-sm sm:text-base text-blue-100/90 max-w-2xl leading-relaxed">
                Save big by purchasing curated combinations of school essentials. We package books, bags, bottles, and stationery together at exclusive discounted rates to help you save time and money.
            </p>
        </div>
    </section>

    <!-- Breadcrumb -->
    <nav class="text-xs text-gray-500 flex items-center gap-1.5 mb-8">
        <a href="{{ url('/') }}" class="hover:text-[#0a1f44]"><i class="fa-solid fa-house text-xs"></i></a>
        <span>/</span>
        <span class="text-[#0a1f44] font-semibold">Smart Saver Bundles</span>
    </nav>

    <!-- Bundles Grid -->
    @if (isset($bundles) && $bundles->count())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
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
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full group">

                    {{-- ===== BUNDLE COLLAGE IMAGE AREA ===== --}}
                    <div class="relative overflow-hidden bg-gradient-to-br from-slate-50 via-blue-50/40 to-indigo-50 h-[200px]">

                        {{-- Discount Badge --}}
                        @if ($discount > 0)
                            <div class="absolute top-3 left-3 z-20 bg-gradient-to-r from-amber-400 to-orange-400 text-white text-[11px] font-black px-3 py-1 rounded-full shadow-md flex items-center gap-1">
                                <i class="fa-solid fa-bolt text-[9px]"></i> Save {{ rtrim(rtrim($discount, '0'), '.') }}%
                            </div>
                        @endif

                        {{-- Bundle count pill --}}
                        @if ($products->count() > 0)
                            <div class="absolute top-3 right-3 z-20 bg-white/80 backdrop-blur-sm text-[#0a1f44] text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm border border-slate-200">
                                {{ $products->count() }} items
                            </div>
                        @endif

                        @if ($imgCount === 0)
                            <div class="w-full h-full flex flex-col items-center justify-center gap-2 opacity-30">
                                <i class="fa-solid fa-boxes-stacked text-5xl text-slate-400"></i>
                                <span class="text-xs text-slate-400 font-medium">Bundle</span>
                            </div>

                        @elseif ($imgCount === 1)
                            <div class="w-full h-full flex items-center justify-center p-6">
                                <img src="{{ $imgHelper($prodImages[0]->images[0]) }}"
                                    class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-500"
                                    alt="{{ $prodImages[0]->name }}"
                                    onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}'">
                            </div>

                        @elseif ($imgCount === 2)
                            <div class="flex h-full">
                                @foreach ($prodImages as $prod)
                                    <div class="flex-1 flex items-center justify-center p-4 {{ !$loop->last ? 'border-r border-white/60' : '' }}">
                                        <img src="{{ $imgHelper($prod->images[0]) }}"
                                            class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-500"
                                            alt="{{ $prod->name }}"
                                            onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}'">
                                    </div>
                                @endforeach
                            </div>

                        @elseif ($imgCount === 3)
                            <div class="flex h-full">
                                @foreach ($prodImages as $prod)
                                    <div class="flex-1 flex items-center justify-center p-3 {{ !$loop->last ? 'border-r border-white/60' : '' }}">
                                        <img src="{{ $imgHelper($prod->images[0]) }}"
                                            class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-500"
                                            alt="{{ $prod->name }}"
                                            onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}'">
                                    </div>
                                @endforeach
                            </div>

                        @else
                            <div class="grid grid-cols-2 grid-rows-2 h-full">
                                @foreach ($prodImages as $prod)
                                    <div class="flex items-center justify-center p-3
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

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $bundles->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
            <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-4 text-[#0a1f44]">
                <i class="fa-solid fa-boxes-stacked text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-700">No Bundles Available Right Now</h3>
            <p class="text-gray-400 text-sm mt-1">Please check back soon for our saver packs.</p>
        </div>
    @endif

    <!-- Trust Bar -->
    <section class="bg-white rounded-xl border border-slate-200 p-6 grid grid-cols-2 md:grid-cols-5 gap-6 text-sm mt-12">
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
@endsection
