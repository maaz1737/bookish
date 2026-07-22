@extends('layouts.app')

@section('content')
    <nav class="text-xs sm:text-sm text-gray-500 mb-4 sm:mb-6 flex flex-wrap items-center gap-1.5 sm:gap-2">
        <a href="/" class="hover:text-indigo-600">Home</a>
        <span>&rsaquo;</span>
        <a href="#" class="hover:text-indigo-600">Schools</a>
        <span>&rsaquo;</span>
        <a href="{{ route('schools.show', $school) }}" class="hover:text-indigo-600 truncate max-w-[120px] sm:max-w-none">
            {{ $school->name }}
        </a>
        <span>&rsaquo;</span>
        <span class="text-gray-400 font-medium">{{ $class->name }}</span>
        <span>&rsaquo;</span>
        <span class="text-gray-700 font-medium">Complete Book Set</span>
    </nav>

    @if (count($products) > 0)
        <form method="POST" action="{{ route('cart.addBundle') }}" id="bundle-form">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 items-start">

                <div class="lg:col-span-2 space-y-6">
                    <!-- School & Class Header Banner -->
                    <div
                        class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-6 md:p-8 flex flex-col sm:flex-row justify-between items-start gap-6 relative overflow-visible">
                        <div class="space-y-4 sm:space-y-5 w-full lg:max-w-[60%] z-10">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <div
                                    class="w-12 h-12 sm:w-16 sm:h-16 rounded-full flex items-center justify-center text-white relative flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"
                                        class="w-12 h-12 sm:w-16 sm:h-16 shadow-md rounded-full flex-shrink-0">
                                        <circle cx="50" cy="50" r="48" fill="#0A2540" stroke="#FBBF24" stroke-width="2" />
                                        <circle cx="50" cy="50" r="43" fill="none" stroke="#FBBF24" stroke-width="1"
                                            stroke-dasharray="2,2" opacity="0.5" />
                                        <path d="M25,65 Q35,55 50,55 Q65,55 75,65 Q65,75 50,70 Q35,75 25,65 Z" fill="#1E3A8A"
                                            opacity="0.4" />
                                        <path
                                            d="M20,55 C25,40 38,38 50,48 C62,38 75,40 80,55 C70,48 60,48 50,52 C40,48 30,48 20,55 Z"
                                            fill="#FBBF24" opacity="0.8" />
                                        <polygon points="50,22 53,32 63,32 55,38 58,48 50,42 42,48 45,38 37,32 47,32"
                                            fill="#FFFFFF" />
                                        <polygon points="50,25 52,32 59,32 54,36 56,43 50,39 44,43 46,36 41,32 48,32"
                                            fill="#FBBF24" />
                                        <path d="M22,68 L78,68 L73,78 L27,78 Z" fill="#FBBF24" />
                                        <circle cx="50" cy="60" r="2" fill="#FFFFFF" />
                                    </svg>
                                </div>

                                <div>
                                    <p
                                        class="text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider leading-none">
                                        {{ $school->name }}
                                    </p>
                                    <h1
                                        class="text-xl sm:text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight mt-1 leading-tight">
                                        {{ $class->name }} Complete Book Set
                                    </h1>
                                </div>
                            </div>

                            <p class="text-gray-500 text-xs sm:text-sm">
                                All required books for {{ $class->name }} in one bundle.
                            </p>

                            <div
                                class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-700 rounded-md text-xs font-medium border border-green-200">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7">
                                    </path>
                                </svg>
                                Recommended by School
                            </div>

                            <div class="pt-3 grid grid-cols-3 gap-2 border-t border-gray-100">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-1 sm:gap-1.5">
                                    <div class="p-1 bg-gray-50 rounded-xl text-gray-600 flex-shrink-0 text-xs sm:text-base">
                                        🎒</div>
                                    <div>
                                        <p
                                            class="text-[9px] sm:text-[10px] text-gray-400 uppercase font-bold tracking-wider leading-none">
                                            Grade</p>
                                        <p class="text-xs font-semibold text-gray-700 mt-0.5">{{ $class->name }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-1 sm:gap-1.5">
                                    <div class="p-1 bg-gray-50 rounded-xl text-gray-600 flex-shrink-0 text-xs sm:text-base">
                                        🌐</div>
                                    <div>
                                        <p
                                            class="text-[9px] sm:text-[10px] text-gray-400 uppercase font-bold tracking-wider leading-none">
                                            Medium</p>
                                        <p class="text-xs font-semibold text-gray-700 mt-0.5">English</p>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-1 sm:gap-1.5">
                                    <div class="p-1 bg-gray-50 rounded-xl text-gray-600 flex-shrink-0 text-xs sm:text-base">
                                        📅</div>
                                    <div>
                                        <p
                                            class="text-[9px] sm:text-[10px] text-gray-400 uppercase font-bold tracking-wider leading-none">
                                            Academic Year</p>
                                        <p class="text-xs font-semibold text-gray-700 mt-0.5">2024 - 2025</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Books Container (Mobile Cards + Desktop Table) -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                        <!-- 1. MOBILE CARD VIEW (Visible only on screens < 640px) -->
                        <div class="block sm:hidden divide-y divide-gray-100">
                            @foreach ($products as $index => $product)
                                @php
                                    $itemPrice = $product->effectivePrice();
                                @endphp
                                <div class="p-4 space-y-3">
                                    <div class="flex items-start gap-3">
                                        <!-- Checkbox -->
                                        <input type="checkbox" checked
                                            class="w-5 h-5 mt-1 rounded text-indigo-600 accent-indigo-600 border-gray-300 focus:ring-indigo-500 cursor-pointer flex-shrink-0"
                                            data-id="{{ $product->id }}" data-price="{{ $itemPrice }}"
                                            data-total="{{ $product->price }}">

                                        <!-- Book Image -->
                                        <img src="{{ $product->imageUrl() }}"
                                            class="w-12 h-16 rounded object-cover shadow-sm bg-gray-50 border border-gray-100 flex-shrink-0"
                                            alt="{{ $product->name }}">

                                        <!-- Title & Details -->
                                        <div class="flex-1 min-w-0">
                                            <span class="font-bold text-gray-900 text-sm block truncate">
                                                {{ $product->name }}
                                            </span>

                                            <p class="text-xs text-gray-500 mt-0.5">
                                                {{ $product->publisher  }}
                                            </p>

                                            <div class="flex items-center gap-2 mt-2">
                                                <span
                                                    class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[11px] font-medium">
                                                    {{ $item->product->subject ?? 'General' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price Row -->
                                    <div class="flex justify-between items-center pt-2 border-t border-gray-50 text-xs">
                                        <span class="text-gray-400 font-medium">Price:</span>
                                        <span class="font-bold text-gray-900 text-sm">
                                            PKR {{ number_format($itemPrice) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- 2. DESKTOP TABLE VIEW (Visible on screens >= 640px) -->
                        <div class="hidden sm:block overflow-x-auto min-w-full">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr
                                        class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-gray-100">
                                        <th class="py-3.5 px-4 w-12 text-center">#</th>
                                        <th class="py-3.5 px-4">Title</th>
                                        <th class="py-3.5 px-4">Publisher</th>
                                        <th class="py-3.5 px-4">Subject</th>
                                        <th class="py-3.5 px-4 text-right">Price (PKR)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                                    @foreach ($products as $index => $product)
                                        @php
                                            $itemPrice = $product->effectivePrice();
                                        @endphp
                                        <tr class="hover:bg-slate-50/70 transition-colors group">
                                            <td class="py-4 px-4 text-center">
                                                <input type="checkbox" checked name="product_id[]" value="{{ $product->id }}"
                                                    class="w-4 h-4 rounded text-indigo-600 accent-indigo-600 border-gray-300 focus:ring-indigo-500 bundle-book cursor-pointer"
                                                    data-id="{{ $product->id }}" data-price="{{ $itemPrice }}"
                                                    data-total="{{ $product->price }}">
                                            </td>

                                            <td class="py-4 px-4">
                                                <div class="flex items-center gap-3">
                                                    <img src="{{ $product->imageUrl() }}"
                                                        class="w-10 h-12 rounded object-cover shadow-sm bg-gray-50 border border-gray-100 flex-shrink-0"
                                                        alt="{{ $product->name }}">

                                                    <div>
                                                        <span
                                                            class="font-medium text-gray-900 block group-hover:text-indigo-600 transition-colors">
                                                            {{ $product->name }}
                                                        </span>

                                                    </div>
                                                </div>
                                            </td>

                                            <td class="py-4 px-4 text-gray-500 font-medium whitespace-nowrap">
                                                {{ $product?->publisher }}
                                            </td>

                                            <td class="py-4 px-4 whitespace-nowrap">
                                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-xs font-medium">
                                                    {{ $product->subject ?? 'General' }}
                                                </span>
                                            </td>
                                            <td class="hidden total-price">
                                                {{ $product->price }}
                                            </td>
                                            <td
                                                class="py-4 px-4 text-right font-semibold text-gray-900 whitespace-nowrap discount-price">
                                                {{ number_format($itemPrice) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Subtotal Footer -->
                        <div
                            class="bg-slate-50 p-4 sm:p-5 border-t border-gray-100 flex justify-between items-center px-4 sm:px-6">
                            <span class="font-bold text-gray-700 text-xs sm:text-sm">
                                Total({{ count($products) }} Items)</span>
                            </span>
                            <span class="font-extrabold text-slate-900 text-sm sm:text-base">
                                PKR <span class="discount-price-bundle">0</span>
                            </span>
                        </div>
                    </div>

                    <div id="exclude-fields"></div>
                </div>

                <!-- Sidebar (Bundle Summary) -->
                <div class="lg:col-span-1 space-y-4 lg:sticky lg:top-6">

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-6 relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 bg-orange-500 text-white text-[10px] sm:text-[11px] font-bold px-2.5 sm:px-3 py-1 rounded-bl-xl tracking-wide uppercase">
                            Save <span class="bundle-discount">0</span>%
                        </div>

                        <h2 class="text-base font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100">
                            Bundle Summary
                        </h2>

                        <div class="space-y-3.5 sm:space-y-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Total Price</span>
                                <span class="line-through text-gray-400 font-medium">
                                    PKR <span class="total-price-bundle">0</span>
                                </span>
                            </div>

                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Bundle Discount</span>
                                <span class="text-orange-500 font-bold bg-orange-50 px-2 py-0.5 rounded text-xs">
                                    <span class="bundle-discount">0</span>%
                                </span>
                            </div>

                            <div class="flex justify-between items-center text-sm pt-1">
                                <span class="text-gray-500">You Save</span>
                                <span class="text-green-600 font-semibold">
                                    PKR <span class="saved-amount"> 222</span>
                                </span>
                            </div>

                            <div class="border-t border-dashed border-gray-200 pt-4 flex justify-between items-end">
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Final Payable</p>
                                    <p class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-0.5">
                                        PKR <span class="text-orange-600 discount-price-bundle">222</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 sm:mt-6 space-y-3">
                            <button type="submit"
                                class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 sm:py-3.5 px-4 rounded-xl font-bold shadow-md shadow-orange-500/10 transition-all flex items-center justify-center gap-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z">
                                    </path>
                                </svg>
                                Add Complete Set to Cart
                            </button>
                        </div>

                        <div
                            class="mt-4 sm:mt-5 pt-4 border-t border-gray-100 grid grid-cols-2 gap-2 text-[11px] font-medium text-gray-500">
                            <div class="flex items-center gap-1.5">
                                <span class="text-green-500 text-sm">✓</span> 100% Original Books
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="text-green-500 text-sm">✓</span> Easy Returns
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-5 space-y-3 shadow-sm">
                        <h3 class="font-bold text-sm text-gray-900">Why Buy Complete Set?</h3>
                        <ul class="space-y-2 text-xs text-gray-600 font-medium">
                            <li class="flex items-center gap-2">
                                <span
                                    class="w-4 h-4 rounded-full bg-green-100 text-green-700 flex items-center justify-center text-[10px] flex-shrink-0">✓</span>
                                All books recommended by school
                            </li>
                            <li class="flex items-center gap-2">
                                <span
                                    class="w-4 h-4 rounded-full bg-green-100 text-green-700 flex items-center justify-center text-[10px] flex-shrink-0">✓</span>
                                Bundle discount included
                            </li>
                            <li class="flex items-center gap-2">
                                <span
                                    class="w-4 h-4 rounded-full bg-green-100 text-green-700 flex items-center justify-center text-[10px] flex-shrink-0">✓</span>
                                Save time & money
                            </li>
                            <li class="flex items-center gap-2">
                                <span
                                    class="w-4 h-4 rounded-full bg-green-100 text-green-700 flex items-center justify-center text-[10px] flex-shrink-0">✓</span>
                                All items delivered in one package
                            </li>
                        </ul>
                    </div>

                    <div
                        class="bg-amber-50/60 rounded-2xl border border-amber-100 p-4 sm:p-5 text-xs text-amber-800 space-y-1.5">
                        <p class="font-bold text-amber-900 flex items-center gap-1">
                            ⚠️ Important Notes
                        </p>
                        <ul class="list-disc pl-4 space-y-1 text-amber-900/80 font-medium">
                            <li>Books edition & price may vary as per publisher.</li>
                            <li>This set is for the academic year 2024-2025.</li>
                        </ul>
                    </div>

                </div>

            </div>
        </form>

        {{-- ===== WHY CHOOSE US ===== --}}

        @include('partials.trust-section')

    @else
        <div
            class="flex flex-col items-center justify-center py-12 sm:py-20 text-center bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm">
            <div
                class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-indigo-50 flex items-center justify-center mb-4 text-2xl sm:text-3xl">
                📖
            </div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800">No Product Found</h2>
            <p class="text-gray-500 mt-2 max-w-sm text-xs sm:text-sm">
                We couldn't find any Product for this class yet. Please check back later or contact the school
                administration.
            </p>
        </div>
    @endif


    <script>
        function updateBundleTotals() {
            let totalPrice = 0;
            let discountPrice = 0;

            $('.bundle-book:checked').each(function () {
                totalPrice += parseFloat($(this).data('total')) || 0;
                discountPrice += parseFloat($(this).data('price')) || 0;
            });

            let savedAmount = totalPrice - discountPrice;
            let discount = totalPrice > 0
                ? ((totalPrice - discountPrice) / totalPrice) * 100
                : 0;

            $('.total-price-bundle').text(totalPrice.toFixed(2));
            $('.discount-price-bundle').text(discountPrice.toFixed(2));
            $('.bundle-discount').text(Math.round(discount));
            $('.saved-amount').text(savedAmount.toFixed(2));
        }

        // Initial calculation
        updateBundleTotals();

        // Recalculate whenever a checkbox is checked/unchecked
        $(document).on('change', '.bundle-book', function () {
            updateBundleTotals();
        });
    </script>

@endsection