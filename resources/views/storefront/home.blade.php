@extends('layouts.app')

@section('content')

<style>
/* ── Hero Swiper ─────────────────────────── */
.heroSwiper .swiper-pagination-bullet        { width:8px; height:8px; background:#fff; opacity:.5; }
.heroSwiper .swiper-pagination-bullet-active { background:#fbbf24; opacity:1; width:24px; border-radius:999px; }

/* ── Swiper nav arrows ───────────────────── */
.swiper-nav-btn {
    position:absolute; top:50%; z-index:20; transform:translateY(-50%);
    width:38px; height:38px; border-radius:50%; background:#fff; border:1px solid #e2e8f0;
    box-shadow:0 2px 8px rgba(0,0,0,.10); display:flex; align-items:center; justify-content:center;
    cursor:pointer; transition:background .15s, transform .15s;
}
.swiper-nav-btn:hover { background:#f1f5f9; transform:translateY(-50%) scale(1.08); }

/* ── Section headings ────────────────────── */
.sec-title { font-size:clamp(18px,3vw,22px); font-weight:800; color:#0f172a; line-height:1.2; }
.sec-sub   { font-size:13px; color:#64748b; margin-top:3px; }

/* ── Trust strip ─────────────────────────── */
.trust-item { display:flex; align-items:center; gap:10px; background:#fff;
    border-radius:12px; border:1px solid #e8ecf4; padding:14px 16px; }

/* ── Promo cards ─────────────────────────── */
.promo-card { border-radius:18px; overflow:hidden; position:relative; }

/* ── Category card ───────────────────────── */
.cat-card { border-radius:14px; background:#fff; border:1.5px solid #e8ecf4; overflow:hidden;
    transition:transform .2s, box-shadow .2s, border-color .2s; display:block; }
.cat-card:hover { transform:translateY(-4px); box-shadow:0 8px 24px rgba(15,23,42,.10); border-color:#6366f1; }

/* ── Product card ────────────────────────── */
.product-card { background:#fff; border-radius:14px; border:1px solid #e8ecf4; overflow:hidden;
    transition:transform .22s, box-shadow .22s; display:flex; flex-direction:column; }
.product-card:hover { transform:translateY(-4px); box-shadow:0 10px 32px rgba(15,23,42,.10); }
.product-img-wrap { position:relative; background:#f8fafc; aspect-ratio:1; overflow:hidden; }
.product-img-wrap img { width:100%; height:100%; object-fit:contain; padding:10px; transition:transform .3s; }
.product-card:hover .product-img-wrap img { transform:scale(1.06); }
.badge-discount { position:absolute; top:8px; left:8px; background:#ef4444; color:#fff; font-size:10px; font-weight:700; padding:2px 7px; border-radius:999px; z-index:5; }
.badge-new      { position:absolute; top:8px; left:8px; background:#6366f1; color:#fff; font-size:10px; font-weight:700; padding:2px 7px; border-radius:999px; z-index:5; }
.wish-btn { position:absolute; top:8px; right:8px; width:32px; height:32px; background:#fff; border-radius:50%;
    box-shadow:0 1px 6px rgba(0,0,0,.12); display:flex; align-items:center; justify-content:center;
    cursor:pointer; transition:color .18s, transform .18s; color:#94a3b8; border:none; z-index:5; }
.wish-btn:hover { color:#ef4444; transform:scale(1.15); }
.wish-btn.in-wishlist { color:#ef4444; }
.atc-btn { width:100%; display:flex; align-items:center; justify-content:center; gap:6px;
    font-size:12px; font-weight:700; padding:9px; border-radius:8px;
    background:#0f172a; color:#fff; border:none; cursor:pointer; transition:background .18s; }
.atc-btn:hover:not(:disabled) { background:#1e3a8a; }
.atc-btn:disabled { background:#e2e8f0; color:#94a3b8; cursor:not-allowed; }

/* ── School card ─────────────────────────── */
.school-card { background:#fff; border-radius:14px; border:1px solid #e8ecf4; padding:18px;
    display:flex; flex-direction:column; gap:10px; height:100%;
    transition:transform .2s, box-shadow .2s; }
.school-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(15,23,42,.09); }

/* ── CTA ─────────────────────────────────── */
.cta-wrap { background:linear-gradient(135deg,#1e3a8a 0%,#312e81 50%,#0f172a 100%); border-radius:20px; }

/* ── Product tabs ────────────────────────── */
.tab-btn { padding:8px 16px; border-radius:999px; font-size:13px; font-weight:600; border:1.5px solid #e2e8f0;
    background:#fff; color:#64748b; cursor:pointer; transition:all .18s; white-space:nowrap; }
.tab-btn.active { background:#0f172a; color:#fff; border-color:#0f172a; }
.tab-panel { display:none; }
.tab-panel.active { display:grid; }

/* ── School swiper bullets ───────────────── */
.school-pagination .swiper-pagination-bullet        { background:#cbd5e1; opacity:1; }
.school-pagination .swiper-pagination-bullet-active { background:#1e3a8a; width:20px; border-radius:999px; }
</style>

{{-- ════════ 1. HERO SLIDER ════════ --}}
<section class="max-w-7xl mx-auto px-3 sm:px-4 pt-4">
    @if($heroBanners->count() > 0)
        <div class="swiper heroSwiper rounded-2xl overflow-hidden shadow-xl">
            <div class="swiper-wrapper">
                @foreach($heroBanners as $banner)
                    <div class="swiper-slide relative">
                        @if($banner->link)<a href="{{ $banner->link }}" class="block w-full h-full">@endif
                        <img src="{{ str_starts_with($banner->image_path, 'http') ? $banner->image_path : asset('storage/'.$banner->image_path) }}"
                             alt="{{ $banner->title ?? 'Banner' }}"
                             class="w-full h-[190px] sm:h-[340px] md:h-[440px] lg:h-[500px] object-cover object-center brightness-90">
                        @if($banner->title)
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent flex flex-col justify-end p-6 sm:p-12 md:p-16 text-white text-left">
                                <span class="inline-block bg-yellow-400 text-blue-900 text-[10px] sm:text-xs font-bold px-2.5 py-1 rounded-full mb-2 w-fit">🎒 Featured Offer</span>
                                <h2 class="text-lg sm:text-3xl md:text-5xl font-extrabold mb-2 md:mb-4 drop-shadow-md leading-tight max-w-2xl">
                                    {{ $banner->title }}
                                </h2>
                                <div>
                                    <span class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-300 text-blue-900 font-bold px-4 py-2 rounded-xl text-[10px] sm:text-sm transition shadow-lg">
                                        Shop Now <i class="fa-solid fa-arrow-right"></i>
                                    </span>
                                </div>
                            </div>
                        @endif
                        @if($banner->link)</a>@endif
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination !bottom-4"></div>
        </div>
    @else
        <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-blue-900 via-indigo-800 to-blue-950 relative min-h-[200px] sm:min-h-[380px] flex items-center px-6 sm:px-14 py-10">
            <div class="absolute -right-4 top-0 h-full flex items-center text-[120px] sm:text-[180px] opacity-10 select-none">📚</div>
            <div class="relative z-10 max-w-lg">
                <span class="inline-block bg-yellow-400 text-blue-900 text-xs font-bold px-3 py-1 rounded-full mb-4">🎒 New School Season 2025</span>
                <h1 class="text-white text-2xl sm:text-4xl font-extrabold leading-tight mb-3">
                    Everything for<br>Your School Journey
                </h1>
                <p class="text-blue-200 text-sm sm:text-base mb-6">Books, Uniforms, Bags, Baby Wear &amp; Gifts — all in one place.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('schools.index') }}" class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-300 text-blue-900 font-bold px-5 py-2.5 rounded-xl text-sm transition shadow-lg">
                        <i class="fa-solid fa-school text-sm"></i> Shop by School
                    </a>
                    <a href="{{ route('category.show', 'books') }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition">
                        Browse Books
                    </a>
                </div>
            </div>
        </div>
    @endif
</section>

{{-- ════════ 2. TRUST STRIP ════════ --}}
<section class="max-w-7xl mx-auto px-3 sm:px-4 mt-4">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        @php $trusts = [
            ['fa-truck-fast',    'bg-blue-50 text-blue-600',    'Fast Delivery',    'Nationwide across Pakistan'],
            ['fa-shield-halved', 'bg-emerald-50 text-emerald-600','Authentic Products','100% original guarantee'],
            ['fa-lock',         'bg-indigo-50 text-indigo-600', 'Secure Payments',  'IBFT, Easypaisa & more'],
            ['fa-rotate-left',  'bg-orange-50 text-orange-500', 'Easy Returns',     'Hassle-free 7-day policy'],
        ]; @endphp
        @foreach($trusts as [$icon, $clr, $t, $s])
            <div class="trust-item">
                <div class="w-10 h-10 rounded-xl {{ $clr }} flex items-center justify-center flex-shrink-0 text-base">
                    <i class="fa-solid {{ $icon }}"></i>
                </div>
                <div class="min-w-0">
                    <p class="font-bold text-slate-800 text-sm leading-tight">{{ $t }}</p>
                    <p class="text-slate-500 text-[11px] mt-0.5 leading-tight hidden sm:block">{{ $s }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- ════════ 3. PROMO BANNERS ════════ --}}
<section class="max-w-7xl mx-auto px-3 sm:px-4 mt-5">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">

        {{-- Big promo --}}
        <div class="sm:col-span-2 promo-card bg-gradient-to-br from-amber-400 via-orange-400 to-orange-500 p-6 sm:p-10 flex flex-col justify-between min-h-[160px] sm:min-h-[210px]">
            <div class="absolute inset-0 flex items-center justify-end pr-6 sm:pr-10 text-[90px] sm:text-[130px] opacity-20 select-none">🎒</div>
            <div class="relative">
                <span class="inline-block bg-white/30 backdrop-blur text-white text-xs font-bold px-2.5 py-1 rounded-full mb-3">⚡ LIMITED OFFER</span>
                <h3 class="text-white font-extrabold text-xl sm:text-3xl leading-tight">School Season Sale!<br>
                    <span class="text-blue-900">Up to 30% OFF</span>
                </h3>
            </div>
            <a href="{{ route('category.show', 'books') }}" class="relative self-start inline-flex items-center gap-2 bg-blue-900 hover:bg-blue-800 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition mt-4">
                Shop Now <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        {{-- Side promos --}}
        <div class="grid grid-cols-2 sm:grid-cols-1 gap-3">
            <div class="promo-card bg-gradient-to-br from-blue-900 to-indigo-800 p-5 flex flex-col justify-between min-h-[95px]">
                <div class="absolute right-4 bottom-2 text-[60px] opacity-15 select-none">👶</div>
                <div class="relative">
                    <p class="text-blue-200 text-xs font-semibold">New Arrivals</p>
                    <h4 class="text-white font-extrabold text-base leading-tight mt-1">Baby Wear<br>Collection</h4>
                </div>
                <a href="{{ route('category.show', 'baby-wear') }}" class="relative text-yellow-400 text-xs font-bold inline-flex items-center gap-1 mt-3 hover:underline">
                    Shop <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
            <div class="promo-card bg-gradient-to-br from-rose-500 to-pink-600 p-5 flex flex-col justify-between min-h-[95px]">
                <div class="absolute right-4 bottom-2 text-[60px] opacity-15 select-none">🎁</div>
                <div class="relative">
                    <p class="text-rose-100 text-xs font-semibold">Trending</p>
                    <h4 class="text-white font-extrabold text-base leading-tight mt-1">Gift Ideas<br>for Everyone</h4>
                </div>
                <a href="{{ route('category.show', 'gifts') }}" class="relative text-white text-xs font-bold inline-flex items-center gap-1 mt-3 hover:underline">
                    Explore <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ════════ 4. CATEGORIES SLIDER ════════ --}}
@if($categories->count() > 0)
<section class="max-w-7xl mx-auto px-3 sm:px-4 mt-8">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="sec-title">🛍️ Shop by Category</h2>
            <p class="sec-sub">Browse our top collections</p>
        </div>
        <a href="{{ route('category.show', 'accessories') }}" class="text-sm font-semibold text-indigo-600 hover:underline flex items-center gap-1">
            All <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
    </div>
    <div class="relative">
        <button class="cat-prev swiper-nav-btn -left-3 sm:-left-5"><i class="fa-solid fa-chevron-left text-xs text-slate-600"></i></button>
        <div class="swiper categorySwiper overflow-hidden">
            <div class="swiper-wrapper">
                @foreach($categories as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" class="swiper-slide cat-card">
                        <div class="aspect-square overflow-hidden bg-slate-50">
                            @if($cat->image)
                                <img src="{{ asset('storage/'.$cat->image) }}" alt="{{ $cat->name }}"
                                     class="w-full h-full object-cover transition hover:scale-110 duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-5xl">🎒</div>
                            @endif
                        </div>
                        <div class="p-3 text-center">
                            <h3 class="font-bold text-slate-800 text-sm">{{ $cat->name }}</h3>
                            <span class="text-indigo-600 text-[11px] font-semibold mt-0.5 flex items-center justify-center gap-1">
                                Shop <i class="fa-solid fa-arrow-right text-[9px]"></i>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <button class="cat-next swiper-nav-btn -right-3 sm:-right-5"><i class="fa-solid fa-chevron-right text-xs text-slate-600"></i></button>
    </div>
</section>
@endif

{{-- ════════ 5. FEATURED PRODUCTS — TABBED ════════ --}}
<section class="max-w-7xl mx-auto px-3 sm:px-4 mt-10">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
        <div>
            <h2 class="sec-title">🔥 Featured Products</h2>
            <p class="sec-sub">Handpicked items for you</p>
        </div>
        <div class="flex items-center gap-2 overflow-x-auto pb-1 -mx-1 px-1">
            <button class="tab-btn active" data-tab="new">New Arrivals</button>
            <button class="tab-btn" data-tab="best">Best Sellers</button>
            @if($onSaleProducts->count() > 0)
                <button class="tab-btn" data-tab="sale">🏷️ On Sale</button>
            @endif
        </div>
    </div>

    {{-- Tab: New Arrivals --}}
    <div id="tab-new" class="tab-panel active grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 sm:gap-4">
        @forelse($featuredProducts as $p)
            @php $badge = 'new'; $hasDiscount = $p->discount_price && $p->discount_price < $p->price; $discountPct = $hasDiscount ? round((($p->price - $p->discount_price) / $p->price) * 100) : 0; $wishlist = session('wishlist',[]); $inWishlist = in_array($p->id, $wishlist); @endphp
            <div class="product-card">
                <div class="product-img-wrap">
                    <a href="{{ route('product.show', $p) }}">
                        @if(!empty($p->images) && count($p->images) > 0)
                            <img src="{{ asset('storage/'.$p->images[0]) }}" alt="{{ $p->name }}" loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-5xl text-slate-200">📦</div>
                        @endif
                    </a>
                    <span class="badge-new">NEW</span>
                    <button class="wish-btn {{ $inWishlist ? 'in-wishlist' : '' }}" data-url="{{ route('wishlist.toggle', $p) }}">
                        <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart text-sm"></i>
                    </button>
                </div>
                <div class="p-3 flex flex-col flex-1">
                    <h4 class="text-xs sm:text-sm font-semibold text-slate-800 line-clamp-2 min-h-[32px] leading-tight">
                        <a href="{{ route('product.show', $p) }}" class="hover:text-indigo-600 transition">{{ $p->name }}</a>
                    </h4>
                    <div class="mt-1.5 flex items-baseline gap-1.5">
                        <span class="text-orange-500 font-extrabold text-sm">PKR {{ number_format($p->effectivePrice()) }}</span>
                        @if($hasDiscount)<span class="text-[11px] text-slate-400 line-through">PKR {{ number_format($p->price) }}</span>@endif
                    </div>
                    <p class="mt-0.5 text-[10px] {{ $p->stock <= 0 ? 'text-red-500' : ($p->stock <= 5 ? 'text-orange-500' : 'text-emerald-600') }} font-semibold">
                        {{ $p->stock <= 0 ? 'Out of Stock' : ($p->stock <= 5 ? 'Only '.$p->stock.' left!' : '✓ In Stock') }}
                    </p>
                    <div class="mt-auto pt-2">
                        <form method="POST" action="{{ route('cart.addProduct', $p) }}">@csrf
                            <button class="atc-btn" {{ $p->stock <= 0 ? 'disabled' : '' }}>
                                <i class="fa-solid fa-cart-plus text-xs"></i> {{ $p->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 py-16 text-center text-slate-400">
                <i class="fa-solid fa-box-open text-5xl mb-3 block text-slate-200"></i>No products yet.
            </div>
        @endforelse
    </div>

    {{-- Tab: Best Sellers --}}
    <div id="tab-best" class="tab-panel grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 sm:gap-4">
        @forelse($bestSellers as $p)
            @php $badge = ''; $hasDiscount = $p->discount_price && $p->discount_price < $p->price; $discountPct = $hasDiscount ? round((($p->price - $p->discount_price) / $p->price) * 100) : 0; $wishlist = session('wishlist',[]); $inWishlist = in_array($p->id, $wishlist); @endphp
            <div class="product-card">
                <div class="product-img-wrap">
                    <a href="{{ route('product.show', $p) }}">
                        @if(!empty($p->images) && count($p->images) > 0)
                            <img src="{{ asset('storage/'.$p->images[0]) }}" alt="{{ $p->name }}" loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-5xl text-slate-200">📦</div>
                        @endif
                    </a>
                    @if($hasDiscount)<span class="badge-discount">-{{ $discountPct }}%</span>@endif
                    <button class="wish-btn {{ $inWishlist ? 'in-wishlist' : '' }}" data-url="{{ route('wishlist.toggle', $p) }}">
                        <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart text-sm"></i>
                    </button>
                </div>
                <div class="p-3 flex flex-col flex-1">
                    <h4 class="text-xs sm:text-sm font-semibold text-slate-800 line-clamp-2 min-h-[32px] leading-tight">
                        <a href="{{ route('product.show', $p) }}" class="hover:text-indigo-600 transition">{{ $p->name }}</a>
                    </h4>
                    <div class="mt-1.5 flex items-baseline gap-1.5">
                        <span class="text-orange-500 font-extrabold text-sm">PKR {{ number_format($p->effectivePrice()) }}</span>
                        @if($hasDiscount)<span class="text-[11px] text-slate-400 line-through">PKR {{ number_format($p->price) }}</span>@endif
                    </div>
                    <p class="mt-0.5 text-[10px] {{ $p->stock <= 0 ? 'text-red-500' : ($p->stock <= 5 ? 'text-orange-500' : 'text-emerald-600') }} font-semibold">
                        {{ $p->stock <= 0 ? 'Out of Stock' : ($p->stock <= 5 ? 'Only '.$p->stock.' left!' : '✓ In Stock') }}
                    </p>
                    <div class="mt-auto pt-2">
                        <form method="POST" action="{{ route('cart.addProduct', $p) }}">@csrf
                            <button class="atc-btn" {{ $p->stock <= 0 ? 'disabled' : '' }}>
                                <i class="fa-solid fa-cart-plus text-xs"></i> {{ $p->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 py-16 text-center text-slate-400">No products yet.</div>
        @endforelse
    </div>

    {{-- Tab: On Sale --}}
    @if($onSaleProducts->count() > 0)
    <div id="tab-sale" class="tab-panel grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 sm:gap-4">
        @foreach($onSaleProducts as $p)
            @php $hasDiscount = true; $discountPct = round((($p->price - $p->discount_price) / $p->price) * 100); $wishlist = session('wishlist',[]); $inWishlist = in_array($p->id, $wishlist); @endphp
            <div class="product-card">
                <div class="product-img-wrap">
                    <a href="{{ route('product.show', $p) }}">
                        @if(!empty($p->images) && count($p->images) > 0)
                            <img src="{{ asset('storage/'.$p->images[0]) }}" alt="{{ $p->name }}" loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-5xl text-slate-200">📦</div>
                        @endif
                    </a>
                    <span class="badge-discount">-{{ $discountPct }}%</span>
                    <button class="wish-btn {{ $inWishlist ? 'in-wishlist' : '' }}" data-url="{{ route('wishlist.toggle', $p) }}">
                        <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart text-sm"></i>
                    </button>
                </div>
                <div class="p-3 flex flex-col flex-1">
                    <h4 class="text-xs sm:text-sm font-semibold text-slate-800 line-clamp-2 min-h-[32px] leading-tight">
                        <a href="{{ route('product.show', $p) }}" class="hover:text-indigo-600 transition">{{ $p->name }}</a>
                    </h4>
                    <div class="mt-1.5 flex items-baseline gap-1.5">
                        <span class="text-orange-500 font-extrabold text-sm">PKR {{ number_format($p->effectivePrice()) }}</span>
                        <span class="text-[11px] text-slate-400 line-through">PKR {{ number_format($p->price) }}</span>
                    </div>
                    <p class="mt-0.5 text-[10px] {{ $p->stock <= 0 ? 'text-red-500' : ($p->stock <= 5 ? 'text-orange-500' : 'text-emerald-600') }} font-semibold">
                        {{ $p->stock <= 0 ? 'Out of Stock' : ($p->stock <= 5 ? 'Only '.$p->stock.' left!' : '✓ In Stock') }}
                    </p>
                    <div class="mt-auto pt-2">
                        <form method="POST" action="{{ route('cart.addProduct', $p) }}">@csrf
                            <button class="atc-btn" {{ $p->stock <= 0 ? 'disabled' : '' }}>
                                <i class="fa-solid fa-cart-plus text-xs"></i> {{ $p->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif
</section>

{{-- ════════ 6. SCHOOLS SLIDER ════════ --}}
@if($schools->count() > 0)
<section class="max-w-7xl mx-auto px-3 sm:px-4 mt-10">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="sec-title">🏫 Popular Schools</h2>
            <p class="sec-sub">Shop class-wise bundles by school</p>
        </div>
        <a href="{{ route('schools.index') }}" class="text-sm font-semibold text-indigo-600 hover:underline flex items-center gap-1">
            All Schools <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
    </div>
    <div class="relative">
        <button class="school-prev swiper-nav-btn -left-3 sm:-left-5"><i class="fa-solid fa-chevron-left text-xs text-slate-600"></i></button>
        <div class="swiper schoolSwiper overflow-hidden">
            <div class="swiper-wrapper pb-2">
                @foreach($schools as $school)
                    <div class="swiper-slide h-auto">
                        <a href="{{ route('schools.show', $school) }}" class="school-card block">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-indigo-50 flex items-center justify-center text-2xl sm:text-3xl flex-shrink-0">🏫</div>
                                <div class="min-w-0">
                                    <h3 class="font-bold text-slate-800 text-sm leading-tight truncate">{{ $school->name }}</h3>
                                    <p class="text-slate-400 text-xs mt-0.5">Books &amp; Uniforms Available</p>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-slate-100">
                                <span class="inline-flex items-center justify-center gap-2 w-full bg-blue-900 hover:bg-blue-800 text-white text-sm font-semibold py-2.5 rounded-xl transition">
                                    View Classes <i class="fa-solid fa-arrow-right text-xs"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="school-pagination swiper-pagination !relative !bottom-0 !mt-4"></div>
        </div>
        <button class="school-next swiper-nav-btn -right-3 sm:-right-5"><i class="fa-solid fa-chevron-right text-xs text-slate-600"></i></button>
    </div>
</section>
@endif

{{-- ════════ 7. CTA BANNER ════════ --}}
<section class="max-w-7xl mx-auto px-3 sm:px-4 mt-10">
    <div class="cta-wrap px-6 sm:px-14 py-10 sm:py-14 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background:radial-gradient(circle at 20% 50%, #6366f1, transparent 60%)"></div>
        <div class="absolute right-6 top-0 h-full flex items-center text-[120px] opacity-10 select-none hidden sm:flex">📚</div>
        <div class="relative text-center md:text-left max-w-lg">
            <span class="inline-block bg-yellow-400/20 text-yellow-400 text-xs font-bold px-3 py-1 rounded-full mb-3">📚 School Season Ready</span>
            <h2 class="text-white font-extrabold text-2xl sm:text-3xl leading-tight">Get Your Complete School Bundle Today!</h2>
            <p class="text-slate-300 text-sm mt-3">Select your school, pick your class — all books &amp; uniforms in one order.</p>
        </div>
        <div class="relative flex flex-col sm:flex-row gap-3 flex-shrink-0">
            <a href="{{ route('schools.index') }}" class="inline-flex items-center justify-center gap-2 bg-yellow-400 hover:bg-yellow-300 text-blue-900 font-extrabold px-7 py-3.5 rounded-xl text-sm transition shadow-xl">
                <i class="fa-solid fa-school"></i> Shop by School
            </a>
            <a href="{{ route('category.show', 'books') }}" class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold px-7 py-3.5 rounded-xl text-sm transition">
                Browse Books
            </a>
        </div>
    </div>
</section>

{{-- ════════ 8. WHY CHOOSE US ════════ --}}
<section class="max-w-7xl mx-auto px-3 sm:px-4 mt-10">
    <div class="text-center mb-6">
        <h2 class="sec-title">Why Choose Bookish &amp; Beyond?</h2>
        <p class="sec-sub mt-1">Trusted by thousands of families across Pakistan</p>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
        @php $whyUs = [
            ['fa-circle-check', 'text-emerald-500', '100% Original',     'Authentic products'],
            ['fa-truck-fast',   'text-blue-500',    'Fast Delivery',     'Across Pakistan'],
            ['fa-medal',        'text-amber-500',   'Best Prices',       'Guaranteed'],
            ['fa-headset',      'text-indigo-500',  '24/7 Support',      'Always here'],
            ['fa-rotate-left',  'text-rose-500',    'Easy Returns',      '7-day policy'],
            ['fa-lock',         'text-purple-500',  'Secure Payment',    'IBFT & Digital'],
        ]; @endphp
        @foreach($whyUs as [$icon, $clr, $t, $s])
            <div class="bg-white rounded-2xl border border-slate-200 p-4 text-center hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                <div class="text-2xl {{ $clr }} mb-2"><i class="fa-solid {{ $icon }}"></i></div>
                <p class="font-bold text-slate-800 text-xs sm:text-sm">{{ $t }}</p>
                <p class="text-slate-400 text-[11px] mt-0.5">{{ $s }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- ════════ 9. TESTIMONIALS ════════ --}}
<section class="max-w-7xl mx-auto px-3 sm:px-4 mt-10 mb-8">
    <div class="text-center mb-6">
        <h2 class="sec-title">⭐ What Our Customers Say</h2>
        <p class="sec-sub mt-1">Real reviews from real parents &amp; students</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @php $reviews = [
            ['Ayesha K.',      'Lahore',     5, 'Amazing quality books! My child got everything for school in one order. Super fast delivery too.'],
            ['Muhammad A.',    'Karachi',    5, 'The school bundle saved me so much time. All books were correct and in perfect condition.'],
            ['Sana R.',        'Islamabad',  5, 'Great prices and genuine products. The baby wear section has beautiful designs. Highly recommend!'],
        ]; @endphp
        @foreach($reviews as [$name, $city, $stars, $text])
            <div class="bg-white rounded-2xl border border-slate-100 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-0.5 mb-3">
                    @for($i=0;$i<$stars;$i++)<i class="fa-solid fa-star text-amber-400 text-sm"></i>@endfor
                </div>
                <p class="text-slate-600 text-sm leading-relaxed">"{{ $text }}"</p>
                <div class="flex items-center gap-3 mt-4 pt-4 border-t border-slate-100">
                    <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-extrabold text-sm flex-shrink-0">{{ substr($name,0,1) }}</div>
                    <div>
                        <p class="font-bold text-slate-800 text-sm">{{ $name }}</p>
                        <p class="text-slate-400 text-xs">{{ $city }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- ════════ SCRIPTS ════════ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Hero Swiper
    new Swiper('.heroSwiper', {
        loop: true,
        autoplay: { delay: 3800, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
        effect: 'fade',
        fadeEffect: { crossFade: true },
    });

    // Category Swiper
    new Swiper('.categorySwiper', {
        slidesPerView: 2.4, spaceBetween: 12, grabCursor: true,
        navigation: { nextEl: '.cat-next', prevEl: '.cat-prev' },
        breakpoints: {
            480:  { slidesPerView: 3.2, spaceBetween: 14 },
            640:  { slidesPerView: 4,   spaceBetween: 16 },
            1024: { slidesPerView: 6,   spaceBetween: 20 },
        },
    });

    // Schools Swiper
    new Swiper('.schoolSwiper', {
        slidesPerView: 1, spaceBetween: 16, grabCursor: true,
        navigation: { nextEl: '.school-next', prevEl: '.school-prev' },
        pagination: { el: '.school-pagination', clickable: true },
        breakpoints: {
            540:  { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
    });

    // Product Tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            const panel = document.getElementById('tab-' + btn.dataset.tab);
            if (panel) panel.classList.add('active');
        });
    });

    // Wishlist AJAX
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    document.querySelectorAll('.wish-btn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            fetch(btn.dataset.url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            }).then(r => r.json()).then(data => {
                if (!data.success) return;
                const icon = btn.querySelector('i');
                if (data.in_wishlist) {
                    btn.classList.add('in-wishlist');
                    icon.className = 'fa-solid fa-heart text-sm';
                } else {
                    btn.classList.remove('in-wishlist');
                    icon.className = 'fa-regular fa-heart text-sm';
                }
                const badge = document.getElementById('wishlist-count');
                if (badge) { badge.textContent = data.count; badge.classList.toggle('hidden', data.count === 0); }
                btn.style.transform = 'scale(1.4)';
                setTimeout(() => btn.style.transform = '', 220);
            }).catch(() => {});
        });
    });

});
</script>

@endsection
