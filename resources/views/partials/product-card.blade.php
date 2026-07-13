@php
    $badgeClass = 'badge';
    if ($product->discount_price && $product->price > 0) {
        $pct = round((($product->price - $product->discount_price) / $product->price) * 100);
        $badgeText = "Save {$pct}%";
        $badgeClass = 'badge badge-orange';
    } else {
        $badgeText = 'Best Seller';
    }
    $inWishlist = false;
    if (auth()->check()) {
        $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
    } else {
        $inWishlist = \App\Models\Wishlist::where('session_id', session()->getId())->where('product_id', $product->id)->exists();
    }
@endphp
<div class="product-card relative group bg-white">

    <!-- Discount / Badge -->
    <span
        class="{{ $badgeClass ?? '' }} absolute top-2 left-2 md:top-4 md:left-4 z-10 shadow-sm text-[10px] md:text-xs px-2 py-1 md:px-2.5 md:py-1.5">
        {{ $badgeText ?? "" }}
    </span>

    <!-- Wishlist -->
    <button class="wishlist-toggle-btn absolute top-2 right-2 md:top-4 md:right-4 z-10 flex items-center justify-center
           w-7 h-7 md:w-8 md:h-8
           rounded-full bg-white shadow transition-all duration-200
           {{ $inWishlist ? 'text-rose-500' : 'text-slate-400' }}
           hover:text-rose-500 hover:shadow-md hover:scale-105" data-product-id="{{ $product->id }}"
        data-url="{{ route('wishlist.toggle', $product) }}" aria-label="Toggle {{ $product->name }} wishlist">

        <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart text-xs md:text-sm"></i>

    </button>

    <!-- Image -->
    <a href="{{ route('product.show', $product) }}">
        <div class="image-container" style="background: url({{ $product->imageUrl()  }});">
            {{-- <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy"> --}}
        </div>
    </a>

    <!-- Product Info -->
    <div class="text-[#001F54] px-2.5 py-2 font-semibold text-sm md:text-base lg:text-lg">
        <a href="{{ route('product.show', $product) }}">
            <h3>{{ ucfirst($product->name) }}</h3>
        </a>

        <div class="flex items-end gap-2 pb-3">
            <p class="text-[#001F54] font-bold text-sm md:text-base lg:text-lg">
                PKR {{ number_format($product->discount_price ?? $product->price) }}
            </p>

            @if ($product->discount_price)
                <p class="text-gray-500 line-through text-xs md:text-sm pb-[2px]">
                    PKR {{ number_format($product->price) }}
                </p>
            @endif
        </div>

        <form action="{{ route('cart.addProduct', $product) }}" method="POST" class="cart-form">
            @csrf
            <button type="submit"
                class="w-full rounded-lg bg-[#001F54] py-2 md:py-2.5 text-sm md:text-base font-medium text-white transition-all duration-200 hover:bg-[#003080] hover:shadow-md active:scale-[0.98]">

                <i class="fa-solid fa-cart-shopping mr-1 md:mr-2"></i>

                <span class="lg:hidden">Add</span>
                <span class="hidden lg:inline">Add To Cart</span>

            </button>
        </form>

    </div>

</div>