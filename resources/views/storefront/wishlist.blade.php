@extends('layouts.app')

@section('content')

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-navy-800 to-navy-900 text-white rounded-[24px] p-10 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-20 h-20 bg-white text-navy-800 rounded-full flex items-center justify-center text-4xl shadow-lg">
                ❤️
            </div>
            <div>
                <h1 class="text-4xl font-bold">
                    My Wishlist
                </h1>
                <p class="mt-2 text-slate-200">
                    Your saved items. Add them to your cart directly from here.
                </p>
            </div>
        </div>
    </section>

    <!-- Wishlist Grid -->
    @if ($wishlistItems->count() > 0)
        <div class="grid-4" id="wishlist-grid">
            @foreach ($wishlistItems as $item)
                @php
                    $product = $item->product;
                @endphp
                @if ($product)
                    <div class="product-card card flex flex-col justify-between relative group h-full" id="wishlist-item-{{ $product->id }}">
                        
                        <!-- Remove button -->
                        <button class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-rose-500 hover:bg-rose-50 z-10 transition-colors remove-wishlist-btn" 
                            data-product-id="{{ $product->id }}" 
                            data-url="{{ route('wishlist.remove', $product) }}"
                            aria-label="Remove {{ $product->name }} from wishlist">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>

                        <!-- Product Image -->
                        <a href="{{ route('product.show', $product) }}" class="block">
                            <div class="card-img-box">
                                @if (isset($product->images) && count($product->images) > 0)
                                    <img class="card-img-contain"
                                        src="{{ url('storage/' . $product->images[0]) }}"
                                        alt="{{ $product->name }}" loading="lazy" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300 text-sm">
                                        <i class="fa-solid fa-image text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                        </a>

                        <!-- Name & Price & Form inside a padded area -->
                        <div class="p-5 flex-grow flex flex-col justify-between">
                            <div>
                                <a href="{{ route('product.show', $product) }}" class="hover:no-underline">
                                    <h3 class="text-sm font-bold text-[#001F54] hover:text-[#003B7A] transition-colors leading-tight line-clamp-2 mb-2">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                            </div>

                            <div class="price-row mb-4">
                                <span class="price text-lg font-bold text-[#001F54]">PKR {{ number_format($product->discount_price ?? $product->price) }}</span>
                                @if ($product->discount_price && $product->price)
                                    <span class="old-price text-xs text-slate-400 line-through ml-2">PKR {{ number_format($product->price) }}</span>
                                @endif
                            </div>

                            <!-- CTA Button -->
                            <form action="{{ route('cart.addProduct', $product) }}" method="POST" class="cart-form w-full">
                                @csrf
                                <button type="submit" class="primary-btn w-full justify-center">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-[24px] shadow-sm p-12 text-center border border-slate-200" id="empty-wishlist-msg">
            <div class="text-6xl mb-4">❤️</div>
            <h2 class="text-2xl font-bold text-[#001F54] mb-2">Your wishlist is empty</h2>
            <p class="text-slate-500 mb-6">Explore our collections and add products you love to your wishlist.</p>
            <a href="{{ route('products.index') }}" class="primary-btn px-6 py-3 inline-flex">
                Start Shopping
            </a>
        </div>
    @endif

    <!-- Ajax Removal Handling -->
    <script>
        $(document).ready(function() {
            $('.remove-wishlist-btn').on('click', function(e) {
                e.preventDefault();
                var btn = $(this);
                var productId = btn.data('product-id');
                var url = btn.data('url');

                if (confirm('Remove this product from wishlist?')) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                // Remove item from grid
                                $('#wishlist-item-' + productId).fadeOut(300, function() {
                                    $(this).remove();
                                    
                                    // If no items left, show empty state message
                                    if ($('#wishlist-grid').children().length === 0) {
                                        $('#wishlist-grid').replaceWith(`
                                            <div class="bg-white rounded-[24px] shadow-sm p-12 text-center border border-slate-200">
                                                <div class="text-6xl mb-4">❤️</div>
                                                <h2 class="text-2xl font-bold text-[#001F54] mb-2">Your wishlist is empty</h2>
                                                <p class="text-slate-500 mb-6">Explore our collections and add products you love to your wishlist.</p>
                                                <a href="{{ route('products.index') }}" class="primary-btn px-6 py-3 inline-flex">
                                                    Start Shopping
                                                </a>
                                            </div>
                                        `);
                                    }
                                });

                                // Update header count badge
                                if (response.count !== undefined) {
                                    $('.wishlist-badge').text(response.count);
                                    if (response.count === 0) {
                                        $('.wishlist-badge').hide();
                                    } else {
                                        $('.wishlist-badge').show();
                                    }
                                }
                            }
                        },
                        error: function() {
                            alert('Something went wrong. Please try again.');
                        }
                    });
                }
            });
        });
    </script>

@endsection
