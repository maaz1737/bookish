@extends('layouts.app')

@section('content')
    <nav class="text-xs text-slate-500 mb-5 flex items-center gap-2 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-[#001F54] transition-colors">Home</a>
        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
        <a href="{{ route('categories.index') }}" class="hover:text-[#001F54] transition-colors">Categories</a>
        @if($category->parent)
            <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
            <a href="{{ route('category.show', $category->parent->slug) }}"
                class="hover:text-[#001F54] transition-colors">{{ $category?->parent?->name }}</a>
            <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
            <a href="{{ route('category.show', $category->slug) }}"
                class="text-[#001F54] transition-colors">{{ $category?->name }}</a>
        @else
            <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
            <a href="" class="text-[#001F54] transition-colors">{{ $category?->name }}</a>
        @endif
    </nav>
    <section
        class="relative overflow-hidden mb-10 rounded-[28px] bg-gradient-to-br from-navy-50 to-slate-100 p-2 md:px-8 md:py-4">

        <!-- Decorative dots -->
        <div class="absolute left-2 bottom-4 flex flex-col gap-2 opacity-70 pointer-events-none">
            @for ($row = 2; $row <= 4; $row++)
                <div class="flex gap-2">
                    @for ($dot = 0; $dot < $row; $dot++)
                        <span class="w-1.5 h-1.5 rounded-full bg-[#ff7a00]/40"></span>
                    @endfor
                </div>
            @endfor
        </div>

        <div class="absolute right-[38%] top-10 text-[#ff7a00] text-2xl pointer-events-none hidden md:block">
            ✦
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 items-center gap-6 md:gap-8 relative z-10">

            <!-- Content -->
            <div class="md:col-span-7 flex flex-col justify-center py-4 md:py-12 text-center md:text-left">

                <h1
                    class="text-2xl sm:text-3xl md:text-5xl font-bold md:font-extrabold text-[#001F54] leading-tight tracking-tight">
                    {{ $category->name }}
                </h1>

                @if ($category->description)
                    <p class="text-slate-600 text-sm sm:text-base mt-4 max-w-full md:max-w-md leading-relaxed mx-auto md:mx-0">
                        {{ $category->description }}
                    </p>
                @endif

                <div class="mt-5">
                    <a href="#products"
                        class="inline-flex items-center gap-2 bg-[#001F54] hover:bg-[#001440] text-white font-semibold text-sm px-4 py-2 rounded-xl transition-colors">
                        Explore {{ $category->name }}
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Image -->
            @if ($category->image)
                <div class="md:col-span-5 h-52 sm:h-64 md:h-[380px] bg-center bg-contain bg-no-repeat"
                    style="background-image: url('{{ $category->imageUrl() }}');">
                </div>
            @endif

        </div>
    </section>

    @if ($category->children->count())
        <div class="space-y-14 filter-container">
            @foreach ($category->children as $sub)
                @if ($sub->childProducts->count())
                    <section>
                        {{-- Section Heading --}}
                        <div class="flex flex-row sm:items-center justify-between gap-2 mb-4">
                            <h2 class="flex items-center gap-2 text-xl md:text-2xl font-bold text-[#001F54]">
                                <span class="w-1 h-7 bg-[#ff7a00] rounded-full inline-block shrink-0"></span>
                                {{ $sub->name }}
                            </h2>
                            <a href="{{ route('category.show', $sub->slug) }}"
                                class="flex items-center gap-1 whitespace-nowrap text-sm font-semibold text-[#001F54] transition-colors hover:text-[#ff7a00]">
                                View All <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>

                        {{-- Product Grid --}}
                        <div class="grid-4 mt-3 md:mt-0">
                            @foreach ($sub->childProducts as $product)
                                @include('partials.product-card', ['product' => $product])
                            @endforeach
                        </div>
                    </section>
                @endif
            @endforeach
        </div>
    @endif
    @if ($category->products->count())
        <section id="products" class="mt-14 filter-container">
            <div class="mb-3 pb-1 md:mb-6 md:pb-3 border-b-2 border-slate-100">
                <h2 class="flex items-center gap-1 text-xl md:text-2xl font-bold text-[#001F54]">
                    <span class="w-1 h-7 bg-[#ff7a00] rounded-full inline-block shrink-0"></span>
                    All Products
                </h2>
            </div>
            <div class="grid-3">
                @foreach ($category->products as $product)
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
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </section>
    @endif

    @if ($category->childProducts->count())
        <div class="grid-3 filter-container">
            @foreach ($category->childProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    @endif

    @if(!$category->children->count() && !$category->products->count() && !$category->childProducts->count())
        <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 p-16 text-center" id="products">
            <div class="text-7xl mb-4 opacity-60">📦</div>
            <h2 class="text-2xl font-bold text-[#001F54] mb-2">No Products Found</h2>
            <p class="text-slate-500 max-w-md mx-auto">No products have been added to this category yet. Please check
                back later.</p>
            <div class="mt-3">
                <a href="{{ route('products.index') }}" class="primary-btn px-3">Browse All Products</a>
            </div>
        </div>
    @endif



    @include('partials.trust-section')


@endsection