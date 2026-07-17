@if($rates->isNotEmpty())
    <div class="mt-4 border border-gray-200/80 rounded-2xl p-4 bg-gray-50/50">
        <h3 class="font-bold text-navy-800 text-xs sm:text-sm mb-3">
            Select Shipping Method
        </h3>
        <div class="space-y-3">
            @foreach($rates as $rate)
                <label class="flex items-center justify-between p-3.5 border border-gray-200 rounded-xl cursor-pointer bg-white transition-all duration-200 hover:border-[#0a1f44] hover:shadow-sm has-[:checked]:border-[#0a1f44] has-[:checked]:bg-blue-50/40">
                    <div class="flex items-start gap-3">
                        <input type="radio" name="shipping_rate_id" value="{{ $rate->id }}" data-price="{{ $rate->price }}"
                            class="shipping-rate mt-1 text-[#0a1f44] focus:ring-[#0a1f44] border-gray-300">
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="font-bold text-xs sm:text-sm text-[#0a1f44]">
                                    {{ $rate->name }}
                                </h4>
                                @if($rate->free_shipping)
                                    <span class="px-2 py-0.5 text-[9px] font-semibold bg-green-100 text-green-700 rounded-full">
                                        Free Shipping
                                    </span>
                                @endif
                            </div>
                            @if($rate->estimated_days)
                                <p class="text-[11px] text-gray-500 mt-1">
                                    🚚 Estimated Delivery: <span class="font-semibold text-gray-700">{{ $rate->estimated_days }}</span>
                                </p>
                            @endif
                            @if($rate->free_shipping && $rate->min_order_amount)
                                <p class="text-[11px] text-green-600 mt-1">
                                    Free on orders above <strong>Rs. {{ number_format($rate->min_order_amount) }}</strong>
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="text-right pl-2 flex-shrink-0">
                        @if($rate->free_shipping && $rate->price == 0)
                            <p class="text-sm sm:text-base font-extrabold text-green-600">FREE</p>
                        @else
                            <p class="text-sm sm:text-base font-extrabold text-[#0a1f44]">Rs. {{ number_format($rate->price) }}</p>
                        @endif
                    </div>
                </label>
            @endforeach
        </div>
    </div>
@endif