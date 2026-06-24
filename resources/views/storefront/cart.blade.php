@extends('layouts.app')
@section('content')
    <div class="bg-gray-50 py-10">
        <div class="max-w-7xl mx-auto px-4">

            {{-- Progress Steps --}}
            <div class="flex items-center justify-center mb-10">
                @php
                    $steps = [
                        ['label' => 'Cart', 'icon' => '🛒', 'active' => true],
                        ['label' => 'Checkout', 'icon' => '🚚', 'active' => false],
                        ['label' => 'Payment', 'icon' => '💳', 'active' => false],
                        ['label' => 'Confirmation', 'icon' => '✓', 'active' => false],
                    ];
                @endphp
                @foreach ($steps as $i => $step)
                    <div class="flex items-center">
                        <div class="flex flex-col items-center">
                            <div
                                class="w-12 h-12 rounded-full flex items-center justify-center text-lg
                            {{ $step['active'] ? 'bg-[#0a1f44] text-white' : 'bg-white border-2 border-gray-300 text-gray-400' }}">
                                {{ $step['icon'] }}
                            </div>
                            <span
                                class="mt-2 text-sm font-medium {{ $step['active'] ? 'text-[#0a1f44]' : 'text-gray-400' }}">
                                {{ $step['label'] }}
                            </span>
                        </div>
                        @if ($i < count($steps) - 1)
                            <div class="w-16 md:w-32 h-px bg-gray-300 mx-2 mb-6"></div>
                        @endif
                    </div>
                @endforeach
            </div>

            <h1 class="text-4xl font-bold text-[#0a1f44] mb-8">Your Cart</h1>

            @if (empty($cart['items']))
                {{-- Empty State --}}
                <div class="bg-white rounded-2xl shadow-sm p-16 text-center">
                    <div class="text-6xl mb-4">🛒</div>
                    <h2 class="text-2xl font-semibold text-[#0a1f44] mb-2">Your cart is empty</h2>
                    <p class="text-gray-500 mb-6">Looks like you haven't added anything yet.</p>
                    <a href="{{ url('/schools') }}"
                        class="inline-block bg-[#0a1f44] hover:bg-[#0a1f44]/90 text-white font-medium px-8 py-3 rounded-lg transition">
                        Browse Schools
                    </a>
                </div>
            @else
                <div class="grid lg:grid-cols-3 gap-6">

                    {{-- Cart Items --}}
                    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b">
                            <div class="relative">
                                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-xl">🛍️
                                </div>
                                <span
                                    class="absolute -top-1 -right-1 w-5 h-5 bg-amber-400 text-[#0a1f44] text-xs font-bold rounded-full flex items-center justify-center">
                                    {{ count($cart['items']) }}
                                </span>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-[#0a1f44]">Cart Items</h2>
                                <p class="text-sm text-gray-500">Review your selected products</p>
                            </div>
                        </div>

                        @foreach ($cart['items'] as $key => $item)
                            <div class="flex items-center gap-4 py-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                {{-- Image placeholder --}}
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                                    @if (!empty($item['image']))
                                        <img src="{{ app()->environment('local')
                                            ? asset('storage/' . $item['image'][0])
                                            : asset('storage/app/public/' . $item['image'][0]) }}"
                                            alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-2xl">📦</div>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-[#0a1f44] truncate">{{ $item['name'] }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">Qty: {{ $item['quantity'] }}</p>
                                    <p class="text-sm text-gray-400">Unit price: PKR {{ number_format($item['price']) }}
                                    </p>
                                </div>

                                {{-- Price + Remove --}}
                                <div class="text-right">
                                    <p class="font-bold text-[#0a1f44]">
                                        PKR {{ number_format($item['price'] * $item['quantity']) }}
                                    </p>
                                    <form action="{{ url('/cart/' . $key) }}" method="POST" class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700 text-sm font-medium inline-flex items-center gap-1">
                                            🗑️ Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Order Summary --}}
                    <div class="bg-white rounded-2xl shadow-sm p-6 h-fit">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-xl">📋
                                    </div>
                                    <span
                                        class="absolute -top-1 -right-1 w-5 h-5 bg-amber-400 text-[#0a1f44] text-xs font-bold rounded-full flex items-center justify-center">
                                        {{ count($cart['items']) }}
                                    </span>
                                </div>
                                <h2 class="text-xl font-bold text-[#0a1f44]">Order Summary</h2>
                            </div>
                        </div>

                        <div class="space-y-3 mb-4 pb-4 border-b">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal ({{ count($cart['items']) }} items)</span>
                                <span class="font-medium">PKR {{ number_format($cart['total']) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span class="flex items-center gap-1">Delivery Charges <span
                                        class="text-gray-400">ⓘ</span></span>
                                <span class="font-medium">PKR 150</span>
                            </div>
                        </div>

                        <div class="bg-amber-50 rounded-lg p-4 mb-6 flex justify-between items-center">
                            <span class="font-bold text-[#0a1f44]">Total Amount</span>
                            <span class="text-xl font-bold text-[#0a1f44]">
                                PKR {{ number_format($cart['total'] + 150) }}
                            </span>
                        </div>

                        <a href="{{ url('/checkout') }}"
                            class="block w-full bg-[#0a1f44] hover:bg-[#0a1f44]/90 text-white text-center font-semibold py-4 rounded-lg transition flex items-center justify-center gap-2">
                            🔒 Proceed to Checkout →
                        </a>

                        <p class="text-center text-xs text-gray-500 mt-4 flex items-center justify-center gap-1">
                            🛡️ Secure checkout. Your data is protected.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
