{{-- Product Card Partial
     Variables expected:
       $product — App\Models\Product (with 'variants' relation eager-loaded)
--}}
@php
    /* ---------- Badge ---------- */
    $badgeClass = 'badge';
    $badgeText  = null;
    if ($product->discount_price && $product->price > 0) {
        $pct       = round((($product->price - $product->discount_price) / $product->price) * 100);
        $badgeText = "Save {$pct}%";
        $badgeClass = 'badge badge-orange';
    } elseif ($product->is_best_seller) {
        $badgeText = 'Best Seller';
    }

    /* ---------- Wishlist ---------- */
    $inWishlist = false;
    if (auth()->check()) {
        $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
    } else {
        $inWishlist = \App\Models\Wishlist::where('session_id', session()->getId())->where('product_id', $product->id)->exists();
    }

    /* ---------- Variant flag ---------- */
    // A product "has variants" when it has at least one ProductVariant record.
    $productHasVariants = $product->relationLoaded('variants')
        ? $product->variants->isNotEmpty()
        : $product->variants()->exists();
@endphp

<div class="product-card card flex flex-col relative group h-full">

    {{-- Badge --}}
    @if ($badgeText)
        <span class="{{ $badgeClass }} absolute top-4 left-4 z-10 shadow-sm">{{ $badgeText }}</span>
    @endif

    {{-- Wishlist --}}
    <button class="wishlist-toggle-btn absolute top-4 right-4 w-8 h-8 rounded-full bg-white shadow flex items-center justify-center z-10 transition-colors {{ $inWishlist ? 'text-rose-500' : 'text-slate-400' }} hover:text-rose-500"
            data-product-id="{{ $product->id }}"
            data-url="{{ route('wishlist.toggle', $product) }}"
            aria-label="Toggle {{ $product->name }} wishlist">
        <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart text-sm"></i>
    </button>

    {{-- Product Image --}}
    <a href="{{ route('product.show', $product) }}" class="block" tabindex="-1" aria-hidden="true">
        <div class="card-img-box">
            @if (!empty($product->images) && count($product->images) > 0)
                <img class="card-img-contain"
                     src="{{ url('storage/' . $product->images[0]) }}"
                     alt="{{ $product->name }}"
                     loading="lazy" />
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-300">
                    <i class="fa-solid fa-image text-4xl"></i>
                </div>
            @endif
        </div>
    </a>

    {{-- Product Content --}}
    <div class="p-5 flex flex-col flex-grow justify-between">
        <div>
            <a href="{{ route('product.show', $product) }}">
                <h3 class="text-sm font-bold text-[#001F54] hover:text-[#003B7A] transition-colors leading-snug line-clamp-2 mb-3">
                    {{ $product->name }}
                </h3>
            </a>
            <div class="price-row mb-4">
                <span class="text-base font-bold text-[#001F54]">
                    PKR {{ number_format($product->discount_price ?? $product->price) }}
                </span>
                @if ($product->discount_price && $product->price)
                    <span class="text-xs text-slate-400 line-through ml-2">
                        PKR {{ number_format($product->price) }}
                    </span>
                @endif
            </div>
        </div>

        {{-- CTA Button --}}
        @if ($productHasVariants)
            {{-- Has variants → link to product page to pick options --}}
            <a href="{{ route('product.show', $product) }}"
               class="primary-btn w-full justify-center text-sm">
                <i class="fa-solid fa-swatchbook"></i> View Options
            </a>
        @else
            {{-- No variants → direct add to cart --}}
            <form action="{{ route('cart.addProduct', $product) }}" method="POST" class="cart-form w-full">
                @csrf
                <button type="submit" class="primary-btn w-full justify-center text-sm">
                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                </button>
            </form>
        @endif
    </div>

</div>

