@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">

        <!-- Breadcrumb -->
        <div class="text-xs text-slate-500 flex items-center gap-2 mb-6">
            <a href="{{ route('home') }}" class="hover:underline">Home</a>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <a href="{{ route('cart.index') }}" class="hover:underline">Shopping Cart</a>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <span class="text-navy font-semibold">Checkout</span>
        </div>

        @php
            // Fetch product models to display images in the summary
            $productIds = collect($cart)->pluck('id')->toArray();
            $products = \App\Models\Product::whereIn('id', $productIds)->get()->keyBy('id');
            
            // Subtotal and shipping calculations
            $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
            $shippingLimit = 1500;
            $shippingCost = $subtotal >= $shippingLimit ? 0 : 150;
            $grandTotal = $subtotal + $shippingCost;
            $itemCount = count($cart);
        @endphp

        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0B1B47] mb-8">Secure Checkout</h1>

        <!-- Two-column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left: Shipping & Payment Details Form -->
            <div class="lg:col-span-7 space-y-6">
                
                <form method="POST" action="{{ route('checkout.place') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Section 1: Shipping Information -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-sm space-y-4">
                        <div class="flex items-center gap-2.5 border-b border-slate-100 pb-3 mb-4">
                            <span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">1</span>
                            <h2 class="font-extrabold text-[#0B1B47] text-base sm:text-lg">Shipping Information</h2>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <!-- Full Name -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Full Name</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-user text-sm"></i>
                                    </span>
                                    <input name="customer_name" required type="text" placeholder="Enter your full name"
                                        class="w-full border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition"
                                        value="{{ old('customer_name') }}">
                                </div>
                                @error('customer_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Mobile Number -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Mobile Number</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-phone text-sm"></i>
                                    </span>
                                    <input name="mobile" required type="tel" placeholder="e.g. 03001234567"
                                        class="w-full border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition"
                                        value="{{ old('mobile') }}">
                                </div>
                                @error('mobile')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Shipping Address -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Shipping Address</label>
                                <div class="relative">
                                    <span class="absolute left-3.5 top-3 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-location-dot text-sm"></i>
                                    </span>
                                    <textarea name="address" required placeholder="Complete home/apartment address, street, sector, city"
                                        class="w-full border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm min-h-[100px] focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">{{ old('address') }}</textarea>
                                </div>
                                @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Payment Method Selection -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-sm space-y-4">
                        <div class="flex items-center gap-2.5 border-b border-slate-100 pb-3 mb-4">
                            <span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">2</span>
                            <h2 class="font-extrabold text-[#0B1B47] text-base sm:text-lg">Payment Method</h2>
                        </div>

                        <!-- Pre-selected payment choice -->
                        <div class="border border-indigo-200 bg-indigo-50/30 rounded-2xl p-4 flex items-start gap-3 relative cursor-pointer">
                            <div class="w-5 h-5 rounded-full bg-indigo-600 flex items-center justify-center text-white text-[10px] shrink-0 mt-0.5">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-[#0B1B47] text-sm">Bank Transfer / Easypaisa / JazzCash</h3>
                                <p class="text-slate-500 text-xs mt-1 leading-relaxed">
                                    Pay securely using online banking, Easypaisa, or JazzCash. You will upload the payment receipt/screenshot in the next step.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <div>
                        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#0B1B47] hover:bg-indigo-700 text-white font-extrabold py-4 rounded-2xl text-base transition shadow-sm hover:shadow duration-150 cursor-pointer">
                            <i class="fa-solid fa-truck-ramp-box"></i> Place Order (PKR {{ number_format($grandTotal) }})
                        </button>
                        <p class="text-[11px] text-slate-400 text-center mt-3 flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-circle-info text-slate-300"></i> Guest checkout — No account registration required.
                        </p>
                    </div>

                </form>

            </div>

            <!-- Right: Order Summary Sidebar -->
            <div class="lg:col-span-5 bg-white rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-sm space-y-5 lg:sticky lg:top-[100px]">
                <h2 class="font-extrabold text-[#0B1B47] text-lg border-b border-slate-100 pb-3">Items Summary ({{ $itemCount }})</h2>
                
                <!-- Items list -->
                <div class="max-h-60 overflow-y-auto pr-1 space-y-4 divider-y">
                    @foreach ($cart as $key => $item)
                        @php
                            $p = $products->get($item['id']);
                        @endphp
                        <div class="flex items-center gap-3">
                            <!-- Image -->
                            <div class="w-12 h-12 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center p-1 shrink-0">
                                @if($p && !empty($p->images) && count($p->images) > 0)
                                    <img src="{{ asset('storage/' . $p->images[0]) }}" class="max-w-full max-h-full object-contain" alt="{{ $item['name'] }}">
                                @else
                                    <div class="text-xl text-slate-200">📚</div>
                                @endif
                            </div>
                            
                            <!-- Details -->
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-xs text-[#0B1B47] truncate" title="{{ $item['name'] }}">
                                    {{ $item['name'] }}
                                </h4>
                                <p class="text-[10px] text-slate-400 mt-0.5">Quantity: {{ $item['quantity'] }}</p>
                            </div>
                            
                            <!-- Price -->
                            <div class="text-right shrink-0">
                                <span class="font-extrabold text-xs text-[#0B1B47]">PKR {{ number_format($item['price'] * $item['quantity']) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Price totals -->
                <div class="space-y-3 text-sm border-t border-slate-100 pt-4">
                    <div class="flex justify-between text-slate-600">
                        <span>Items Subtotal</span>
                        <span class="font-bold text-[#0B1B47]">PKR {{ number_format($subtotal) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Shipping Delivery</span>
                        @if($shippingCost === 0)
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100 uppercase">Free</span>
                        @else
                            <span class="font-bold text-[#0B1B47]">PKR {{ number_format($shippingCost) }}</span>
                        @endif
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-4 flex justify-between items-baseline">
                    <span class="font-bold text-[#0B1B47] text-base">Grand Total</span>
                    <span class="font-extrabold text-orange-500 text-xl sm:text-2xl">PKR {{ number_format($grandTotal) }}</span>
                </div>

                <!-- Trust signals -->
                <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-slate-400 bg-slate-50/50 rounded-xl p-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-lock text-slate-400 text-center w-4"></i>
                        <span>Secure SSL encrypted connection</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-slate-400 text-center w-4"></i>
                        <span>100% Authentic school recommendations</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
