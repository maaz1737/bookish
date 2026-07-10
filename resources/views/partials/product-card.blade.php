<style>
    .product-card {
        /* min-width: 380px; */
        width: 100%;
        border: 1px solid #f0f0f0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);
    }

    .image-container {
        /* aspect-ratio: 4/ 3;
        width: 100%;
        overflow: hidden;
        background: #f4f4f5; */
        width: 100%;
        background-position: center !important;
        background-repeat: no-repeat !important;
        background-size: cover !important;
        height: 260px !important;

    }

    /* .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;

    } */

    .product-info {
        color: navy;
        padding: 11px 10px;
        font-weight: 600;
        font-size: 20px;

    }

    .amount {
        display: flex;
        gap: 12px;
        padding: 3px 0px 10px 0px;
        align-items: end;
        font-weight: 600;
        font-size: 18px
    }

    .prev-amount {
        font-size: 14px;
        font-weight: 500;
        text-decoration: line-through;
        color: gray;
        padding-bottom: 2px;
    }
</style>


<div class="product-card relative group bg-white">

    <!-- Discount / Badge -->
    <span class="{{ $badgeClass }} absolute top-4 left-4 z-10 shadow-sm">
        {{ $badgeText }}
    </span>

    <!-- Wishlist -->
    <button
        class="wishlist-toggle-btn absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-white shadow flex items-center justify-center transition-colors {{ $inWishlist ? 'text-rose-500' : 'text-slate-400' }} hover:text-rose-500"
        data-product-id="{{ $product->id }}" data-url="{{ route('wishlist.toggle', $product) }}"
        aria-label="Toggle {{ $product->name }} wishlist">

        <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
    </button>

    <!-- Image -->
    <a href="{{ route('product.show', $product) }}">
        <div class="image-container" style="background: url({{ $product->imageUrl()  }});">
            {{-- <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy"> --}}
        </div>
    </a>

    <!-- Product Info -->
    <div class="product-info">

        <a href="{{ route('product.show', $product) }}">
            <h3>{{ ucfirst($product->name) }}</h3>
        </a>

        <div class="amount">
            <p>PKR {{ number_format($product->discount_price ?? $product->price) }}</p>

            @if ($product->discount_price)
                <p class="prev-amount">
                    PKR {{ number_format($product->price) }}
                </p>
            @endif
        </div>

        <form action="{{ route('cart.addProduct', $product) }}" method="POST" class="cart-form">
            @csrf
            <button type="submit" class="primary-btn">
                <i class="fa-solid fa-cart-shopping mr-2"></i>
                Add To Cart
            </button>
        </form>

    </div>

</div>