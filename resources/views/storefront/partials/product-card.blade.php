{{-- Product Card Partial
Variables expected:
$product — App\Models\Product (with 'variants' relation eager-loaded)
--}}
@php
    /* ---------- Badge ---------- */
    $badgeText  = null;
    $pctOff     = 0;
    if ($product->discount_price && $product->price > 0) {
        $pctOff    = round((($product->price - $product->discount_price) / $product->price) * 100);
        $badgeText = "{$pctOff}% OFF";
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
    $productHasVariants = $product->relationLoaded('variants')
        ? $product->variants->isNotEmpty()
        : $product->variants()->exists();
@endphp

<div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-[0_2px_12px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.10)] hover:-translate-y-0.5 transition-all duration-300 flex flex-col relative group">

    {{-- Badge --}}
    @if ($badgeText)
        <span class="absolute top-3 left-3 z-10 bg-[#ff7a00] text-white text-[10px] sm:text-xs font-bold px-2 py-1 rounded-md leading-none shadow-sm">
            {{ $badgeText }}
        </span>
    @endif

    {{-- Wishlist Heart --}}
    <button
        class="wishlist-toggle-btn absolute top-3 right-3 w-8 h-8 rounded-full bg-white shadow-sm border border-slate-100 flex items-center justify-center z-10 transition-all duration-200 hover:scale-110 {{ $inWishlist ? 'text-rose-500' : 'text-slate-400' }} hover:text-rose-500"
        data-product-id="{{ $product->id }}" data-url="{{ route('wishlist.toggle', $product) }}"
        aria-label="Toggle {{ $product->name }} wishlist">
        <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart text-sm"></i>
    </button>

    {{-- Product Image --}}
    <a href="{{ route('product.show', $product) }}" class="block" tabindex="-1" aria-hidden="true">
        <div class="w-full bg-[#f8fafc] overflow-hidden" style="aspect-ratio: 4/3;">
            <img
                src="{{ $product->imageUrl() }}"
                alt="{{ $product->name }}"
                loading="lazy"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            />
        </div>
    </a>

    {{-- Product Content --}}
    <div class="p-3 sm:p-4 flex flex-col flex-grow">

        {{-- Name --}}
        <a href="{{ route('product.show', $product) }}" class="block mb-2 cursor-pointer text-[#001F54] hover:text-[#ff7a00] group-hover:text-[#ff7a00] transition-colors">
            <h3 class="text-sm font-bold leading-snug line-clamp-2">
                {{ $product->name }}
            </h3>
        </a>

        {{-- Price Row --}}
        <div class="flex items-baseline gap-2 mb-4 mt-auto">
            <span class="text-base font-extrabold text-[#0a1a3d]">
                PKR {{ number_format($product->discount_price ?? $product->price) }}
            </span>
            @if ($product->discount_price && $product->price)
                <span class="text-xs text-slate-400 line-through font-medium">
                    PKR {{ number_format($product->price) }}
                </span>
            @endif
        </div>

        {{-- CTA Button --}}
        @if ($productHasVariants)
            <a href="{{ route('product.show', $product) }}"
               class="w-full bg-[#0a1a3d] hover:bg-[#1e3a8a] text-white text-xs sm:text-sm font-semibold py-2.5 rounded-xl flex items-center justify-center gap-2 transition-colors duration-200 shadow-sm">
                <i class="fa-solid fa-swatchbook text-xs"></i> View Options
            </a>
        @else
            <form action="{{ route('cart.addProduct', $product) }}" method="POST" class="cart-form w-full">
                @csrf
                <button type="submit"
                    class="primary-btn relative w-full rounded-lg bg-[#001F54] py-2 md:py-2.5 text-sm md:text-base font-medium text-white transition-all duration-200 hover:bg-[#223a8f] hover:shadow-md active:scale-[0.98]">
                    <i class="fa-solid fa-cart-shopping text-xs"></i> Add to Cart
                </button>
            </form>
        @endif

    </div>

</div>