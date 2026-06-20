@extends('layouts.app')

@section('content')

<style>
  body { font-family: 'Inter', sans-serif; background:#F7F8FA; color:#0B1B47; }

  /* Custom checkbox */
  .checkbox { appearance:none; width:18px; height:18px; border:1.5px solid #C9D2E3; border-radius:4px; display:inline-block; vertical-align:middle; position:relative; cursor:pointer; transition: background 0.15s, border-color 0.15s; }
  .checkbox:checked { background:#0B1B47; border-color:#0B1B47; }
  .checkbox:checked::after { content:"✓"; color:#fff; font-size:12px; position:absolute; left:3px; top:-2px; }

  /* Color swatch */
  .swatch { width:24px; height:24px; border-radius:50%; display:inline-block; border:2px solid #fff; box-shadow:0 0 0 1.5px #C9D2E3; cursor:pointer; transition:transform 0.15s, box-shadow 0.15s; }
  .swatch:hover { transform:scale(1.15); }
  .swatch.active { box-shadow:0 0 0 2px #f97316; }

  /* Range slider style */
  .range-track { position:relative; height:4px; background:#E2E8F0; border-radius:9999px; }
  .range-fill  { position:absolute; height:4px; background:#0B1B47; border-radius:9999px; left:5%; right:8%; }
  .range-thumb { position:absolute; top:50%; transform:translate(-50%,-50%); width:14px; height:14px; border-radius:50%; background:#0B1B47; }

  /* Product card */
  .product-card { transition: transform 0.2s, box-shadow 0.2s; }
  .product-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(11,27,71,0.10); }

  /* Wishlist button */
  .wishlist-btn { transition: color 0.2s, transform 0.2s; }
  .wishlist-btn:hover { transform: scale(1.2); }
  .wishlist-btn.in-wishlist i { color: #ef4444; }
  .wishlist-btn.in-wishlist i::before { content: "\f004"; font-weight: 900; }

  /* Sort dropdown */
  .sort-select { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%23666' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 10px center; padding-right:28px; }

  /* Pagination links */
  .pagination > * { display:inline-flex; }

  /* Mobile Filter Drawer Panel Styles */
  #mobile-filter-drawer.open {
    opacity: 1;
    pointer-events: auto;
  }
  #mobile-filter-drawer.open .filter-panel {
    transform: translateX(0);
  }
</style>

{{-- Breadcrumb --}}
<div class="max-w-[1200px] mx-auto px-4 pt-4 text-xs text-slate-500 flex items-center gap-2">
  <a href="{{ route('home') }}" class="hover:underline">Home</a>
  <i class="fa-solid fa-chevron-right text-[8px]"></i>
  <span class="text-navy font-medium">{{ $category->name }}</span>
  @if(request('subcategory'))
    <i class="fa-solid fa-chevron-right text-[8px]"></i>
    <span class="text-navy font-medium">{{ ucfirst(str_replace('-', ' ', request('subcategory'))) }}</span>
  @endif
</div>

{{-- Category Banner --}}
<section class="max-w-[1200px] mx-auto px-4 mt-4">
  <div class="rounded-2xl bg-gradient-to-r from-slate-50 via-indigo-50/40 to-indigo-100/70 border border-indigo-100/80 px-6 py-8 sm:px-10 sm:py-10 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden shadow-sm">
    {{-- Glowing background accents --}}
    <div class="absolute -top-10 -left-10 w-40 h-40 bg-blue-300 rounded-full blur-3xl opacity-25 pointer-events-none"></div>
    <div class="absolute -bottom-10 -right-10 w-52 h-52 bg-indigo-300 rounded-full blur-3xl opacity-35 pointer-events-none"></div>

    <div class="max-w-xl relative z-10">
      <span class="inline-block bg-indigo-100 text-indigo-800 text-[10px] font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-wider">Category</span>
      <h1 class="text-2xl sm:text-4xl font-extrabold text-[#0B1B47] leading-tight">
        {{ $category->name }}
        @if(request('subcategory'))
          <span class="text-indigo-600"> — {{ ucfirst(str_replace('-', ' ', request('subcategory'))) }}</span>
        @endif
      </h1>
      <p class="mt-3 text-slate-600 text-sm max-w-lg leading-relaxed">{{ $category->description ?? 'Explore high-quality essentials for students.' }}</p>
      
      <div class="mt-6 flex flex-wrap gap-3">
        <div class="bg-white/80 backdrop-blur-sm border border-slate-100 rounded-xl px-4 py-2.5 flex items-center gap-3 shadow-sm">
          <i class="fa-solid fa-circle-check text-indigo-600 text-sm"></i>
          <div>
            <div class="text-xs font-bold text-[#0B1B47]">Premium Quality</div>
            <div class="text-[10px] text-slate-500">100% Guaranteed</div>
          </div>
        </div>
        <div class="bg-white/80 backdrop-blur-sm border border-slate-100 rounded-xl px-4 py-2.5 flex items-center gap-3 shadow-sm">
          <i class="fa-solid fa-truck text-indigo-600 text-sm"></i>
          <div>
            <div class="text-xs font-bold text-[#0B1B47]">Fast Delivery</div>
            <div class="text-[10px] text-slate-500">Across Pakistan</div>
          </div>
        </div>
      </div>
    </div>

    <div class="relative shrink-0 z-10">
      @if($category->image)
        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="relative w-40 h-40 sm:w-48 sm:h-48 object-contain drop-shadow-md hover:scale-105 transition-transform duration-300">
      @else
        <div class="relative w-40 h-40 sm:w-48 sm:h-48 flex items-center justify-center text-7xl sm:text-8xl bg-white/60 backdrop-blur-sm rounded-2xl shadow-sm border border-white">
          @if($category->type === 'book') 📚
          @elseif($category->type === 'uniform') 👕
          @else 🎒
          @endif
        </div>
      @endif
    </div>
  </div>
</section>

{{-- Main Content: Sidebar + Products --}}
<main class="max-w-[1200px] mx-auto px-4 py-8 grid grid-cols-1 lg:grid-cols-12 gap-6 relative">

  @php
    $colors = [
      'navy'   => '#0B1B47',
      'black'  => '#1a1a1a',
      'red'    => '#e53e3e',
      'purple' => '#B95FB7',
      'pink'   => '#F4B6CB',
      'blue'   => '#2E63C8',
      'teal'   => '#1FA39A',
      'white'  => '#f5f5f5',
      'grey'   => '#9ca3af',
    ];
  @endphp

  {{-- ── DESKTOP SIDEBAR FILTERS ── --}}
  <aside class="hidden lg:block lg:col-span-3 bg-white rounded-xl p-5 h-fit border border-slate-200 shadow-sm sticky top-[100px] z-10">
    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
      <h3 class="font-bold text-navy">Filter By</h3>
      @if(request('subcategory') || request('color'))
        <a href="{{ route('category.show', $category->slug) }}" class="text-orange-500 text-xs font-semibold hover:underline">Clear All</a>
      @else
        <span class="text-slate-300 text-xs font-medium">Clear All</span>
      @endif
    </div>

    {{-- Subcategories --}}
    @if($subcategories->isNotEmpty())
    <div class="py-4 border-b border-slate-200">
      <div class="flex items-center justify-between mb-3 cursor-pointer" onclick="this.nextElementSibling.classList.toggle('hidden')">
        <h4 class="font-semibold text-navy text-sm">Subcategories</h4>
        <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform"></i>
      </div>
      <div class="space-y-2 text-sm max-h-52 overflow-y-auto pr-1">
        @foreach($subcategories as $sub)
          @php
            $isChecked = request('subcategory') === $sub->slug;
            $params = request()->except('subcategory', 'page');
            if (!$isChecked) $params['subcategory'] = $sub->slug;
            $link = route('category.show', $category->slug) . (count($params) ? '?' . http_build_query($params) : '');
          @endphp
          <label class="flex items-center gap-2 cursor-pointer hover:text-indigo-600 transition group">
            <input type="checkbox" class="checkbox cursor-pointer" {{ $isChecked ? 'checked' : '' }} onclick="window.location.href='{{ $link }}'">
            <span class="group-hover:font-medium transition">{{ $sub->name }}</span>
          </label>
        @endforeach
      </div>
    </div>
    @endif

    {{-- Price Range (static visual) --}}
    <div class="py-4 border-b border-slate-200">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-navy text-sm">Price Range</h4>
        <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
      </div>
      <div class="mt-2 px-2">
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

    {{-- Color Filter --}}
    <div class="py-4 border-b border-slate-200">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-navy text-sm">Color</h4>
        <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
      </div>
      <div class="flex flex-wrap gap-2 mt-1">
        @foreach($colors as $name => $hex)
          @php
            $isColorActive = request('color') === $name;
            $params = request()->except('color', 'page');
            if (!$isColorActive) $params['color'] = $name;
            $link = route('category.show', $category->slug) . (count($params) ? '?' . http_build_query($params) : '');
          @endphp
          <a href="{{ $link }}"
             class="swatch {{ $isColorActive ? 'active' : '' }} flex items-center justify-center"
             style="background:{{ $hex }};"
             title="{{ ucfirst($name) }}">
            @if($isColorActive)
              <i class="fa-solid fa-check text-[9px] {{ in_array($name, ['white']) ? 'text-gray-600' : 'text-white' }}"></i>
            @endif
          </a>
        @endforeach
      </div>
      @if(request('color'))
        <div class="mt-3 text-xs text-slate-500 flex items-center justify-between">
          <span>Color: <strong class="text-navy">{{ ucfirst(request('color')) }}</strong></span>
          <a href="{{ route('category.show', $category->slug) . (request('subcategory') ? '?subcategory=' . request('subcategory') : '') }}" class="text-orange-500 hover:underline">✕ Remove</a>
        </div>
      @endif
    </div>

    {{-- Material (static visual) --}}
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

    {{-- Features (static visual) --}}
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

  {{-- ── PRODUCT GRID ── --}}
  <section class="lg:col-span-9">

    {{-- Toolbar: count, mobile filter toggle + sort --}}
    <div class="bg-white rounded-xl border border-slate-200 p-4 mb-5 flex flex-wrap items-center justify-between gap-4 shadow-sm">
      <div class="flex items-center gap-3">
        {{-- Mobile Filter Toggle Button --}}
        <button id="open-filters" class="lg:hidden flex items-center gap-2 bg-[#0B1B47] hover:bg-indigo-700 text-white font-semibold px-4 py-2.5 rounded-xl text-xs transition shadow-sm">
          <i class="fa-solid fa-sliders text-xs"></i> Filters
        </button>
        <p class="text-xs sm:text-sm text-slate-600">
          @if($products->total() > 0)
            Showing <span class="font-semibold text-navy">{{ $products->firstItem() }}–{{ $products->lastItem() }}</span> of <span class="font-semibold text-navy">{{ $products->total() }}</span> products
          @else
            No products found
          @endif
        </p>
      </div>

      {{-- Sort By dropdown --}}
      <div class="flex items-center gap-2 text-xs sm:text-sm w-full sm:w-auto justify-between sm:justify-end">
        <span class="text-slate-500 shrink-0">Sort by:</span>
        <select id="sort-select" class="sort-select border border-slate-200 rounded-xl px-3 py-2 text-xs sm:text-sm bg-slate-50 text-navy font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-300 cursor-pointer">
          <option value="popular"    {{ $sort === 'popular'    ? 'selected' : '' }}>⭐ Popular</option>
          <option value="newest"     {{ $sort === 'newest'     ? 'selected' : '' }}>🆕 Newest First</option>
          <option value="price_asc"  {{ $sort === 'price_asc'  ? 'selected' : '' }}>💰 Price: Low → High</option>
          <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>💎 Price: High → Low</option>
        </select>
      </div>
    </div>

    @if($products->count() > 0)
      <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4" id="product-grid">
        @foreach($products as $p)
          @php
            $wishlist = session('wishlist', []);
            $inWishlist = in_array($p->id, $wishlist);
          @endphp
          <div class="product-card bg-white rounded-xl border border-slate-200 overflow-hidden flex flex-col justify-between">
            <div>
              <div class="relative bg-slate-50 aspect-square flex items-center justify-center">
                <a href="{{ route('product.show', $p) }}" class="w-full h-full flex items-center justify-center p-3">
                  @if(!empty($p->images) && count($p->images) > 0)
                    <img src="{{ asset('storage/' . $p->images[0]) }}"
                         alt="{{ $p->name }}"
                         class="w-full h-full object-contain transition duration-300 hover:scale-105">
                  @else
                    <div class="text-5xl text-gray-300 select-none">
                      @if($category->type === 'book') 📚
                      @elseif($category->type === 'uniform') 👕
                      @else 🎒
                      @endif
                    </div>
                  @endif
                </a>

                {{-- Wishlist Heart Button --}}
                <button
                  class="wishlist-btn absolute top-2 right-2 w-8 h-8 bg-white rounded-full shadow-md flex items-center justify-center text-slate-400 hover:text-red-500 {{ $inWishlist ? 'in-wishlist' : '' }}"
                  data-product-id="{{ $p->id }}"
                  data-wishlist-url="{{ route('wishlist.toggle', $p) }}"
                  title="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                  <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart text-xs {{ $inWishlist ? 'text-red-500' : '' }}"></i>
                </button>

                {{-- Discount badge --}}
                @if($p->discount_price && $p->discount_price < $p->price)
                  @php $pct = round((($p->price - $p->discount_price) / $p->price) * 100); @endphp
                  <span class="absolute top-2 left-2 bg-orange-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">-{{ $pct }}%</span>
                @endif
              </div>

              <div class="p-3">
                <h4 class="text-xs font-semibold text-navy line-clamp-2 min-h-[32px]">
                  <a href="{{ route('product.show', $p) }}" class="hover:text-indigo-600 transition">{{ $p->name }}</a>
                </h4>
                <div class="mt-1.5 flex items-baseline gap-1.5">
                  <span class="text-orange-500 font-bold text-sm">PKR {{ number_format($p->effectivePrice()) }}</span>
                  @if($p->discount_price && $p->discount_price < $p->price)
                    <span class="text-[11px] text-slate-400 line-through">PKR {{ number_format($p->price) }}</span>
                  @endif
                </div>
                {{-- Stock badge --}}
                <div class="mt-1">
                  @if($p->stock <= 0)
                    <span class="text-[10px] text-red-500 font-semibold">Out of Stock</span>
                  @elseif($p->stock <= 5)
                    <span class="text-[10px] text-orange-500 font-semibold">Only {{ $p->stock }} left</span>
                  @else
                    <span class="text-[10px] text-emerald-600 font-semibold">In Stock</span>
                  @endif
                </div>
              </div>
            </div>

            {{-- Add to Cart --}}
            <div class="p-3 pt-0">
              <form method="POST" action="{{ route('cart.addProduct', $p) }}">
                @csrf
                <button type="submit"
                  class="w-full flex items-center justify-center gap-1.5 text-xs font-semibold py-2 rounded-lg transition-all
                    {{ $p->stock > 0 ? 'bg-[#0B1B47] hover:bg-indigo-700 text-white cursor-pointer' : 'bg-slate-100 text-slate-400 cursor-not-allowed' }}"
                  {{ $p->stock <= 0 ? 'disabled' : '' }}>
                  <i class="fa-solid fa-cart-plus text-[11px]"></i>
                  {{ $p->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                </button>
              </form>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Pagination --}}
      @if ($products->hasPages())
        <div class="mt-8 flex justify-center">
          {{ $products->links() }}
        </div>
      @endif

    @else
      <div class="bg-white rounded-xl border border-slate-200 p-16 text-center">
        <div class="text-7xl mb-4">📦</div>
        <h3 class="text-lg font-bold text-navy mb-2">No Products Found</h3>
        <p class="text-slate-500 text-sm mb-5">No products match your current filters. Try adjusting your selection.</p>
        <a href="{{ route('category.show', $category->slug) }}" class="inline-flex items-center gap-2 bg-[#0B1B47] text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
          <i class="fa-solid fa-arrow-left text-xs"></i> Clear Filters
        </a>
      </div>
    @endif

  </section>
</main>

{{-- Mobile Filter Drawer (Drawer panel for mobile view only) --}}
<div id="mobile-filter-drawer" class="lg:hidden fixed inset-0 z-50 pointer-events-none transition-opacity duration-300 opacity-0">
  {{-- Backdrop overlay --}}
  <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm pointer-events-auto cursor-pointer filter-backdrop"></div>
  
  {{-- Panel --}}
  <div class="absolute inset-y-0 left-0 w-80 max-w-[85vw] bg-white p-5 shadow-2xl flex flex-col pointer-events-auto transform -translate-x-full transition-transform duration-300 ease-in-out filter-panel">
    {{-- Header --}}
    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
      <h3 class="font-bold text-[#0B1B47] text-base">Filter By</h3>
      <div class="flex items-center gap-3">
        @if(request('subcategory') || request('color'))
          <a href="{{ route('category.show', $category->slug) }}" class="text-orange-500 text-xs font-semibold hover:underline">Clear All</a>
        @endif
        <button class="close-filters text-slate-400 hover:text-navy text-lg p-1" aria-label="Close filters">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
    </div>

    {{-- Filters scrollable body --}}
    <div class="flex-1 overflow-y-auto py-4 space-y-5 pr-1 text-slate-800">
      
      {{-- Subcategories --}}
      @if($subcategories->isNotEmpty())
      <div class="py-2 border-b border-slate-100">
        <h4 class="font-semibold text-[#0B1B47] text-sm mb-3">Subcategories</h4>
        <div class="space-y-2 text-sm max-h-52 overflow-y-auto pr-1">
          @foreach($subcategories as $sub)
            @php
              $isChecked = request('subcategory') === $sub->slug;
              $params = request()->except('subcategory', 'page');
              if (!$isChecked) $params['subcategory'] = $sub->slug;
              $link = route('category.show', $category->slug) . (count($params) ? '?' . http_build_query($params) : '');
            @endphp
            <label class="flex items-center gap-2 cursor-pointer hover:text-indigo-600 transition group">
              <input type="checkbox" class="checkbox cursor-pointer" {{ $isChecked ? 'checked' : '' }} onclick="window.location.href='{{ $link }}'">
              <span class="group-hover:font-medium transition">{{ $sub->name }}</span>
            </label>
          @endforeach
        </div>
      </div>
      @endif

      {{-- Price Range (static visual) --}}
      <div class="py-2 border-b border-slate-100">
        <h4 class="font-semibold text-[#0B1B47] text-sm mb-3">Price Range</h4>
        <div class="mt-2 px-2">
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

      {{-- Color Filter --}}
      <div class="py-2 border-b border-slate-100">
        <h4 class="font-semibold text-[#0B1B47] text-sm mb-3">Color</h4>
        <div class="flex flex-wrap gap-2 mt-1">
          @foreach($colors as $name => $hex)
            @php
              $isColorActive = request('color') === $name;
              $params = request()->except('color', 'page');
              if (!$isColorActive) $params['color'] = $name;
              $link = route('category.show', $category->slug) . (count($params) ? '?' . http_build_query($params) : '');
            @endphp
            <a href="{{ $link }}"
               class="swatch {{ $isColorActive ? 'active' : '' }} flex items-center justify-center"
               style="background:{{ $hex }};"
               title="{{ ucfirst($name) }}">
              @if($isColorActive)
                <i class="fa-solid fa-check text-[9px] {{ in_array($name, ['white']) ? 'text-gray-600' : 'text-white' }}"></i>
              @endif
            </a>
          @endforeach
        </div>
        @if(request('color'))
          <div class="mt-3 text-xs text-slate-500 flex items-center justify-between">
            <span>Color: <strong class="text-navy">{{ ucfirst(request('color')) }}</strong></span>
            <a href="{{ route('category.show', $category->slug) . (request('subcategory') ? '?subcategory=' . request('subcategory') : '') }}" class="text-orange-500 hover:underline">✕ Remove</a>
          </div>
        @endif
      </div>

      {{-- Material (static visual) --}}
      <div class="py-2 border-b border-slate-100">
        <h4 class="font-semibold text-[#0B1B47] text-sm mb-3">Material</h4>
        <div class="space-y-2 text-sm">
          <label class="flex items-center gap-2"><input type="checkbox" class="checkbox"> Nylon</label>
          <label class="flex items-center gap-2"><input type="checkbox" class="checkbox"> Polyester</label>
          <label class="flex items-center gap-2"><input type="checkbox" class="checkbox"> Canvas</label>
          <label class="flex items-center gap-2"><input type="checkbox" class="checkbox"> PU Leather</label>
        </div>
      </div>

      {{-- Features (static visual) --}}
      <div class="py-2">
        <h4 class="font-semibold text-[#0B1B47] text-sm mb-3">Features</h4>
        <div class="space-y-2 text-sm">
          <label class="flex items-center gap-2"><input type="checkbox" class="checkbox"> Water Resistant</label>
          <label class="flex items-center gap-2"><input type="checkbox" class="checkbox"> Laptop Compartment</label>
          <label class="flex items-center gap-2"><input type="checkbox" class="checkbox"> Reflective Strips</label>
          <label class="flex items-center gap-2"><input type="checkbox" class="checkbox"> Lightweight</label>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Trust bar --}}
<section class="bg-gray-100 border-t border-slate-200 mt-6">
  <div class="max-w-[1200px] mx-auto px-4 py-5 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
    <div class="flex items-center gap-2"><i class="fa-solid fa-shield text-navy text-lg"></i><div><div class="font-semibold text-xs">100% Original</div><div class="text-[10px] text-slate-500">Products</div></div></div>
    <div class="flex items-center gap-2"><i class="fa-solid fa-circle-dollar-to-slot text-navy text-lg"></i><div><div class="font-semibold text-xs">Best Prices</div><div class="text-[10px] text-slate-500">Guaranteed</div></div></div>
    <div class="flex items-center gap-2"><i class="fa-solid fa-medal text-navy text-lg"></i><div><div class="font-semibold text-xs">Trusted by</div><div class="text-[10px] text-slate-500">Thousands</div></div></div>
    <div class="flex items-center gap-2"><i class="fa-solid fa-rotate-left text-navy text-lg"></i><div><div class="font-semibold text-xs">Easy Returns</div><div class="text-[10px] text-slate-500">Hassle-free policy</div></div></div>
    <div class="flex items-center gap-2"><i class="fa-solid fa-wallet text-navy text-lg"></i><div><div class="font-semibold text-xs">Secure Payments</div><div class="text-[10px] text-slate-500">Safe & encrypted</div></div></div>
    <div class="flex items-center gap-2"><i class="fa-solid fa-headset text-navy text-lg"></i><div><div class="font-semibold text-xs">24/7 Support</div><div class="text-[10px] text-slate-500">Always here</div></div></div>
  </div>
</section>

{{-- Wishlist AJAX + Sort JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

  // ── MOBILE FILTER DRAWER TOGGLE ──
  const openFiltersBtn = document.getElementById('open-filters');
  const mobileFilterDrawer = document.getElementById('mobile-filter-drawer');

  if (openFiltersBtn && mobileFilterDrawer) {
    const backdrop = mobileFilterDrawer.querySelector('.filter-backdrop');
    const closeBtns = mobileFilterDrawer.querySelectorAll('.close-filters');

    function toggleDrawer() {
      mobileFilterDrawer.classList.toggle('open');
      document.body.classList.toggle('overflow-hidden');
    }

    openFiltersBtn.addEventListener('click', toggleDrawer);
    if (backdrop) backdrop.addEventListener('click', toggleDrawer);
    closeBtns.forEach(btn => btn.addEventListener('click', toggleDrawer));
  }

  // ── SORT SELECT ──
  const sortSelect = document.getElementById('sort-select');
  if (sortSelect) {
    sortSelect.addEventListener('change', function () {
      const url = new URL(window.location.href);
      url.searchParams.set('sort', this.value);
      url.searchParams.delete('page'); // reset to page 1
      window.location.href = url.toString();
    });
  }

  // ── WISHLIST TOGGLE (AJAX) ──
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

  document.querySelectorAll('.wishlist-btn').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      const url = btn.dataset.wishlistUrl;
      const icon = btn.querySelector('i');

      fetch(url, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken || '{{ csrf_token() }}',
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
        }
      })
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          if (data.in_wishlist) {
            btn.classList.add('in-wishlist');
            icon.classList.remove('fa-regular');
            icon.classList.add('fa-solid', 'text-red-500');
            btn.title = 'Remove from Wishlist';
          } else {
            btn.classList.remove('in-wishlist');
            icon.classList.remove('fa-solid', 'text-red-500');
            icon.classList.add('fa-regular');
            btn.title = 'Add to Wishlist';
          }
          // Update wishlist count badge in header (if present)
          const badge = document.getElementById('wishlist-count');
          if (badge) {
            badge.textContent = data.count;
            badge.style.display = data.count > 0 ? '' : 'none';
          }
          // Animate
          btn.style.transform = 'scale(1.4)';
          setTimeout(() => { btn.style.transform = ''; }, 200);
        }
      })
      .catch(() => {
        // Fallback: redirect to toggle URL
        window.location.href = url;
      });
    });
  });

});
</script>

@endsection