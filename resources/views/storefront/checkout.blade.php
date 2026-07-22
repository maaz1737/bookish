@extends('layouts.app')

@section('content')
    <div class="pb-28 lg:pb-8">
        <form method="POST" action="">
            @csrf

            <!-- Main responsive grid: 1 column on mobile, 3 columns on desktop -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                <!-- Order Summary Section (order-1 on mobile to stay at top, order-2 on desktop to be on the right side) -->
                <div class="order-1 lg:order-2 lg:col-span-1">
                    <div x-data="{ isOpen: true }" class="bg-white border border-gray-200/80 rounded-2xl overflow-hidden shadow-sm">
                        <!-- Header / Toggle -->
                        <div @click="isOpen = !isOpen" class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50/50 transition-colors select-none">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-500 flex-shrink-0">
                                    <i class="fa-solid fa-cart-shopping text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-navy-800 text-sm sm:text-base">Order Summary</h3>
                                    <p class="text-xs text-gray-500 font-medium">
                                        {{ count($cart['items']) }} {{ count($cart['items']) == 1 ? 'item' : 'items' }} • Total <span class="text-[#ff7a00] font-bold">PKR {{ number_format($cart['total']) }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="text-gray-400 pr-1">
                                <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="isOpen ? 'rotate-180' : ''"></i>
                            </div>
                        </div>

                        <!-- Collapsible Content -->
                        <div x-show="isOpen" x-collapse>
                            <div class="px-4 pb-4 pt-2">
                                <!-- Cart Items List -->
                                {{-- <div class="space-y-4 max-h-[300px] overflow-y-auto pr-1">
                                    @foreach ($cart['items'] as $p)
                                        <div class="flex gap-3 items-center py-2">
                                            <div class="w-14 h-14 bg-gray-50 border border-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                                <img src="{{ $p['image'] }}" alt="{{ $p['name'] }}" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-bold text-xs sm:text-sm text-navy-800 truncate">{{ $p['name'] }}</h4>
                                                <p class="text-[11px] text-gray-400 mt-0.5">Premium Quality • 18 inch</p>
                                                <p class="text-[11px] text-gray-500 font-semibold mt-0.5">Qty: {{ $p['quantity'] }}</p>
                                            </div>
                                            <div class="text-right flex-shrink-0 pl-2">
                                                <p class="text-xs sm:text-sm font-bold text-navy-800">PKR {{ number_format($p['price']) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div> --}}

                                <!-- Subtotal & Delivery Charges -->
                                <div class="border-t border-gray-100 mt-3 pt-3 space-y-2.5 text-xs sm:text-sm">
                                    <div class="flex justify-between items-center text-gray-600">
                                        <span>Subtotal ({{ count($cart['items']) }} {{ count($cart['items']) == 1 ? 'item' : 'items' }})</span>
                                        <span class="font-semibold text-[#0a1f44]">PKR {{ number_format($cart['total']) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-gray-600">
                                        <span>Delivery Charges</span>
                                        <span id="shipping-charge" class="font-semibold text-[#0a1f44]">PKR 0</span>
                                    </div>
                                </div>

                                <!-- Grand Total Box -->
                                <div class="bg-amber-50/60 border border-amber-100/50 mt-4 p-3.5 rounded-xl flex justify-between items-center font-bold text-navy-800 text-sm sm:text-base">
                                    <span>Total Amount</span>
                                    <span id="grand-total" class="text-navy-900">PKR {{ number_format($cart['total']) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Details Section (order-2 on mobile, order-1 on desktop) -->
                <div class="order-2 lg:order-1 lg:col-span-2 space-y-6">
                    <div class="bg-white border border-gray-200/80 rounded-2xl p-4 sm:p-6 shadow-sm space-y-5">
                        
                        <!-- Card Header -->
                        <div class="flex items-center gap-3 pb-3 border-b border-gray-50">
                            <div class="w-7 h-7 rounded-full bg-navy-800 text-white flex items-center justify-center font-bold text-xs sm:text-sm flex-shrink-0">
                                1
                            </div>
                            <div>
                                <h3 class="text-base sm:text-lg font-bold text-navy-800">Shipping Details</h3>
                                <p class="text-xs text-gray-500">Please enter your shipping information</p>
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="space-y-4">
                            <!-- Full Name -->
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-navy-800 mb-1.5">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <div class="relative rounded-xl shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i class="fa-regular fa-user text-sm"></i>
                                    </div>
                                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" placeholder="Enter your full name" 
                                        class="block w-full pl-10 pr-3 py-3 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-navy-600 focus:border-transparent bg-white text-gray-800 placeholder-gray-400 transition-all">
                                </div>
                                @error('customer_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-navy-800 mb-1.5">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <div class="relative rounded-xl shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i class="fa-regular fa-envelope text-sm"></i>
                                    </div>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address" 
                                        class="block w-full pl-10 pr-3 py-3 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-navy-600 focus:border-transparent bg-white text-gray-800 placeholder-gray-400 transition-all">
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-navy-800 mb-1.5">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <div class="relative rounded-xl shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i class="fa-solid fa-phone text-sm"></i>
                                    </div>
                                    <input type="text" name="mobile" value="{{ old('mobile') }}" placeholder="Enter your phone number" 
                                        class="block w-full pl-10 pr-3 py-3 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-navy-600 focus:border-transparent bg-white text-gray-800 placeholder-gray-400 transition-all">
                                </div>
                                @error('mobile')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Province -->
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-navy-800 mb-1.5">
                                    Province <span class="text-red-500">*</span>
                                </label>
                                <div class="relative rounded-xl shadow-sm">
                                    <select name="shipping_zone_id" id="shipping_zone" 
                                        class="appearance-none block w-full pl-4 pr-10 py-3 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-navy-600 focus:border-transparent bg-white text-gray-800 transition-all">
                                        <option value="">Select Province</option>
                                        @foreach($zones as $zone)
                                            <option value="{{ $zone->id }}" {{ old('shipping_zone_id') == $zone->id ? 'selected' : '' }}>
                                                {{ $zone->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                                @error('shipping_zone_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-navy-800 mb-1.5">
                                    Address <span class="text-red-500">*</span>
                                </label>
                                <div class="relative rounded-xl shadow-sm">
                                    <div class="absolute top-3.5 left-3.5 pointer-events-none text-gray-400">
                                        <i class="fa-solid fa-location-dot text-sm"></i>
                                    </div>
                                    <textarea name="address" rows="2" placeholder="House #, Street, Block, Area" 
                                        class="block w-full pl-10 pr-3 py-3 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-navy-600 focus:border-transparent bg-white text-gray-800 placeholder-gray-400 transition-all">{{ old('address') }}</textarea>
                                </div>
                                <p class="text-[11px] text-gray-400 mt-1.5 font-medium leading-relaxed">Provide house no., street, block, area details for accurate delivery.</p>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Security Information Box -->
                        <div class="flex items-start gap-3 p-3.5 bg-blue-50/50 border border-blue-100/50 rounded-xl mt-6">
                            <svg class="w-7 h-7 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2.5L4 5.5v6.5c0 5.55 3.4 10.74 8 12 4.6-1.26 8-6.45 8-12V5.5l-8-3Z" fill="#F3F4F6" stroke="#DC2626" stroke-width="2" stroke-linejoin="round"/>
                                <path d="M12 3.5v17.44c3.74-.98 6.5-5.06 6.5-9.44V6.25l-6.5-2.75Z" fill="#E5E7EB"/>
                                <path d="M12 3.5L5.5 6.25V11.5c0 4.38 2.76 8.46 6.5 9.44V3.5Z" fill="#DC2626" fill-opacity="0.15"/>
                            </svg>
                            <div class="text-xs text-navy-800 leading-normal">
                                <span class="font-bold">Your information is safe with us.</span><br>
                                We never share your details with third parties.
                            </div>
                        </div>

                        <!-- AJAX Shipping Methods Container -->
                        <div id="shipping-method-container" class="hidden mt-4">
                            <div id="shipping-methods">
                                {{-- AJAX will append the shipping_rates view here --}}
                            </div>
                        </div>

                        <!-- Desktop Action Bar (Visible only on lg and above) -->
                        <div class="hidden lg:block border-t border-gray-100 pt-6 mt-6">
                            <div class="flex items-center justify-between">
                                <div class="text-left">
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Total Payable</p>
                                    <p class="text-2xl font-extrabold text-navy-800 grand-total-payable">PKR {{ number_format($cart['total']) }}</p>
                                </div>
                                <div class="flex flex-col items-end">
                                    <button type="submit" class="bg-navy-800 hover:bg-navy-900 text-white font-bold py-3 px-8 rounded-xl flex items-center justify-center gap-2 transition-all shadow-sm hover:shadow-md">
                                        <i class="fa-solid fa-lock text-amber-400 text-xs"></i> Place Order →
                                    </button>
                                    <p class="text-[11px] text-gray-400 mt-1.5 font-medium">No account needed — guest checkout.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Sticky Mobile Action Bar (Visible only on screens below lg) -->
            <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200/80 px-4 py-3.5 flex items-center justify-between z-40 shadow-[0_-4px_12px_rgba(0,0,0,0.05)]">
                <div class="text-left">
                    <p class="text-[9px] text-gray-500 font-bold uppercase tracking-wider">Total Payable</p>
                    <p class="text-xl font-extrabold text-navy-800 grand-total-payable">PKR {{ number_format($cart['total']) }}</p>
                </div>
                <div class="flex flex-col items-end">
                    <button type="submit" class="bg-navy-800 hover:bg-navy-900 text-white font-bold py-2.5 px-6 rounded-xl flex items-center justify-center gap-2 transition-all text-sm shadow-sm">
                        <i class="fa-solid fa-lock text-amber-400 text-xs"></i> Place Order →
                    </button>
                    <p class="text-[9px] text-gray-400 mt-1 font-medium">No account needed — guest checkout.</p>
                </div>
            </div>
        </form>

        <!-- Trust Badges Footer -->
    {{-- ===== TRUST / BENEFITS STRIP ===== --}}
    @include('partials.trust-section')
    </div>

    <!-- JavaScript Pricing and AJAX Updates -->
    <script>
        const subtotal = Number({{ $cart['total'] }});

        const $shippingZone = $('#shipping_zone');
        const $shippingContainer = $('#shipping-method-container');
        const $shippingMethods = $('#shipping-methods');
        const $shippingCharge = $('#shipping-charge');
        const $grandTotal = $('#grand-total');

        function formatPrice(price) {
            return 'PKR ' + price.toLocaleString();
        }

        function resetTotals() {
            $shippingCharge.text(formatPrice(0));
            $grandTotal.text(formatPrice(subtotal));
            $('.grand-total-payable').text(formatPrice(subtotal));
        }

        function getRates(zoneId) {
            $shippingMethods.html('<p class="text-xs text-gray-500 py-2">Loading shipping methods...</p>');

            $.ajax({
                url: '/shipping-rates/' + zoneId,
                type: 'GET',
                success: function (response) {
                    $shippingContainer.removeClass('hidden');
                    $shippingMethods.html(response);
                    console.log(response);
                    resetTotals();
                },
                error: function () {
                    $shippingMethods.html(
                        '<p class="text-xs text-red-500 py-2">Unable to load shipping methods.</p>'
                    );
                }
            });
        }

        // Province Changed
        $shippingZone.change(function () {
            let zoneId = $(this).val();

            if (!zoneId) {
                $shippingContainer.addClass('hidden');
                $shippingMethods.empty();
                resetTotals();
                return;
            }

            getRates(zoneId);
        });

        // Load shipping methods on page load if already selected
        if ($shippingZone.val()) {
            getRates($shippingZone.val());
        }

        // Shipping Method Changed
        $(document).on('change', '.shipping-rate', function () {
            let shippingPrice = Number($(this).data('price'));
            let total = subtotal + shippingPrice;

            $shippingCharge.text(formatPrice(shippingPrice));
            $grandTotal.text(formatPrice(total));
            $('.grand-total-payable').text(formatPrice(total));
        });
    </script>
@endsection