@extends('layouts.app')

@section('content')

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-navy-800 to-navy-900 text-white rounded-3xl p-10 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-20 h-20 bg-white text-navy-800 rounded-full flex items-center justify-center text-4xl shadow-lg">
                📚
            </div>
            <div>
                <h1 class="text-4xl font-bold">
                    All Products Collection
                </h1>
                <p class="mt-2 text-slate-200">
                    Explore high-quality school essentials, books, uniforms, bags, and baby wear.
                </p>
                <div class="mt-4 inline-flex bg-white/20 px-4 py-2 rounded-full text-sm">
                    {{ $products->total() }} Products Available
                </div>
            </div>
        </div>
    </section>

    <!-- Description Banner -->
    <div class="bg-white rounded-3xl shadow-sm p-6 mb-10 border border-slate-200">
        <div class="flex items-center gap-4">
            <div class="text-4xl">
                🎒
            </div>
            <div>
                <h2 class="font-bold text-xl text-navy-950">
                    Everything Your Child Needs For School
                </h2>
                <p class="text-gray-500 mt-1">
                    Find books, uniforms, bags, stationery and other school items carefully selected for students.
                </p>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    @if ($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($products as $product)
                @php
                    $inWishlist = false;
                    if (auth()->check()) {
                        $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                    } else {
                        $inWishlist = \App\Models\Wishlist::where('session_id', session()->getId())->where('product_id', $product->id)->exists();
                    }
                @endphp
                <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition duration-300 border border-slate-200 flex flex-col h-full relative">
                    <!-- Wishlist Button -->
                    <button class="wishlist-toggle-btn absolute top-4 right-4 w-9 h-9 rounded-full bg-white shadow flex items-center justify-center z-10 transition {{ $inWishlist ? 'text-rose-500' : 'text-slate-400' }} hover:text-rose-500"
                        data-product-id="{{ $product->id }}"
                        data-url="{{ url('/wishlist/toggle/' . $product->id) }}"
                        aria-label="Toggle {{ $product->name }} wishlist">
                        <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                    </button>

                    <!-- Product Image -->
                    <a href="{{ route('product.show', $product) }}" class="block">
                        <div class="card-img-box">
                            @if (isset($product->images) && count($product->images) > 0)
                                <img src="{{ url('storage/' . $product->images[0]) }}"
                                    alt="{{ $product->name }}"
                                    class="card-img-contain">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300 text-sm">
                                    <i class="fa-solid fa-image text-4xl"></i>
                                </div>
                            @endif
                        </div>
                    </a>

                    <!-- Product Content -->
                    <div class="p-5 flex flex-col flex-grow">
                        <a href="{{ route('product.show', $product) }}" class="hover:text-gold-500 transition">
                            <h3 class="font-bold text-lg text-gray-800 group-hover:text-indigo-600 transition line-clamp-2">
                                {{ $product->name }}
                            </h3>
                        </a>
                        <p class="text-gray-500 text-sm mt-2 line-clamp-2 flex-grow">
                            {{ $product->description ?? 'School quality products for everyday student needs.' }}
                        </p>

                        <div class="mt-5 flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-xl font-bold text-navy-800">
                                        PKR {{ number_format($product->effectivePrice()) }}
                                    </span>
                                    @if($product->discount_price && $product->price)
                                        <span class="text-xs text-slate-400 line-through block">
                                            PKR {{ number_format($product->price) }}
                                        </span>
                                    @endif
                                </div>
                                <a href="{{ route('product.show', $product) }}" class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full text-sm font-medium hover:bg-indigo-100 transition">
                                    View
                                </a>
                            </div>

                            {{-- Add to Cart Form --}}
                            <form action="{{ route('cart.addProduct', $product) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-navy-800 text-white py-2 rounded-xl text-sm font-semibold hover:bg-navy-900 transition flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-3xl shadow p-12 text-center">
            <div class="text-8xl mb-5">
                📦
            </div>
            <h2 class="text-3xl font-bold mb-3">
                No Products Found
            </h2>
            <p class="text-gray-500 max-w-lg mx-auto">
                No products have been added yet. Please check back later.
            </p>
        </div>
    @endif

    <!-- Pagination -->
    @if ($products->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $products->links() }}
        </div>
    @endif

@endsection
