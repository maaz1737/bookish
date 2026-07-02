@forelse($rates as $rate)

    <label
        class="flex items-center justify-between p-4 mb-4 border rounded-xl cursor-pointer transition-all duration-200 hover:border-[#0a1f44] hover:shadow-md has-[:checked]:border-[#0a1f44] has-[:checked]:bg-blue-50">

        <div class="flex items-start gap-4">

            <input type="radio" name="shipping_rate_id" value="{{ $rate->id }}" data-price="{{ $rate->price }}"
                class="shipping-rate mr-3">

            <div>

                <div class="flex items-center gap-2">

                    <h4 class="font-semibold text-[#0a1f44]">
                        {{ $rate->name }}
                    </h4>

                    @if($rate->free_shipping)
                        <span class="px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 rounded-full">
                            Free Shipping
                        </span>
                    @endif

                </div>

                @if($rate->estimated_days)
                    <p class="text-sm text-gray-500 mt-1">
                        🚚 Estimated Delivery:
                        <span class="font-medium">{{ $rate->estimated_days }}</span>
                    </p>
                @endif

                @if($rate->free_shipping && $rate->min_order_amount)
                    <p class="text-sm text-green-600 mt-1">
                        Free on orders above
                        <strong>Rs. {{ number_format($rate->min_order_amount) }}</strong>
                    </p>
                @endif

            </div>

        </div>

        <div class="text-right">

            @if($rate->free_shipping && $rate->price == 0)

                <p class="text-xl font-bold text-green-600">
                    FREE
                </p>

            @else

                <p class="text-xl font-bold text-[#0a1f44]">
                    Rs. {{ number_format($rate->price) }}
                </p>

            @endif

        </div>

    </label>

@empty

    <div class="border rounded-xl p-6 text-center bg-gray-50">

        <div class="text-5xl mb-3">
            🚚
        </div>

        <h3 class="text-lg font-semibold text-gray-700">
            No Shipping Methods Available
        </h3>

        <p class="text-sm text-gray-500 mt-2">
            There are currently no shipping methods available for the selected province.
        </p>

    </div>

@endforelse