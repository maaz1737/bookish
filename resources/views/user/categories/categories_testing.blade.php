@extends('layouts.app')

@section('content')

<style>
  body { font-family: 'Inter', sans-serif; background:#F7F8FA; color:#0B1B47; }
  .checkbox { appearance:none; width:18px; height:18px; border:1.5px solid #C9D2E3; border-radius:4px; display:inline-block; vertical-align:middle; position:relative; cursor:pointer; }
  .checkbox:checked { background:#0B1B47; border-color:#0B1B47; }
  .checkbox:checked::after { content:"✓"; color:#fff; font-size:12px; position:absolute; left:3px; top:-2px; }
  .swatch { width:22px; height:22px; border-radius:50%; display:inline-block; border:2px solid #fff; box-shadow:0 0 0 1px #C9D2E3; cursor:pointer; }
  .range-track { position:relative; height:4px; background:#E2E8F0; border-radius:9999px; }
  .range-fill { position:absolute; height:4px; background:#0B1B47; border-radius:9999px; left:5%; right:8%; }
  .range-thumb { position:absolute; top:50%; transform:translate(-50%,-50%); width:14px; height:14px; border-radius:50%; background:#0B1B47; }
</style>

<div class="max-w-[1200px] mx-auto px-4 text-xs text-slate-500 flex items-center gap-2">
  <span><a href="{{ route('home') }}" class="hover:underline">Home</a></span><i class="fa-solid fa-chevron-right text-[8px]"></i>
  <span class="text-navy font-medium">{{ $category->name }}</span>
  @if(request('subcategory'))
    <i class="fa-solid fa-chevron-right text-[8px]"></i>
    <span class="text-navy font-medium">{{ ucfirst(request('subcategory')) }}</span>
  @endif
</div>

<section class="max-w-[1200px] mx-auto px-4 mt-6">
  <div class="rounded-xl bg-blue-100 px-5 py-6 sm:px-10 sm:py-8 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
    <div class="max-w-lg">
      <h1 class="text-2xl sm:text-4xl font-extrabold text-navy">
        {{ $category->name }}
        @if(request('subcategory'))
          - {{ ucfirst(request('subcategory')) }}
        @endif
      </h1>
      <p class="mt-3 text-slate-600 text-sm">{{ $category->description ?? 'Explore high-quality essentials for students.' }}</p>
      <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div class="bg-white rounded-lg px-3 py-3 flex items-center gap-3 shadow-sm">
          <i class="fa-solid fa-shield-halved text-navy"></i>
          <div>
            <div class="text-xs font-semibold text-navy">Premium Quality</div>
            <div class="text-[10px] text-slate-500">Built to last</div>
          </div>
        </div>
        <div class="bg-white rounded-lg px-3 py-3 flex items-center gap-3 shadow-sm">
          <i class="fa-solid fa-bag-shopping text-navy"></i>
          <div>
            <div class="text-xs font-semibold text-navy">Ergonomic Design</div>
            <div class="text-[10px] text-slate-500">Comfort all day</div>
          </div>
        </div>
        <div class="bg-white rounded-lg px-3 py-3 flex items-center gap-3 shadow-sm">
          <i class="fa-solid fa-droplet text-navy"></i>
          <div>
            <div class="text-xs font-semibold text-navy">Water Resistant</div>
            <div class="text-[10px] text-slate-500">Keep things safe</div>
          </div>
        </div>
      </div>
    </div>
    <div class="relative">
      <div class="absolute inset-0 m-auto w-48 h-48 sm:w-64 sm:h-64 rounded-full bg-blue-100/60"></div>
      <i class="fa-regular fa-lightbulb absolute -top-2 right-2 text-blue-300 text-xl"></i>
      <i class="fa-solid fa-paper-plane absolute top-4 -left-10 text-blue-300"></i>
      @if($category->image)
        <img src="{{ app()->environment('production') ? url('storage/app/public/' . $category->image) : asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="relative z-10 w-48 h-48 sm:w-64 sm:h-64 object-contain">
      @else
        <div class="relative z-10 w-48 h-48 sm:w-64 sm:h-64 flex items-center justify-center text-7xl bg-white/20 rounded-full">
          🎒
        </div>
      @endif
    </div>
  </div>
</section>

<main class="max-w-[1200px] mx-auto px-4 py-8 grid grid-cols-1 lg:grid-cols-12 gap-6">

  <!-- Sidebar Filters -->
  <aside class="lg:col-span-3 bg-white rounded-lg p-5 h-fit border border-slate-200">
    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
      <h3 class="font-semibold text-navy">Filter By</h3>
      @if(request('subcategory') || request('color'))
        <a href="{{ route('category.show', $category->slug) }}" class="text-brand text-xs font-medium hover:underline">Clear All</a>
      @else
        <span class="text-slate-300 text-xs font-medium">Clear All</span>
      @endif
    </div>

    <!-- Category / Subcategories -->
    <div class="py-4 border-b border-slate-200">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-navy text-sm">Subcategories</h4>
        <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
      </div>
      <div class="space-y-2 text-sm max-h-48 overflow-y-auto pr-1">
        @foreach($subcategories as $sub)
          @php
            $isChecked = request('subcategory') === $sub->slug;
            // Generate link to toggle filter
            $link = route('category.show', $category->slug) . ($isChecked ? '' : '?subcategory=' . $sub->slug);
            // Include color if already filtered
            if (request('color') && !$isChecked) {
                $link .= '&color=' . request('color');
            } elseif (request('color') && $isChecked) {
                $link .= '?color=' . request('color');
            }
          @endphp
          <label class="flex items-center gap-2 cursor-pointer hover:text-indigo-600 transition">
            <input type="checkbox" class="checkbox cursor-pointer" {{ $isChecked ? 'checked' : '' }} onclick="window.location.href='{{ $link }}'">
            {{ $sub->name }}
          </label>
        @endforeach
      </div>
    </div>

    <!-- Price Range -->
    <div class="py-4 border-b border-slate-200">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-navy text-sm">Price Range</h4>
        <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
      </div>
      <div class="mt-4 px-2">
        <div class="range-track">
          <div class="range-fill"></div>
          <div class="range-thumb" style="left:5%"></div>
          <div class="range-thumb" style="left:92%"></div>
        </div>
        <div class="flex items-center justify-between mt-4 text-xs text-slate-500">
          <span>Min: PKR 500</span>
          <span>Max: PKR 5,000</span>
        </div>
      </div>
    </div>

    <!-- Color Filter -->
    <div class="py-4 border-b border-slate-200">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-navy text-sm">Color</h4>
        <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
      </div>
      <div class="flex flex-wrap gap-2">
        @php
          $colors = [
              'navy' => '#0B1B47',
              'black' => '#000',
              'purple' => '#B95FB7',
              'pink' => '#F4B6CB',
              'blue' => '#2E63C8',
              'teal' => '#1FA39A'
          ];
        @endphp

        @foreach($colors as $name => $hex)
          @php
            $isColorActive = request('color') === $name;
            // Generate link to toggle color
            $link = route('category.show', $category->slug);
            $queryParams = [];
            if (request('subcategory')) {
                $queryParams['subcategory'] = request('subcategory');
            }
            if (!$isColorActive) {
                $queryParams['color'] = $name;
            }
            if (count($queryParams) > 0) {
                $link .= '?' . http_build_query($queryParams);
            }
          @endphp
          <a href="{{ $link }}" class="swatch transition hover:scale-110 flex items-center justify-center" style="background:{{ $hex }}; border: {{ $isColorActive ? '3px solid #f97316' : '2px solid #fff' }};" title="Filter by {{ ucfirst($name) }}">
            @if($isColorActive)
              <i class="fa-solid fa-check text-[10px] text-white"></i>
            @endif
          </a>
        @endforeach
      </div>
      @if(request('color'))
        <div class="mt-2 text-xs text-slate-500 flex items-center justify-between">
          <span>Active: <strong>{{ ucfirst(request('color')) }}</strong></span>
          <a href="{{ route('category.show', $category->slug) . (request('subcategory') ? '?subcategory=' . request('subcategory') : '') }}" class="text-brand hover:underline">Remove</a>
        </div>
      @endif
    </div>

    <!-- Material -->
    <div class="py-4 border-b border-slate-200">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-navy text-sm">Material</h4>
        <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
      </div>
      <div class="space-y-2 text-sm">
        <label class="flex items-center gap-2"><input type="checkbox" class="checkbox"> Nylon</label>
        <label class="flex items-center gap-2"><input type="checkbox" class="checkbox"> Polyester</label>
        <label class="flex items-center gap-2"><input type="checkbox" class="checkbox"> Canvas</label>
        <label class="flex items-center gap-2"><input type="checkbox" class="checkbox"> PU Leather</label>
      </div>
    </div>

    <!-- Features -->
    <div class="py-4">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-navy text-sm">Features</h4>
        <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
      </div>
      <div class="space-y-2 text-sm">
        <label class="flex items-center gap-2"><input type="checkbox" class="checkbox"> Water Resistant</label>
        <label class="flex items-center gap-2"><input type="checkbox" class="checkbox"> Laptop Compartment</label>
        <label class="flex items-center gap-2"><input type="checkbox" class="checkbox"> Reflective Strips</label>
        <label class="flex items-center gap-2"><input type="checkbox" class="checkbox"> Lightweight</label>
      </div>
    </div>
  </aside>

  <!-- Product Grid -->
  <section class="lg:col-span-9">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
      @if($products->total() > 0)
        <p class="text-sm text-slate-600">Showing <span class="font-semibold text-navy">{{ $products->firstItem() }}–{{ $products->lastItem() }}</span> of {{ $products->total() }} products</p>
      @else
        <p class="text-sm text-slate-600">No products found</p>
      @endif
      <div class="flex items-center gap-3 text-sm">
        <span class="text-slate-500">Sort by:</span>
        <div class="border border-slate-300 rounded-md px-3 py-1.5 flex items-center gap-6">Popular <i class="fa-solid fa-chevron-down text-xs"></i></div>
      </div>
    </div>

    @if($products->count() > 0)
      <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4" id="product-grid">
        @foreach($products as $p)
          <div class="bg-white rounded-lg border border-slate-200 overflow-hidden group flex flex-col justify-between h-full">
            <div>
              <div class="relative bg-slate-50 aspect-square flex items-center justify-center">
                <a href="{{ route('product.show', $p) }}" class="w-full h-full flex items-center justify-center">
                  @if(!empty($p->images) && count($p->images) > 0)
                    <img src="{{ app()->environment('production') ? url('storage/app/public/' . $p->images[0]) : asset('storage/' . $p->images[0]) }}" alt="{{ $p->name }}" class="w-full h-full object-contain p-3 transition duration-300 group-hover:scale-105">
                  @else
                    <div class="text-5xl text-gray-300">
                      🎒
                    </div>
                  @endif
                </a>
                <button class="absolute top-2 right-2 w-7 h-7 bg-white rounded-full shadow flex items-center justify-center text-slate-400 hover:text-orange-500">
                  <i class="fa-regular fa-heart text-xs"></i>
                </button>
              </div>

              <div class="p-3">
                <h4 class="text-sm font-semibold text-navy line-clamp-2 min-h-[40px]">
                  <a href="{{ route('product.show', $p) }}" class="hover:text-indigo-600 transition">
                    {{ $p->name }}
                  </a>
                </h4>

                <div class="mt-1 flex items-baseline gap-2">
                  <span class="text-brand font-bold text-sm">
                    PKR {{ number_format($p->effectivePrice()) }}
                  </span>
                  @if($p->discount_price && $p->discount_price < $p->price)
                    <span class="text-xs text-slate-400 line-through">
                      PKR {{ number_format($p->price) }}
                    </span>
                  @endif
                </div>
              </div>
            </div>

            <div class="p-3 pt-0">
              <form method="POST" action="{{ route('cart.addProduct', $p) }}">
                @csrf
                <button type="submit" class="w-full bg-[#0B1B47] hover:bg-opacity-90 text-white text-xs font-medium py-2 rounded flex items-center justify-center gap-2 transition" {{ $p->stock <= 0 ? 'disabled' : '' }}>
                  <i class="fa-solid fa-cart-shopping text-[10px]"></i>
                  {{ $p->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                </button>
              </form>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Pagination -->
      @if ($products->hasPages())
        <div class="mt-8 flex justify-center">
          {{ $products->links() }}
        </div>
      @endif
    @else
      <div class="bg-white rounded-lg border border-slate-200 p-12 text-center my-8">
        <div class="text-6xl mb-4">📦</div>
        <h3 class="text-lg font-bold text-navy mb-2">No Products Available</h3>
        <p class="text-slate-500 text-sm">There are no products in this category matching your filters. Please adjust your criteria or check back later.</p>
      </div>
    @endif
  </section>
</main>

<section class="bg-gray-200 border-t border-slate-200">
  <div class=" max-w-[1200px] mx-auto px-4 py-6 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
    <div class="flex items-center gap-3"><i class="fa-solid fa-shield text-navy text-xl"></i><div><div class="font-semibold text-xs">100% Original</div><div class="text-[10px] text-slate-500">Products</div></div></div>
    <div class="flex items-center gap-3"><i class="fa-solid fa-circle-dollar-to-slot text-navy text-xl"></i><div><div class="font-semibold text-xs">Best Prices</div><div class="text-[10px] text-slate-500">Guaranteed</div></div></div>
    <div class="flex items-center gap-3"><i class="fa-solid fa-medal text-navy text-xl"></i><div><div class="font-semibold text-xs">Trusted by</div><div class="text-[10px] text-slate-500">Thousands</div></div></div>
    <div class="flex items-center gap-3"><i class="fa-solid fa-rotate-left text-navy text-xl"></i><div><div class="font-semibold text-xs">Hassle Free Returns</div><div class="text-[10px] text-slate-500">Easy return policy</div></div></div>
    <div class="flex items-center gap-3"><i class="fa-solid fa-wallet text-navy text-xl"></i><div><div class="font-semibold text-xs">Secure Payments</div><div class="text-[10px] text-slate-500">Your payments are safe with us</div></div></div>
    <div class="flex items-center gap-3"><i class="fa-solid fa-headset text-navy text-xl"></i><div><div class="font-semibold text-xs">24/7 Support</div><div class="text-[10px] text-slate-500">We are here to help you</div></div></div>
  </div>
</section>

<!-- Highlights bar -->
<section class="max-w-[1200px] mx-auto px-4 my-6">
  <div class="bg-blue-900 text-white rounded-xl px-5 sm:px-8 py-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="flex items-center gap-3"><i class="fa-solid fa-users text-gray-200 text-xl"></i><div><div class="font-semibold text-sm">1000+ Happy Customers</div><div class="text-xs text-slate-300">Join our growing family</div></div></div>
    <div class="flex items-center gap-3"><i class="fa-solid fa-truck-fast text-gray-200 text-xl"></i><div><div class="font-semibold text-sm">Fast &amp; Reliable Delivery</div><div class="text-xs text-slate-300">Across Pakistan</div></div></div>
    <div class="flex items-center gap-3"><i class="fa-solid fa-credit-card text-gray-200 text-xl"></i><div><div class="font-semibold text-sm">Secure Payment Methods</div><div class="text-xs text-slate-300">IBFT / Raast</div></div></div>
    <div class="flex items-center gap-3"><i class="fa-solid fa-headphones text-gray-200 text-xl"></i><div><div class="font-semibold text-sm">Dedicated Support</div><div class="text-xs text-slate-300">We're here for you</div></div></div>
  </div>
</section>

@endsection