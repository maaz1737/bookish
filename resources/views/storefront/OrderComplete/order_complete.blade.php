@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 pt-8">
        <div class="flex items-center justify-between text-xs text-gray-500">
            @foreach ([['🛒', 'Cart', false], ['🚚', 'Checkout', false], ['💳', 'Payment', false], ['✓', 'Confirmation', true]] as $i => $s)
                <div class="flex flex-col items-center flex-1">
                    <div
                        class="w-10 h-10 rounded-full border-2 flex items-center justify-center {{ $s[2] ? 'bg-[#0a1f44] text-white border-[#0a1f44]' : 'bg-white text-gray-400 border-gray-300' }}">
                        {{ $s[0] }}
                    </div>
                    <div class="mt-2 {{ $s[2] ? 'text-[#0a1f44] font-semibold' : '' }}">{{ $s[1] }}</div>
                </div>
                @if ($i < 3)
                    <div class="flex-1 h-px bg-gray-300 -mt-6"></div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="flex items-center justify-center mt-8">
        <div class="w-full max-w-4xl rounded-2xl bg-white p-8 shadow-lg sm:p-12">
            <!-- Success icon -->
            <div class="relative mx-auto mb-6 flex h-20 w-20 items-center justify-center">
                <svg class="h-20 w-20 text-emerald-500" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="40" cy="40" r="36" stroke="currentColor" stroke-width="3" />
                    <path d="M26 42L35 51L54 32" stroke="currentColor" stroke-width="4" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span class="absolute -left-2 top-4 text-amber-400">✦</span>
                <span class="absolute -right-1 top-8 text-rose-400">✦</span>
                <span class="absolute bottom-2 left-0 text-sky-400">✦</span>
                <span class="absolute -right-2 bottom-6 text-emerald-400">✦</span>
            </div>

            <!-- Heading -->
            <h1 class="text-center text-2xl font-bold text-gray-900 sm:text-3xl">
                Order Placed Successfully!
            </h1>
            <p class="mx-auto mt-3 max-w-xl text-center text-sm text-gray-500 sm:text-base">
                @if ($order->payment_method == 'cash_on_delivery')
                    You selected Cash on Delivery. Your order has been placed successfully.
                    Our representative will contact you shortly for order confirmation and processing.
                @else
                    You selected Bank Transfer / Easypaisa / JazzCash. Your order has been placed successfully.
                    Our team will verify your payment proof and begin processing your order shortly.
                @endif
            </p>

            <!-- Content grid -->
            <div class="mt-6 grid grid-cols-1 items-center gap-8 md:grid-cols-2">
                <!-- Illustration -->
                <div class="flex justify-center">
                    <img src="{{ asset('storage/order-success.png') }}" alt="Order placed successfully"
                        class="h-48 w-auto object-contain sm:h-56" />
                </div>

                <!-- Order details -->
                <div class="space-y-4 rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3 text-gray-500">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                                <line x1="10" y1="9" x2="8" y2="9" />
                            </svg>
                            <span class="text-sm">Order Number</span>
                        </div>
                        <span class="text-sm text-gray-900">{{ $order->order_number }}</span>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3 text-gray-500">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="5" width="20" height="14" rx="2" />
                                <line x1="2" y1="10" x2="22" y2="10" />
                            </svg>
                            <span class="text-sm">Payment Method</span>
                        </div>
                        <span
                            class="text-sm text-gray-900">{{ $order->payment_method == 'cash_on_delivery' ? 'Cash On Delivery' : 'Bank Transfer' }}</span>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3 text-gray-500">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8" />
                                <path d="M12 6v2" />
                                <path d="M12 16v2" />
                            </svg>
                            <span class="text-sm">Total Amount</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">PKR {{ $order->total_amount }}</span>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3 text-gray-500">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            <span class="text-sm">Delivery Location</span>
                        </div>
                        <span class="text-sm text-gray-900">{{ $order->shippingArea->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-10 flex flex-col justify-center gap-4 sm:flex-row">
                {{-- <button
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-slate-800">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="3" width="15" height="13" />
                        <polygon points="16 8 20 8 23 11 23 16 16 16" />
                        <circle cx="5.5" cy="18.5" r="2.5" />
                        <circle cx="18.5" cy="18.5" r="2.5" />
                    </svg>
                    Track Order
                </button> --}}
                <a href="{{ route('home') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-3 text-sm font-medium text-gray-900 transition-colors hover:bg-gray-50">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                        <line x1="3" y1="6" x2="21" y2="6" />
                        <path d="M16 10a4 4 0 0 1-8 0" />
                    </svg>
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
@endsection