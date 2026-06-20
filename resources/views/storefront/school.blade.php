@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen pb-12">

    <!-- School Banner -->
    <section class="relative h-[250px] sm:h-72 md:h-80 overflow-hidden">
        <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1600&h=500&q=80" class="w-full h-full object-cover" alt="School Banner">

        <div class="absolute inset-0 bg-slate-950/70"></div>

        <div class="absolute inset-0 flex items-center py-6 sm:py-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 w-full">
                <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6 text-center sm:text-left">

                    <div class="h-20 w-20 sm:h-24 sm:w-24 rounded-2xl bg-white p-2 shadow-lg flex items-center justify-center shrink-0 border border-white/20">
                        <img src="https://cdn-icons-png.flaticon.com/512/2436/2436636.png"
                            class="w-full h-full object-contain" alt="School Icon">
                    </div>

                    <div class="text-white">
                        <span class="inline-block bg-yellow-400 text-slate-900 text-[10px] font-bold px-3 py-0.5 rounded-full mb-2 uppercase tracking-wider">Official Curriculum</span>
                        <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight">
                            {{ $school->name }}
                        </h1>

                        <p class="mt-2 text-xs sm:text-sm text-slate-200 max-w-xl leading-relaxed">
                            Find class-wise textbooks, exact uniform sizes, official diaries, and curriculum supplies recommended by {{ $school->name }}.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 py-8 sm:py-10">

        <!-- Classes Section -->
        <section class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg sm:text-2xl font-extrabold text-[#0B1B47]">
                    🏫 Browse By Class
                </h2>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4">
                @forelse ($school->classes as $class)
                    <a href="{{ route('bundle.show', [$school, $class->slug]) }}"
                        class="bg-white rounded-2xl p-5 sm:p-6 text-center border border-slate-200 hover:border-indigo-300 shadow-sm hover:shadow transition duration-200 group">
                        <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto text-lg font-bold mb-3 group-hover:bg-indigo-600 group-hover:text-white transition duration-200">
                            {{ substr($class->name, 0, 2) }}
                        </div>
                        <h3 class="font-bold text-sm sm:text-base text-[#0B1B47]">{{ $class->name }}</h3>
                        <p class="text-[11px] text-slate-400 mt-1">
                            Books & Supplies
                        </p>
                    </a>
                @empty
                    <div class="col-span-full flex items-center justify-center py-12 bg-white rounded-2xl border border-slate-200">
                        <div class="text-center p-4">
                            <span class="text-4xl block mb-3">📦</span>
                            <h3 class="text-sm font-bold text-[#0B1B47]">No Classes Found</h3>
                            <p class="text-slate-400 text-xs mt-1">There are currently no classes active for this school.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- School Essentials -->
        <section class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg sm:text-2xl font-extrabold text-[#0B1B47]">
                    🎒 School Essentials
                </h2>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
                @forelse ($school->products as $product)
                    @php
                        $wishlist = session('wishlist', []);
                        $inWishlist = in_array($product->id, $wishlist);
                        $hasDiscount = $product->discount_price && $product->discount_price < $product->price;
                    @endphp
                    <div class="group bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow transition duration-300 flex flex-col justify-between">
                        
                        <!-- Image Area -->
                        <div class="relative bg-slate-50 aspect-square flex items-center justify-center overflow-hidden">
                            <a href="{{ route('product.show', $product) }}" class="w-full h-full flex items-center justify-center p-3">
                                @if(!empty($product->images) && count($product->images) > 0)
                                    <img src="{{ asset('storage/' . $product->images[0]) }}"
                                        class="max-w-full max-h-full object-contain transition duration-300 group-hover:scale-105"
                                        alt="{{ $product->name }}">
                                @else
                                    <div class="text-5xl text-slate-200 select-none">🏫</div>
                                @endif
                            </a>

                            <!-- Badge -->
                            <span class="absolute top-2 left-2 bg-indigo-50 text-indigo-700 text-[10px] font-bold px-2 py-0.5 rounded-full border border-indigo-100">School Item</span>
                            @if($hasDiscount)
                                @php $pct = round((($product->price - $product->discount_price) / $product->price) * 100); @endphp
                                <span class="absolute top-2 right-2 bg-orange-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">-{{ $pct }}%</span>
                            @endif
                        </div>

                        <!-- Content Area -->
                        <div class="p-3 sm:p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-xs sm:text-sm text-[#0B1B47] line-clamp-2 min-h-[36px] leading-tight">
                                    <a href="{{ route('product.show', $product) }}" class="hover:text-indigo-600 transition">{{ $product->name }}</a>
                                </h3>
                                <p class="text-[10px] text-slate-400 mt-1">Required curriculum item</p>
                            </div>

                            <div class="mt-4">
                                <div class="flex items-baseline gap-1.5 mb-3">
                                    <span class="text-orange-500 font-extrabold text-sm sm:text-base">PKR {{ number_format($product->effectivePrice()) }}</span>
                                    @if($hasDiscount)
                                        <span class="text-[11px] text-slate-400 line-through">PKR {{ number_format($product->price) }}</span>
                                    @endif
                                </div>

                                <form method="POST" action="{{ route('cart.addProduct', $product) }}">
                                    @csrf
                                    <button type="submit" 
                                        class="w-full flex items-center justify-center gap-1.5 text-xs font-semibold py-2 rounded-xl transition-all duration-200
                                            {{ $product->stock > 0 ? 'bg-[#0B1B47] hover:bg-indigo-700 text-white cursor-pointer shadow-sm' : 'bg-slate-100 text-slate-400 cursor-not-allowed' }}"
                                        {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                        <i class="fa-solid fa-cart-plus text-[11px]"></i>
                                        {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full flex items-center justify-center py-12 bg-white rounded-2xl border border-slate-200">
                        <div class="text-center p-4">
                            <span class="text-4xl block mb-3">🎒</span>
                            <h3 class="text-sm font-bold text-[#0B1B47]">No Essentials Found</h3>
                            <p class="text-slate-400 text-xs mt-1">Essentials will appear once assigned to this school.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- General Accessories -->
        <section>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg sm:text-2xl font-extrabold text-[#0B1B47]">
                    ✏️ General Accessories
                </h2>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
                @forelse ($products as $product)
                    @php
                        $hasDiscount = $product->discount_price && $product->discount_price < $product->price;
                    @endphp
                    <div class="group bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow transition duration-300 flex flex-col justify-between">
                        
                        <!-- Image Area -->
                        <div class="relative bg-slate-50 aspect-square flex items-center justify-center overflow-hidden">
                            <a href="{{ route('product.show', $product) }}" class="w-full h-full flex items-center justify-center p-3">
                                @if(!empty($product->images) && count($product->images) > 0)
                                    <img src="{{ asset('storage/' . $product->images[0]) }}"
                                        class="max-w-full max-h-full object-contain transition duration-300 group-hover:scale-105"
                                        alt="{{ $product->name }}">
                                @else
                                    <div class="text-5xl text-slate-200 select-none">✏️</div>
                                @endif
                            </a>

                            <!-- Discount badge -->
                            @if($hasDiscount)
                                @php $pct = round((($product->price - $product->discount_price) / $product->price) * 100); @endphp
                                <span class="absolute top-2 right-2 bg-orange-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">-{{ $pct }}%</span>
                            @endif
                        </div>

                        <!-- Content Area -->
                        <div class="p-3 sm:p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-xs sm:text-sm text-[#0B1B47] line-clamp-2 min-h-[36px] leading-tight">
                                    <a href="{{ route('product.show', $product) }}" class="hover:text-indigo-600 transition">{{ $product->name }}</a>
                                </h3>
                                <p class="text-[10px] text-slate-400 mt-1">Suitable for all schools</p>
                            </div>

                            <div class="mt-4">
                                <div class="flex items-baseline gap-1.5 mb-3">
                                    <span class="text-orange-500 font-extrabold text-sm sm:text-base">PKR {{ number_format($product->effectivePrice()) }}</span>
                                    @if($hasDiscount)
                                        <span class="text-[11px] text-slate-400 line-through">PKR {{ number_format($product->price) }}</span>
                                    @endif
                                </div>

                                <form method="POST" action="{{ route('cart.addProduct', $product) }}">
                                    @csrf
                                    <button type="submit" 
                                        class="w-full flex items-center justify-center gap-1.5 text-xs font-semibold py-2 rounded-xl transition-all duration-200
                                            {{ $product->stock > 0 ? 'bg-[#0B1B47] hover:bg-indigo-700 text-white cursor-pointer shadow-sm' : 'bg-slate-100 text-slate-400 cursor-not-allowed' }}"
                                        {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                        <i class="fa-solid fa-cart-plus text-[11px]"></i>
                                        {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full flex items-center justify-center py-12 bg-white rounded-2xl border border-slate-200">
                        <div class="text-center p-4">
                            <span class="text-4xl block mb-3">✏️</span>
                            <h3 class="text-sm font-bold text-[#0B1B47]">No Accessories Found</h3>
                            <p class="text-slate-400 text-xs mt-1">General stationery and accessories will appear here.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

    </div>
</div>
@endsection
