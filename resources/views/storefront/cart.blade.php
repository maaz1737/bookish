@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-4">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Shopping Cart</h1>
            <p class="text-sm text-gray-500 mt-1">Review the items you selected before proceeding to secure checkout.</p>
        </div>

        @if (empty($cart['items']))
            <div class="bg-white rounded-3xl border border-gray-100 p-12 text-center shadow-sm max-w-xl mx-auto my-8">
                <div class="text-6xl mb-5 animate-bounce">🛒</div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Your Cart is Empty</h2>
                <p class="text-gray-500 text-sm max-w-xs mx-auto mb-8">
                    Looks like you haven't added any school books, bundles, or uniforms to your cart yet.
                </p>
                <a href="{{ route('schools.index') }}"
                    class="inline-flex items-center justify-center bg-indigo-600 text-white px-6 py-3.5 rounded-xl font-bold hover:bg-indigo-700 transition shadow-md hover:-translate-y-0.5 transform duration-200">
                    Browse Partner Schools
                </a>
            </div>
        @else
            <div class="grid lg:grid-cols-12 gap-8 items-start">

                <div class="lg:col-span-8 space-y-4">
                    <div
                        class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden divide-y divide-gray-50">
                        @foreach ($cart['items'] as $key => $item)
                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-5 gap-4 hover:bg-gray-50/50 transition duration-200">

                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl border border-indigo-100/30 shrink-0">
                                        @if (str_contains(strtolower($item['name']), 'uniform'))
                                            👕
                                        @elseif(str_contains(strtolower($item['name']), 'bag') || str_contains(strtolower($item['name']), 'access'))
                                            🎒
                                        @else
                                            📚
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 text-base sm:text-lg leading-snug line-clamp-2">
                                            {{ $item['name'] }}
                                        </h3>
                                        <p class="text-xs text-gray-400 mt-1 flex items-center gap-2">
                                            <span>Price per unit: Rs. {{ number_format($item['price']) }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center justify-between sm:justify-end w-full sm:w-auto gap-6 border-t sm:border-0 pt-3 sm:pt-0 border-gray-50">
                                    <div
                                        class="flex items-center gap-1.5 bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-100">
                                        <span
                                            class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Qty:</span>
                                        <span class="text-sm font-bold text-gray-700">{{ $item['quantity'] }}</span>
                                    </div>

                                    <div class="text-right min-w-[90px]">
                                        <span class="block text-xs text-gray-400 font-medium">Subtotal</span>
                                        <span class="font-extrabold text-gray-900 text-base">
                                            Rs. {{ number_format($item['price'] * $item['quantity']) }}
                                        </span>
                                    </div>

                                    <form method="POST" action="{{ route('cart.remove', $key) }}" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 rounded-xl transition duration-200"
                                            title="Remove Item">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="pt-2">
                        <a href="{{ route('schools.index') }}"
                            class="inline-flex items-center gap-1.5 text-sm font-bold text-indigo-600 hover:text-indigo-800 transition">
                            ← Continue Shopping More Items
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-4">
                    <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-6 sticky top-24">
                        <h3 class="text-lg font-bold text-gray-800 border-b border-gray-50 pb-4">Order Summary</h3>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between text-gray-500">
                                <span>Subtotal Items</span>
                                <span class="font-medium text-gray-800">Rs. {{ number_format($cart['total']) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-500">
                                <span>Shipping Fees</span>
                                <span
                                    class="text-emerald-600 font-semibold uppercase tracking-wider text-xs bg-emerald-50 px-2 py-0.5 rounded-md">Free
                                    Delivery</span>
                            </div>
                            <div class="border-t border-gray-50 pt-4 flex justify-between text-base items-baseline">
                                <span class="font-bold text-gray-900">Estimated Total:</span>
                                <div class="text-right">
                                    <span class="text-2xl font-black text-indigo-600 block">
                                        Rs. {{ number_format($cart['total']) }}
                                    </span>
                                    <span class="text-[10px] text-gray-400 block mt-0.5">Inclusive of all local sales
                                        taxes</span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="{{ route('checkout.show') }}"
                                class="flex items-center justify-center w-full bg-indigo-600 text-white py-4 rounded-xl font-bold shadow-md hover:bg-indigo-700 hover:-translate-y-0.5 transform transition duration-200">
                                Proceed To Checkout
                            </a>
                            <p class="text-[11px] text-center text-gray-400 mt-3 flex items-center justify-center gap-1">
                                🔒 256-Bit SSL Encrypted Secure Checkout Guaranteed
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>
@endsection
