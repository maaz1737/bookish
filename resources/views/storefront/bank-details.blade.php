@extends('layouts.app')


@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="max-w-4xl mx-auto px-4 pt-2">
            <div class="flex items-center justify-between text-xs text-gray-500">
                @foreach ([['🛒', 'Cart', false], ['🚚', 'Checkout', false], ['💳', 'Payment', true], ['✓', 'Confirmation', false]] as $i => $s)
                    <div class="flex flex-col items-center flex-1">
                        <div
                            class="w-10 h-10 rounded-full border-2 flex items-center justify-center {{ $s[2] ? 'bg-[#0a1f44] text-white border-[#0a1f44]' : 'bg-white text-gray-400 border-gray-300' }}">
                            {{ $s[0] }}</div>
                        <div class="mt-2 {{ $s[2] ? 'text-[#0a1f44] font-semibold' : '' }}">{{ $s[1] }}</div>
                    </div>
                    @if ($i < 3)
                        <div class="flex-1 h-px bg-gray-300 -mt-6"></div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Content grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-10">

            <!-- Payment methods (2/3) -->
            <section class="lg:col-span-2 bg-white border border-gray-200 rounded-lg p-6 sm:p-8 shadow-sm">
                <h2 class="text-2xl sm:text-3xl font-bold text-navy">Choose Payment Method</h2>
                <p class="text-sm text-gray-500 mt-1">Select how you would like to pay for your order.</p>

                <!-- COD -->
                <form action="{{ route('checkout.update', ['order' => $order->order_number]) }}" method="post">
                    @csrf
                    <label class="mt-6 block border-2 border-navy bg-blue-50/40 rounded-lg p-4 sm:p-5 cursor-pointer">
                        <div class="flex items-start gap-4">
                            <input type="radio" name="pay" value="cash_on_delivery" checked=""
                                class="mt-1 accent-navy w-5 h-5">
                            <div
                                class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-md flex items-center justify-center flex-shrink-0 border border-gray-200">
                                <span class="text-3xl">💵</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-lg sm:text-xl font-bold text-navy">Cash on Delivery</h3>
                                <p class="text-sm text-gray-600">Pay when your order is delivered</p>
                                <p class="text-xs text-gray-500 mt-2 flex items-center gap-1.5">
                                    <i class="fa-solid fa-shield-halved text-navy"></i>
                                    A representative will contact you to confirm your order.
                                </p>
                            </div>
                        </div>
                    </label>

                    <!-- Bank -->
                    <label class="mt-4 block border border-gray-200 rounded-lg p-4 sm:p-5 cursor-pointer hover:border-navy">
                        <div class="flex items-start gap-4">
                            <input type="radio" name="pay" class="mt-1 accent-navy w-5 h-5">
                            <div
                                class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-md flex flex-col items-center justify-center flex-shrink-0 border border-gray-200 gap-1">
                                <i class="fa-solid fa-building-columns text-navy text-xl"></i>
                                <div class="flex gap-1 text-[8px] font-bold">
                                    <span class="text-green-600">easypaisa</span>
                                    <span class="text-red-600">JazzCash</span>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-lg sm:text-xl font-bold text-navy">Bank Transfer / Easypaisa / JazzCash</h3>
                                <p class="text-sm text-gray-600">Pay manually using account details or QR code</p>
                                <p class="text-xs text-gray-500 mt-2 flex items-center gap-1.5">
                                    <i class="fa-solid fa-shield-halved text-navy"></i>
                                    You will receive payment details after placing the order.
                                </p>
                            </div>
                        </div>
                    </label>
                    <div class="mt-4">
                        <button class="bg-blue-900 w-full text-white py-2 rounded text-sm">
                            <i class="fa-solid fa-lock mr-2"></i>
                            Proceed with selected method
                            <i class="fa-solid fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </form>
                <button
                    class="w-full bg-navyDark hover:bg-navy text-white font-semibold py-2 rounded-md flex items-center justify-center gap-3 transition">
                    <i class="fa-solid fa-lock"></i>
                    Proceed with Selected Method
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
                <p class="text-center text-xs text-gray-500 mt-3 flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-shield-halved"></i> Your payments are secure and encrypted.
                </p>
            </section>

            <!-- Order summary -->
            <aside class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="relative">
                            <i class="fa-solid fa-bag-shopping text-navy text-xl"></i>
                            <span
                                class="absolute -top-2 -right-3 bg-gold text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center">3</span>
                        </div>
                        <h3 class="text-lg font-bold text-navy ml-2">Order Summary</h3>
                    </div>
                    <button class="text-sm font-semibold text-navy flex items-center gap-1">
                        Edit Cart <i class="fa-solid fa-pen text-xs"></i>
                    </button>
                </div>

                <div class="mt-5 space-y-4">
                    <!-- Item -->
                    @foreach ($order->items as $item)
                        <div class="flex gap-3">
                            <div class="w-16 h-16 bg-gray-100 rounded-md flex items-center justify-center flex-shrink-0">
                                @php
                                    $image = $item->product?->images[0] ?? null;
                                @endphp

                                @if ($image)
                                    <img src="{{ app()->environment('production') ? asset('storage/app/public/' . $image) : asset('storage/' . $image) }}"
                                        alt="{{ $item->product?->name ?? 'Product' }}"
                                        class="w-full h-full object-contain rounded-md"
                                        onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                                @else
                                    <img src="{{ asset('images/no-image.png') }}" alt="Image not found"
                                        class="w-full h-full object-contain rounded-md">
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex justify-between gap-2">
                                    <h4 class="font-semibold text-sm text-navy">{{ $item->product->name }}</h4>
                                    <span class="text-sm font-bold text-navy whitespace-nowrap">PKR
                                        {{ $item->product->discount_price }}</span>
                                </div>
                                <p class="text-xs text-gray-500">Premium Quality • 18 inch</p>
                                <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 mt-5 pt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal ({{ count($order->items) . ' items' }})</span>
                        <span class="font-semibold text-navy">PKR {{ $order->total_amount }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 flex items-center gap-1">Delivery Charges <i
                                class="fa-regular fa-circle-question text-xs"></i></span>
                        <span class="font-semibold text-navy">PKR 150</span>
                    </div>
                </div>

                <div class="bg-gray-50 -mx-6 px-6 py-4 mt-4 flex justify-between items-center">
                    <span class="text-lg font-bold text-navy">Total Amount</span>
                    <span class="text-xl font-extrabold text-navy">PKR {{ $order->total_amount + 150 }}</span>
                </div>

                <p class="text-center text-xs text-gray-500 mt-4 flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-shield-halved"></i> Secure checkout. Your information is safe with us.
                </p>
            </aside>
        </div>

        <!-- Trust badges -->
        <div class="mt-8 border border-gray-200 rounded-lg p-6 bg-white">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                <div class="flex items-center gap-3"><i class="fa-solid fa-shield-halved text-2xl text-navy"></i>
                    <div>
                        <p class="text-sm font-bold text-navy">100% Original Products</p>
                        <p class="text-xs text-gray-500">Sourced from authorized suppliers</p>
                    </div>
                </div>
                <div class="flex items-center gap-3"><i class="fa-solid fa-truck text-2xl text-navy"></i>
                    <div>
                        <p class="text-sm font-bold text-navy">Fast &amp; Reliable Delivery</p>
                        <p class="text-xs text-gray-500">Across Pakistan</p>
                    </div>
                </div>
                <div class="flex items-center gap-3"><i class="fa-solid fa-credit-card text-2xl text-navy"></i>
                    <div>
                        <p class="text-sm font-bold text-navy">Secure Payments</p>
                        <p class="text-xs text-gray-500">Multiple payment options</p>
                    </div>
                </div>
                <div class="flex items-center gap-3"><i class="fa-solid fa-rotate-left text-2xl text-navy"></i>
                    <div>
                        <p class="text-sm font-bold text-navy">Easy Returns</p>
                        <p class="text-xs text-gray-500">Hassle-free returns within 7 days</p>
                    </div>
                </div>
                <div class="flex items-center gap-3"><i class="fa-solid fa-headset text-2xl text-navy"></i>
                    <div>
                        <p class="text-sm font-bold text-navy">Dedicated Support</p>
                        <p class="text-xs text-gray-500">We're here to help you anytime</p>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
