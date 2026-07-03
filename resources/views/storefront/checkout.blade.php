@extends('layouts.app')
@section('content')
    <div class="bg-gray-50">
        {{-- Stepper --}}
        <div class="max-w-4xl mx-auto px-4 pt-8">
            <div class="flex items-center justify-between text-xs text-gray-500">
                @foreach ([['🛒', 'Cart', false], ['🚚', 'Checkout', true], ['💳', 'Payment', false], ['✓', 'Confirmation', false]] as $i => $s)
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

        <div class="max-w-7xl mx-auto px-4 py-8">
            <h2 class="text-3xl font-extrabold text-[#0a1f44] mb-6">Checkout</h2>

            <div class="grid lg:grid-cols-3 gap-6">
                {{-- Shipping form --}}
                <div class="lg:col-span-2 bg-white border rounded-lg p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center relative">
                            🚚<span
                                class="absolute -top-1 -right-1 bg-[#0a1f44] text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center">{{ count($cart['items']) }}</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-[#0a1f44]">Shipping Details</h3>
                            <p class="text-sm text-gray-500">Please enter your shipping information</p>
                        </div>
                    </div>

                    <form method="POST" action="">
                        @csrf

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">Full Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                                    placeholder="Ahmad Raza"
                                    class="w-full border border-gray-200 rounded-md px-3 py-2 focus:outline-none focus:border-[#0a1f44]">
                                @error('customer_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm text-gray-700 mb-1">
                                    Email
                                    <span class="text-red-500">*</span>
                                </label>

                                <input type="email" name="email" value="{{ old('email') }}" placeholder="ahmad@example.com"
                                    class="w-full border border-gray-200 rounded-md px-3 py-2 focus:outline-none focus:border-[#0a1f44]">

                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm text-gray-700 mb-1">Phone Number <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="mobile" value="{{ old('mobile') }}" placeholder="0321 1234567"
                                    class="w-full border border-gray-200 rounded-md px-3 py-2 focus:outline-none focus:border-[#0a1f44]">
                                @error('mobile')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="md:col-span-2 mt-4">
                            <label class="block text-sm text-gray-700 mb-1">
                                Province
                                <span class="text-red-500">*</span>
                            </label>

                            <select name="shipping_zone_id" id="shipping_zone"
                                class="w-full border border-gray-200 rounded-md px-3 py-2 focus:outline-none focus:border-[#0a1f44]">

                                <option value="">Select Province</option>

                                @foreach($zones as $zone)
                                    <option value="{{ $zone->id }}" {{ old('shipping_zone_id') == $zone->id ? 'selected' : '' }}>
                                        {{ $zone->name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('shipping_zone_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm text-gray-700 mb-1">Address <span
                                    class="text-red-500">*</span></label>
                            <textarea name="address" rows="2" placeholder="House # 23, Street 12, Block B, Johar Town"
                                class="w-full border border-gray-200 rounded-md px-3 py-2 focus:outline-none focus:border-[#0a1f44]">{{ old('address') }}</textarea>
                            <p class="text-xs text-gray-400 mt-1">Provide house no., street, block, area details for
                                accurate delivery.</p>
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div
                            class="mt-6 bg-blue-50 border border-blue-100 text-sm text-[#0a1f44] rounded-md px-4 py-3 flex items-center gap-2">
                            🛡️ Your information is safe with us. We never share your details with third parties.
                        </div>
                        <div id="shipping-method-container" class="hidden mt-6 border rounded-lg p-4 bg-gray-50">

                            <h3 class="font-semibold text-[#0a1f44] mb-3">
                                Select Shipping Method
                            </h3>

                            <div id="shipping-methods">

                                {{-- AJAX will append radio buttons here --}}

                            </div>

                        </div>
                        <button type="submit"
                            class="mt-6 w-full bg-[#0a1f44] hover:bg-[#0a1f44]/90 text-white font-semibold py-3 rounded-md flex items-center justify-center gap-2">
                            🔒 Place Order →
                        </button>

                        <p class="text-center text-xs text-gray-500 mt-3">No account needed — guest checkout.</p>
                    </form>
                </div>

                {{-- Order Summary (static placeholder — wire to your cart data) --}}
                <aside class="bg-white border rounded-lg p-6 h-fit">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center relative">
                                🛍️<span
                                    class="absolute -top-1 -right-1 bg-amber-400 text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center">2</span>
                            </div>
                            <h3 class="text-lg font-bold text-[#0a1f44]">Order Summary</h3>
                        </div>
                        <a href="#" class="text-sm text-[#0a1f44]">Edit Cart ✏️</a>
                    </div>
                    <div class="space-y-4 border-b pb-4">
                        {{-- Replace with your @foreach ($cartItems as $item) loop --}}
                        @php $sample = [['School Backpack (Navy Blue)', 'Premium Quality · 18 inch', 2250], ['School Uniform Set', 'Boys · Grade 6 · White', 1500], ['Class 5 Complete Book Bundle', 'Includes All Subjects', 2450]]; @endphp
                        @foreach ($cart['items'] as $p)
                                        <div class="flex gap-3">
                                            <div class="w-16 h-16 bg-gray-100 rounded-md overflow-hidden">
                                                <img src="{{ app()->environment('local')
                            ? asset('storage/' . $p['image'][0])
                            : asset('storage/' . $p['image'][0]) }}" alt="" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-semibold text-sm text-[#0a1f44]">{{ $p['name'] }}</p>
                                                <p class="text-xs text-gray-500">Premium Quality · 18 inch</p>
                                                <p class="text-xs text-gray-500">Qty: {{ $p['quantity'] }}</p>
                                            </div>
                                            <p class="text-sm font-semibold text-[#0a1f44]">PKR {{ $p['price'] }}</p>
                                        </div>
                        @endforeach
                    </div>

                    <div class="text-sm mt-4 space-y-2">
                        <div class="flex justify-between"><span class="text-gray-600">Subtotal ({{ count($cart['items']) }}
                                items)</span><span>PKR
                                {{ $cart['total'] }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-600">Delivery Charges</span>
                            <span id="shipping-charge">
                                PKR 0
                            </span>
                        </div>

                    </div>
                    <div class="bg-amber-50 mt-3 px-3 py-3 rounded-md flex justify-between font-bold text-[#0a1f44]">
                        <span>Total Amount</span>
                        <span id="grand-total">
                            PKR {{ number_format($cart['total']) }}
                        </span>
                    </div>

                    <p class="text-center text-xs text-gray-500 mt-4">🛡️ Secure payments. Multiple payment options
                        available.</p>
                </aside>
            </div>
        </div>
    </div>


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
        }

        function getRates(zoneId) {

            $shippingMethods.html('<p>Loading...</p>');

            $.ajax({
                url: '/shipping-rates/' + zoneId,
                type: 'GET',

                success: function (response) {

                    $shippingContainer.removeClass('hidden');
                    $shippingMethods.html(response);

                    resetTotals();
                },

                error: function () {

                    $shippingMethods.html(
                        '<p class="text-red-500">Unable to load shipping methods.</p>'
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

        });

    </script>



@endsection