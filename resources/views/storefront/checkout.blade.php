@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-4">

        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Secure Checkout</h1>
            <p class="text-sm text-slate-500 mt-1">Please provide your delivery details below to finalize your order.</p>
        </div>

        <div class="grid lg:grid-cols-12 gap-8 items-start">

            <div class="lg:col-span-7">
                <form method="POST" action="{{ route('checkout.place') }}"
                    class="bg-white rounded-3xl border border-slate-100 p-6 sm:p-8 shadow-sm space-y-6">
                    @csrf

                    <div class="border-b border-slate-100 pb-4">
                        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            📦 Delivery Information
                        </h2>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-slate-700">Full Name</label>
                        <input type="text" name="customer_name" required placeholder="e.g., Muhammad Ali"
                            class="w-full bg-slate-50/60 border @error('customer_name') border-red-300 focus:ring-red-500/20 focus:border-red-500 @else border-slate-200 focus:ring-indigo-500/20 focus:border-indigo-500 @enderror rounded-xl px-4 py-3 text-base text-slate-800 placeholder-slate-400 outline-none focus:bg-white transition duration-200"
                            value="{{ old('customer_name') }}">
                        @error('customer_name')
                            <p class="text-red-500 text-xs font-medium mt-1 flex items-center gap-1">⚠️ {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-slate-700">Mobile Number</label>
                        <div class="relative flex items-center">
                            <span
                                class="absolute left-4 text-sm font-bold text-slate-400 border-r border-slate-200 pr-3 pointer-events-none">+92</span>
                            <input type="tel" name="mobile" required placeholder="3204735908"
                                class="w-full bg-slate-50/60 border @error('mobile') border-red-300 focus:ring-red-500/20 focus:border-red-500 @else border-slate-200 focus:ring-indigo-500/20 focus:border-indigo-500 @enderror rounded-xl pl-16 pr-4 py-3 text-base text-slate-800 placeholder-slate-400 outline-none focus:bg-white transition duration-200"
                                value="{{ old('mobile') }}">
                        </div>
                        @error('mobile')
                            <p class="text-red-500 text-xs font-medium mt-1 flex items-center gap-1">⚠️ {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-slate-700">Complete Shipping Address</label>
                        <textarea name="address" required rows="3" placeholder="House/Apartment No, Street Name, Area/Sector, City Name"
                            class="w-full bg-slate-50/60 border @error('address') border-red-300 focus:ring-red-500/20 focus:border-red-500 @else border-slate-200 focus:ring-indigo-500/20 focus:border-indigo-500 @enderror rounded-xl px-4 py-3 text-base text-slate-800 placeholder-slate-400 outline-none focus:bg-white transition duration-200 resize-none">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-xs font-medium mt-1 flex items-center gap-1">⚠️ {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-indigo-50/40 border border-indigo-100/60 rounded-2xl p-4 flex items-start gap-3">
                        <span class="text-xl mt-0.5">💵</span>
                        <div>
                            <h4 class="text-sm font-bold text-indigo-950">Cash on Delivery (COD)</h4>
                            <p class="text-xs text-indigo-700/80 mt-0.5 leading-relaxed">
                                Pay in cash at your doorstep upon receiving the parcel. No credit card required.
                            </p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-indigo-600 text-white py-4 rounded-xl font-bold text-base shadow-md hover:bg-indigo-700 hover:-translate-y-0.5 transform transition duration-200">
                            Confirm & Place Order
                        </button>
                        <p class="text-[11px] text-slate-400 text-center mt-3 flex items-center justify-center gap-1">
                            ⚡ Quick Checkout — No account creation or password required.
                        </p>
                    </div>
                </form>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm space-y-6 sticky top-24">
                    <h3 class="text-lg font-bold text-slate-800 border-b border-slate-50 pb-4">Your Basket Review</h3>

                    <div class="max-h-64 overflow-y-auto space-y-3 pr-1 divide-y divide-slate-50">
                        @foreach ($cart['items'] ?? [] as $item)
                            <div class="flex items-center justify-between pt-3 first:pt-0 gap-4">
                                <div class="flex items-center gap-3">
                                    <span class="text-lg bg-slate-50 p-2 rounded-lg border border-slate-100">
                                        @if (str_contains(strtolower($item['name']), 'uniform'))
                                            👕
                                        @else
                                            📚
                                        @endif
                                    </span>
                                    <div>
                                        <h4
                                            class="text-sm font-bold text-slate-800 line-clamp-1 max-w-[180px] sm:max-w-[240px]">
                                            {{ $item['name'] }}
                                        </h4>
                                        <p class="text-xs text-slate-400 mt-0.5">Qty: {{ $item['quantity'] }}</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-slate-700 shrink-0">
                                    Rs. {{ number_format($item['price'] * $item['quantity']) }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-slate-100 pt-4 space-y-3 text-sm">
                        <div class="flex justify-between text-slate-500">
                            <span>Items Subtotal</span>
                            <span class="font-medium text-slate-800">Rs. {{ number_format($cart['total'] ?? 0) }}</span>
                        </div>
                        <div class="flex justify-between text-slate-500">
                            <span>Delivery Charges</span>
                            <span
                                class="text-emerald-600 font-bold uppercase text-xs bg-emerald-50 px-2 py-0.5 rounded-md">FREE</span>
                        </div>

                        <div class="border-t border-slate-100 pt-4 flex justify-between items-baseline">
                            <span class="font-extrabold text-slate-900 text-base">Total Payable:</span>
                            <div class="text-right">
                                <span class="text-2xl font-black text-indigo-600 block">
                                    Rs. {{ number_format($cart['total'] ?? 0) }}
                                </span>
                                <span class="text-[10px] text-slate-400 block mt-0.5">Payable amount on arrival</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-slate-50/60 text-center">
                        <a href="{{ route('cart.index') }}"
                            class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                            ← Modify Items or Quantities
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
