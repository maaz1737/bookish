{{--
  Product Card Partial
  Variables: $p (Product), $badge ('new'|'sale'|'')
--}}
@php
    $wishlist   = session('wishlist', []);
    $inWishlist = in_array($p->id, $wishlist);
    $hasDiscount = $p->discount_price && $p->discount_price < $p->price;
    $discountPct = $hasDiscount ? round((($p->price - $p->discount_price) / $p->price) * 100) : 0;
@endphp

<div class="product-card">

    {{-- Image Area --}}
    <div class="product-img-wrap">
        <a href="{{ route('product.show', $p) }}">
            @if(!empty($p->images) && count($p->images) > 0)
                <img src="{{ asset('storage/'.$p->images[0]) }}" alt="{{ $p->name }}" loading="lazy">
            @else
                <div class="w-full h-full flex items-center justify-center text-5xl text-slate-200 p-4">
                    @if(optional($p->category)->type === 'book') 📚
                    @elseif(optional($p->category)->type === 'uniform') 👕
                    @else 🎒 @endif
                </div>
            @endif
        </a>

        {{-- Badge --}}
        @if($hasDiscount || $badge === 'sale')
            <span class="badge-discount">-{{ $discountPct }}%</span>
        @elseif($badge === 'new')
            <span class="badge-new">NEW</span>
        @endif

        {{-- Wishlist --}}
        <button
            class="wish-btn {{ $inWishlist ? 'in-wishlist' : '' }}"
            data-url="{{ route('wishlist.toggle', $p) }}"
            aria-label="Wishlist">
            <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart text-sm"></i>
        </button>
    </div>

    {{-- Info --}}
    <div class="p-3 flex flex-col flex-1">
        <h4 class="text-xs sm:text-sm font-semibold text-slate-800 line-clamp-2 min-h-[32px] leading-tight">
            <a href="{{ route('product.show', $p) }}" class="hover:text-indigo-600 transition">{{ $p->name }}</a>
        </h4>

        <div class="mt-1.5 flex items-baseline gap-1.5">
            <span class="text-orange-500 font-extrabold text-sm">PKR {{ number_format($p->effectivePrice()) }}</span>
            @if($hasDiscount)
                <span class="text-[11px] text-slate-400 line-through">PKR {{ number_format($p->price) }}</span>
            @endif
        </div>

        <div class="mt-1">
            @if($p->stock <= 0)
                <span class="text-[10px] text-red-500 font-semibold">Out of Stock</span>
            @elseif($p->stock <= 5)
                <span class="text-[10px] text-orange-500 font-semibold">Only {{ $p->stock }} left!</span>
            @else
                <span class="text-[10px] text-emerald-600 font-semibold">✓ In Stock</span>
            @endif
        </div>

        {{-- Add to Cart --}}
        <div class="mt-auto pt-3">
            <form method="POST" action="{{ route('cart.addProduct', $p) }}">
                @csrf
                <button type="submit" class="atc-btn" {{ $p->stock <= 0 ? 'disabled' : '' }}>
                    <i class="fa-solid fa-cart-plus text-xs"></i>
                    {{ $p->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                </button>
            </form>
        </div>
    </div>

</div>
