@extends('layouts.app')

@section('content')

    <section
        class="bg-gradient-to-br from-indigo-700 via-indigo-600 to-purple-700 text-white rounded-3xl p-8 sm:p-12 mb-10 shadow-xl relative overflow-hidden">
        <div class="absolute right-0 top-0 opacity-10 translate-x-6 -translate-y-6 pointer-events-none">
            <span class="text-[180px] font-bold">🛒</span>
        </div>

        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 relative z-10">
            <div
                class="w-20 h-20 bg-white/10 backdrop-blur-md text-white rounded-2xl flex items-center justify-center text-4xl shadow-inner border border-white/20 shrink-0">
                @if (str_contains(strtolower($category->name), 'book'))
                    📚
                @elseif(str_contains(strtolower($category->name), 'uniform'))
                    👕
                @else
                    🎒
                @endif
            </div>

            <div>
                <span
                    class="text-xs font-bold uppercase tracking-widest bg-yellow-400 text-indigo-950 px-2.5 py-1 rounded-md mb-2 inline-block">
                    Category Collection
                </span>
                <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight">
                    {{ $category->name }}
                </h1>
                <p class="mt-2 text-indigo-100 max-w-xl text-sm sm:text-base opacity-90">
                    Explore high-quality school essentials curated strictly according to standard campus requirements.
                </p>
                <div
                    class="mt-4 inline-flex items-center gap-1.5 bg-indigo-950/30 border border-indigo-400/30 px-4 py-1.5 rounded-full text-xs font-medium backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    {{ $products->total() }} Products Available
                </div>
            </div>
        </div>
    </section>

    <div
        class="bg-gray-50 rounded-2xl border border-gray-100 p-6 mb-10 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="text-3xl bg-white p-3 rounded-xl shadow-sm border border-gray-100 shrink-0">
                ✨
            </div>
            <div>
                <h2 class="font-bold text-lg text-gray-800">
                    Premium Quality School Supplies
                </h2>
                <p class="text-gray-500 text-sm mt-0.5">
                    Every product is double-checked for durability, fine fabric quality, and precise publishing syllabus.
                </p>
            </div>
        </div>
    </div>

    @if ($products->count())
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
            @foreach ($products as $product)
                <a href="{{ route('product.show', $product) }}"
                    class="group bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">

                    <!-- Product Image -->

                    <div class="h-60 bg-gray-100 flex items-center justify-center">

                        @if (count($product->images))
                            <img src="{{ app()->environment('local')
                                ? asset('storage/' . $product->images[0])
                                : asset('storage/app/public/' . $product->images[0]) }}"
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="text-7xl">
                                🎒
                            </div>
                        @endif

                    </div>

                    <!-- Product Content -->

                        <div class="p-5">
                            <h3
                                class="font-bold text-base sm:text-lg text-gray-800 group-hover:text-indigo-600 transition-colors line-clamp-2 min-h-[3.5rem] leading-snug">
                                {{ $product->name }}
                            </h3>
                            <p class="text-gray-400 text-xs mt-1.5 flex items-center gap-1">
                                <span>Grade Verified</span> • <span>In Stock</span>
                            </p>
                        </div>
                    </div>

                    <div class="px-5 pb-5 pt-3 border-t border-gray-50 bg-gray-50/30 flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400 uppercase font-semibold tracking-wider">Price</span>
                            <span class="text-xl font-black text-indigo-600">
                                Rs. {{ number_format($product->effectivePrice()) }}
                            </span>
                        </div>
                        <span
                            class="bg-indigo-600 text-white group-hover:bg-indigo-700 px-4 py-2 rounded-xl text-xs font-bold transition-colors shadow-sm">
                            Buy Now
                        </span>
                    </div>

                </a>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-3xl border border-gray-100 p-12 text-center shadow-sm max-w-xl mx-auto my-12">
            <div class="text-6xl mb-4">📦</div>
            <h2 class="text-2xl font-extrabold text-gray-800 mb-2">
                No Products Found
            </h2>
            <p class="text-gray-500 text-sm leading-relaxed">
                We are currently uploading stock for <strong class="text-indigo-600">{{ $category->name }}</strong>. Please
                check back in a few hours or contact support for manual ordering.
            </p>
        </div>
    @endif

    @if ($products->hasPages())
        <div class="mt-16 flex justify-center">
            <div class="bg-white px-4 py-2 rounded-2xl shadow-sm border border-gray-100">
                {{ $products->links() }}
            </div>
        </div>
    @endif

    <section class="mt-24">
        <div
            class="bg-gradient-to-br from-gray-900 to-indigo-950 text-white rounded-3xl p-8 sm:p-12 text-center shadow-xl relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 opacity-5 pointer-events-none">
                <span class="text-[160px]">🏫</span>
            </div>

            <div class="relative z-10 max-w-2xl mx-auto">
                <h2 class="text-2xl sm:text-4xl font-extrabold mb-4 tracking-tight">
                    Looking For Complete Bundles?
                </h2>
                <p class="text-gray-300 opacity-90 mb-8 text-sm sm:text-base max-w-lg mx-auto">
                    Instead of buying single items, you can search your school directly to get the complete textbook
                    packages instantly.
                </p>
                <a href="{{ route('schools.index') }}"
                    class="inline-flex items-center justify-center bg-white text-indigo-950 px-7 py-3.5 rounded-xl font-bold hover:bg-indigo-50 hover:-translate-y-0.5 transition-all duration-200 transform shadow-md">
                    Find My School Syllabus
                </a>
            </div>
        </div>
    </section>

@endsection
