@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">

        <!-- Breadcrumb -->
        <div class="text-xs text-slate-500 flex items-center gap-2 mb-6">
            <a href="{{ route('home') }}" class="hover:underline">Home</a>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <span class="text-navy font-semibold">Shopping Cart</span>
        </div>

        @php
            $items = $cart['items'] ?? [];
            $itemCount = count($items);
            
            // Fetch product models to display images
            $productIds = collect($items)->where('type', 'product')->pluck('id')->toArray();
            $products = \App\Models\Product::whereIn('id', $productIds)->get()->keyBy('id');
            
            // Shipping calculation
            $shippingLimit = 1500;
            $shippingCost = $cart['total'] >= $shippingLimit ? 0 : 150;
            $grandTotal = $cart['total'] + $shippingCost;
        @endphp

        <div class="flex items-center justify-between border-b border-slate-200 pb-5 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0B1B47]">Shopping Cart</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">You have <span class="font-bold text-[#0B1B47]">{{ $itemCount }}</span> {{ Str::plural('item', $itemCount) }} in your cart.</p>
            </div>
            
            @if($itemCount > 0)
                <form method="POST" action="{{ route('cart.clear') }}">
                    @csrf
                    <button type="submit" class="text-xs sm:text-sm text-red-500 hover:text-red-700 font-semibold flex items-center gap-1.5 transition">
                        <i class="fa-solid fa-trash-can text-xs"></i> Clear Cart
                    </button>
                </form>
            @endif
        </div>

        @if ($itemCount === 0)
            <!-- Empty Cart State -->
            <div class="bg-white rounded-2xl border border-slate-200 p-12 sm:p-20 text-center max-w-md mx-auto shadow-sm">
                <div class="text-7xl mb-5">🛒</div>
                <h2 class="text-xl font-bold text-[#0B1B47] mb-2">Your Cart is Empty</h2>
                <p class="text-slate-500 text-sm mb-6">Looks like you haven't added anything to your cart yet. Discover our school bundles and products!</p>
                <a href="{{ route('schools.index') }}" class="inline-flex items-center gap-2 bg-[#0B1B47] hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded-xl text-sm transition shadow-sm">
                    <i class="fa-solid fa-school text-sm"></i> Browse Schools
                </a>
            </div>
        @else
            <!-- Main Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                <!-- Left: Cart Items List -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach ($items as $key => $item)
                        @php
                            $p = $products->get($item['id']);
                            $hasDiscount = $p ? ($p->discount_price && $p->discount_price < $p->price) : false;
                        @endphp
                        <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 flex gap-4 relative shadow-sm hover:border-slate-300 transition duration-150">
                            
                            <!-- Product Image -->
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center p-2 shrink-0">
                                @if($p && !empty($p->images) && count($p->images) > 0)
                                    <img src="{{ asset('storage/' . $p->images[0]) }}" class="max-w-full max-h-full object-contain" alt="{{ $item['name'] }}">
                                @else
                                    <div class="text-3xl text-slate-200">📚</div>
                                @endif
                            </div>

                            <!-- Item Details -->
                            <div class="flex-1 flex flex-col justify-between min-w-0">
                                <div class="flex justify-between items-start gap-2">
                                    <div>
                                        <h3 class="font-bold text-sm sm:text-base text-[#0B1B47] hover:text-indigo-600 transition truncate pr-4">
                                            @if($p)
                                                <a href="{{ route('product.show', $p) }}">{{ $item['name'] }}</a>
                                            @else
                                                {{ $item['name'] }}
                                            @endif
                                        </h3>
                                        <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">
                                            @if($p && $p->category)
                                                Category: {{ $p->category->name }}
                                            @else
                                                School Essential
                                            @endif
                                        </p>
                                    </div>

                                    <!-- Delete Button -->
                                    <form method="POST" action="{{ route('cart.remove', $key) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-red-500 text-base p-1 transition" title="Remove Item">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- Quantity Selector and Price Row -->
                                <div class="flex flex-wrap items-center justify-between gap-3 mt-3">
                                    <!-- Quantity Selector form -->
                                    <form method="POST" action="{{ route('cart.update', $key) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden bg-slate-50 w-24">
                                            <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="w-8 h-8 flex items-center justify-center hover:bg-slate-200 text-slate-500 font-bold transition">-</button>
                                            <input type="text" readonly value="{{ $item['quantity'] }}" class="w-8 text-center text-xs font-semibold bg-transparent border-0 focus:ring-0">
                                            <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="w-8 h-8 flex items-center justify-center hover:bg-slate-200 text-slate-500 font-bold transition">+</button>
                                        </div>
                                    </form>

                                    <!-- Price Details -->
                                    <div class="text-right">
                                        <span class="text-xs text-slate-400 block sm:inline mr-2">PKR {{ number_format($item['price']) }} each</span>
                                        <span class="text-sm sm:text-base font-extrabold text-[#0B1B47]">PKR {{ number_format($item['price'] * $item['quantity']) }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Right: Order Summary Sidebar -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-sm space-y-5 lg:sticky lg:top-[100px]">
                    <h2 class="font-extrabold text-[#0B1B47] text-lg border-b border-slate-100 pb-3">Order Summary</h2>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal</span>
                            <span class="font-bold text-[#0B1B47]">PKR {{ number_format($cart['total']) }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600 items-center">
                            <span>Shipping</span>
                            @if($shippingCost === 0)
                                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-100 uppercase">Free</span>
                            @else
                                <span class="font-bold text-[#0B1B47]">PKR {{ number_format($shippingCost) }}</span>
                            @endif
                        </div>
                        
                        @if($shippingCost > 0)
                            <div class="bg-indigo-50/50 border border-indigo-100 rounded-xl p-3 text-xs text-indigo-700 mt-2">
                                <i class="fa-solid fa-circle-info mr-1"></i> Add items worth <strong class="text-indigo-900">PKR {{ number_format($shippingLimit - $cart['total']) }}</strong> more for <strong class="text-indigo-900">FREE delivery</strong>!
                            </div>
                        @endif
                    </div>

                    <div class="border-t border-slate-100 pt-4 flex justify-between items-baseline">
                        <span class="font-bold text-[#0B1B47] text-base">Total amount</span>
                        <span class="font-extrabold text-orange-500 text-xl sm:text-2xl">PKR {{ number_format($grandTotal) }}</span>
                    </div>

                    <!-- Checkout CTA Button -->
                    <div class="pt-2">
                        <a href="{{ route('checkout.show') }}" class="w-full flex items-center justify-center gap-2 bg-[#0B1B47] hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl transition shadow-sm hover:shadow duration-150">
                            <i class="fa-solid fa-shield-halved text-sm"></i> Proceed to Checkout
                        </a>
                    </div>

                    <!-- Safe shopping notices -->
                    <div class="pt-3 border-t border-slate-100 space-y-2.5 text-xs text-slate-500">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-lock text-indigo-600 text-center w-4 text-sm"></i>
                            <span>Secure checkout & transactions</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-rotate-left text-indigo-600 text-center w-4 text-sm"></i>
                            <span>Hassle-free 7-day return policy</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-truck-fast text-indigo-600 text-center w-4 text-sm"></i>
                            <span>Fast delivery nationwide across Pakistan</span>
                        </div>
                    </div>
                </div>

            </div>
        @endif

    </div>
</div>
@endsection
