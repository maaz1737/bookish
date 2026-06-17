@extends('layouts.app')
@section('content')
    <nav class="text-sm text-gray-500 mb-4">
        <a href="{{ route('schools.show', $school) }}" class="hover:text-indigo-600">
            {{ $school->name }}
        </a>
        <span class="mx-2">/</span>
        <span class="text-gray-700 font-medium">{{ $class->name }}</span>
    </nav>

    <!-- HEADER -->
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <h1 class="text-3xl font-bold">
            {{ $class->name }} Book Bundle
        </h1>

        <p class="text-gray-500 mt-2">
            Select the complete bundle or remove items you don’t need.
        </p>

        <div class="mt-4 flex gap-2 flex-wrap">
            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm">
                {{ $school->name }}
            </span>

            @if ($bundle)
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">
                    {{ $bundle?->discount }}% Off
                </span>
            @endif
        </div>
    </div>

    @if ($bundle)
        <form method="POST" action="{{ route('cart.addBundle', $bundle) }}">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- LEFT SIDE: PRODUCTS -->
                <div class="lg:col-span-2 space-y-4">

                    @foreach ($bundle->items as $item)
                        <label
                            class="flex items-center justify-between bg-white rounded-2xl shadow-sm hover:shadow-md transition p-5 cursor-pointer">

                            <div class="flex items-center gap-4">

                                <!-- CHECKBOX -->
                                <input type="checkbox" checked class="w-5 h-5 accent-indigo-600 bundle-book"
                                    data-id="{{ $item->product_id }}">

                                <!-- PRODUCT IMAGE -->
                                <img src="{{ asset((app()->environment('production') ? 'public/' : '') . 'storage/' . $item->product->images[0]) }}"
                                    class="w-16 h-16 rounded-xl object-cover border"" alt="{{ $item->product->name }}">

                                <!-- PRODUCT INFO -->
                                <div>
                                    <h3 class="font-semibold text-lg">
                                        {{ $item->product->name }}
                                    </h3>

                                    <p class="text-sm text-gray-500">
                                        Quantity: {{ $item->quantity }}
                                    </p>

                                    <div class="flex gap-2 mt-1">
                                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">
                                            Class Item
                                        </span>
                                    </div>
                                </div>

                            </div>

                            <!-- PRICE -->
                            <div class="text-right">
                                <div class="font-bold text-lg text-gray-800">
                                    {{ number_format($item->product->effectivePrice() * $item->quantity) }} PKR
                                </div>
                            </div>

                        </label>
                    @endforeach

                    <!-- Hidden exclude fields -->
                    <div id="exclude-fields"></div>

                </div>

                <!-- RIGHT SIDE: SUMMARY -->
                <div class="lg:col-span-1">

                    <div class="bg-white rounded-2xl shadow p-6 sticky top-6">

                        <h2 class="text-lg font-bold mb-4">
                            Bundle Summary
                        </h2>

                        <div class="space-y-3 text-sm">

                            <div class="flex justify-between">
                                <span class="text-gray-500">Original Price</span>
                                <span class="line-through text-gray-400">
                                    {{ number_format($bundle->total_price) }} PKR
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Discount</span>
                                <span class="text-green-600 font-medium">
                                    {{ $bundle->discount }}%
                                </span>
                            </div>

                            <hr>

                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span class="text-indigo-600">
                                    {{ number_format($bundle->final_price) }} PKR
                                </span>
                            </div>

                        </div>

                        <button
                            class="mt-6 w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-semibold">
                            Add Bundle to Cart
                        </button>

                        <p class="text-xs text-gray-400 mt-3 text-center">
                            You can uncheck items to customize the bundle
                        </p>

                    </div>

                </div>

            </div>
        </form>
    @else
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center mb-4">
                <span class="text-3xl">📖</span>
            </div>

            <h2 class="text-2xl font-bold text-gray-800">
                No Bundle Found
            </h2>

            <p class="text-gray-500 mt-2 max-w-md">
                We couldn't find any book bundle for this class yet.
                Please check back later or contact the school administration.
            </p>
        </div>
    @endif

    <!-- JS: EXCLUDED ITEMS -->
    <script>
        document.querySelector('form').addEventListener('submit', function() {
            const wrap = document.getElementById('exclude-fields');
            wrap.innerHTML = '';

            document.querySelectorAll('.bundle-book').forEach(cb => {
                if (!cb.checked) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'exclude[]';
                    input.value = cb.dataset.id;
                    wrap.appendChild(input);
                }
            });
        });
    </script>
@endsection
