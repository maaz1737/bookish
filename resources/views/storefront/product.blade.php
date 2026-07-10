@extends('layouts.app')

@section('title', $product->name . ' - Bookish & Beyond')
@section('meta_description', Str::limit(strip_tags($product->description ?? ''), 155))

@section('content')
    {{-- JSON-LD product schema (no publisher exposed) --}}
    <script type="application/ld+json">{!! json_encode($jsonLd) !!}</script>

    @php
        /* ---------- Pricing ---------- */
        $hasDiscount = $product->discount_price && $product->price > $product->discount_price;
        $discountPct = $hasDiscount ? round((($product->price - $product->discount_price) / $product->price) * 100) : 0;
        $effectivePrice = $product->effectivePrice();

        /* ---------- Images ---------- */
        $images = collect($product->images ?? [])
            ->filter()
            ->values();
        $mainImage = $images->isNotEmpty() ? asset('storage/' . $images[0]) : $product->imageUrl();

        /* ---------- Wishlist ---------- */
        $inWishlist = false;
        if (auth()->check()) {
            $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->exists();
        } else {
            $inWishlist = \App\Models\Wishlist::where('session_id', session()->getId())
                ->where('product_id', $product->id)
                ->exists();
        }

        /* ---------- Stock Status ---------- */
        $inStock = $product->stock > 0;
        $isLow = $inStock && $product->isLowStock();
    @endphp

    {{-- ===== BREADCRUMB ===== --}}
    <nav class="text-xs text-slate-500 mb-6 flex items-center gap-2 flex-wrap" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-[#001F54] transition-colors">Home</a>
        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
        @if ($product->category)
            <a href="{{ route('category.show', $product->category->slug) }}" class="hover:text-[#001F54] transition-colors">
                {{ $product->category->name }}
            </a>
            <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
        @endif
        <span class="text-[#001F54] font-semibold">{{ $product->name }}</span>
    </nav>

    {{-- ===== MAIN PRODUCT CARD ===== --}}
    <div class="bg-white border border-slate-100 rounded-[24px] shadow-sm overflow-hidden mb-8">
        <div class="grid md:grid-cols-2 gap-0">

            {{-- ===== LEFT: Image Gallery ===== --}}
            <div class="relative bg-slate-50 flex flex-col border-b md:border-b-0 md:border-r border-slate-100">

                {{-- Discount Badge --}}
                @if ($hasDiscount)
                    <span
                        class="absolute top-5 left-5 z-10 bg-[#ff7a00] text-white text-xs font-bold px-3 py-1.5 rounded-full shadow">
                        Save {{ $discountPct }}%
                    </span>
                @elseif ($product->is_best_seller)
                    <span
                        class="absolute top-5 left-5 z-10 bg-[#001F54] text-white text-xs font-bold px-3 py-1.5 rounded-full shadow">
                        Best Seller
                    </span>
                @endif

                {{-- Zoom / Magnify Icon --}}
                {{-- <button id="zoom-btn" aria-label="Zoom image"
                    class="absolute top-5 right-5 z-10 w-9 h-9 bg-white rounded-full shadow flex items-center justify-center text-slate-500 hover:text-[#001F54] transition-colors">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </button> --}}

                {{-- Lightbox Modal --}}
                <div id="lightbox-modal"
                    class="fixed inset-0 z-[999] bg-black/80 backdrop-blur-sm flex items-center justify-center hidden"
                    onclick="closeLightbox()">
                    <div class="relative max-w-3xl w-full mx-4" onclick="event.stopPropagation()">
                        <button onclick="closeLightbox()"
                            class="absolute -top-10 right-0 text-white/80 hover:text-white text-2xl font-bold transition-colors">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                        <img id="lightbox-img" src="" alt="Zoomed product image"
                            class="w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl">
                    </div>
                </div>

                {{-- Main Image — object-contain so nothing is cut --}}
                <div class="flex items-start justify-center min-h-[100%]">
                    <img id="main-product-image" src="{{ $mainImage }}" alt="{{ $product->name }}"
                        class="max-h-[100%] w-full object-contain transition-all duration-300 drop-shadow-sm">
                </div>

                {{-- Thumbnail Strip (only if multiple images) --}}
                @if ($images->count() > 1)
                    <div class="flex items-center gap-3 mt-6 overflow-x-auto pb-1">
                        @foreach ($images as $i => $img)
                            <button onclick="switchImage('{{ asset('storage/' . $img) }}', this)"
                                class="thumbnail-btn shrink-0 w-16 h-16 rounded-xl border-2 overflow-hidden transition-all duration-200 {{ $i === 0 ? 'border-[#001F54]' : 'border-slate-200 hover:border-[#001F54]/50' }}"
                                aria-label="View image {{ $i + 1 }}">
                                <img src="{{ asset('storage/' . $img) }}" alt="Thumbnail {{ $i + 1 }}"
                                    class="w-full h-full object-contain">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- ===== RIGHT: Product Info ===== --}}
            <div class="flex flex-col justify-center p-6 md:p-10">

                {{-- Category label --}}
                <span class="text-xs font-bold tracking-widest text-[#ff7a00] uppercase mb-3">
                    {{ $product->category?->name ?? '' }}
                </span>

                {{-- Product Name --}}
                <h1 class="text-3xl md:text-3xl font-extrabold text-[#001F54] leading-tight mb-3">
                    {{ $product->name }}
                </h1>

                {{-- Star Rating (static 5-star display) --}}
                <div class="flex items-center gap-2 mb-5">
                    <div class="flex text-[#ff7a00]">
                        @for ($s = 0; $s < 5; $s++)
                            <i class="fa-solid fa-star text-sm"></i>
                        @endfor
                    </div>
                    <span class="text-xs text-slate-400 font-medium">(12 Reviews)</span>
                </div>

                {{-- Pricing --}}
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-3xl font-black text-[#001F54]">PKR {{ number_format($effectivePrice) }}</span>
                    @if ($hasDiscount)
                        <span class="text-base text-slate-400 line-through">PKR {{ number_format($product->price) }}</span>
                        <span class="bg-[#ff7a00] text-white text-xs font-bold px-2.5 py-1 rounded-full">Save
                            {{ $discountPct }}%</span>
                    @endif
                    @if ($inStock)
                        @if ($isLow)
                            <span
                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600 bg-amber-50 border border-amber-200 px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span>
                                Low Stock — only {{ $product->stock }} left
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                In Stock
                            </span>
                        @endif
                    @else
                        <span
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-600 bg-rose-50 border border-rose-200 px-3 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 inline-block"></span>
                            Out of Stock
                        </span>
                    @endif
                </div>

                {{-- Stock Status --}}
                {{-- <div class="mb-5">
                    @if ($inStock)
                        @if ($isLow)
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600 bg-amber-50 border border-amber-200 px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span>
                                Low Stock — only {{ $product->stock }} left
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                In Stock
                            </span>
                        @endif
                    @else
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-600 bg-rose-50 border border-rose-200 px-3 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 inline-block"></span>
                            Out of Stock
                        </span>
                    @endif
                </div> --}}

                {{-- Description --}}
                @if ($product->description)
                    <p class="text-slate-600 text-sm leading-relaxed mb-6">
                        {{ $product->description }}
                    </p>
                @endif

                {{-- Size / Gender meta --}}
                @if ($product->size || $product->gender)
                    <div class="flex flex-wrap gap-3 mb-6">
                        @if ($product->size)
                            <span class="text-xs bg-slate-100 text-slate-600 font-medium px-3 py-1.5 rounded-full">
                                Size: {{ $product->size }}
                            </span>
                        @endif
                        @if ($product->gender)
                            <span class="text-xs bg-slate-100 text-slate-600 font-medium px-3 py-1.5 rounded-full">
                                {{ ucfirst($product->gender) }}
                            </span>
                        @endif
                    </div>
                @endif

                {{-- Add to Cart Form --}}

                 <div class="flex gap-8">
       {{-- Quantity --}}
                <div class="flex items-center gap-4 mb-5">
                    <span class="text-sm font-semibold text-[#001F54]">Quantity:</span>
                    <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden">
                        <button type="button" id="qty-minus"
                            class="w-10 h-10 flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors text-lg font-bold">
                            −
                        </button>
                        <input type="number" name="quantity" id="qty-input" value="1" min="1"
                            max="{{ $product->stock }}"
                            class="w-14 h-10 text-center text-sm font-bold text-[#001F54] border-0 border-x border-slate-200 focus:outline-none focus:ring-0 bg-white">
                        <button type="button" id="qty-plus"
                            class="w-10 h-10 flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors text-lg font-bold">
                            +
                        </button>
                    </div>
                </div>
                @if ($inStock)
                    <form method="POST" action="{{ route('cart.addProduct', $product) }}" id="add-to-cart-form"
                        class=" cart-form">
                        @csrf
                        {{-- Add to Cart Button --}}
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-[#001F54] py-3 hover:bg-[#000c3a] px-16 text-white font-bold  rounded-[14px] transition-all duration-200 shadow-sm hover:shadow-md text-sm mb-3 h-10">
                            <i class="fa-solid fa-cart-shopping"></i>
                            Add to Cart
                        </button>
                    </form>
                @else
                    <button disabled
                        class="w-full flex items-center justify-center gap-2 bg-slate-200 text-slate-400 font-bold px-8 py-4 rounded-[14px] cursor-not-allowed text-sm mb-3">
                        <i class="fa-solid fa-ban"></i>
                        Out of Stock
                    </button>
                @endif
                 </div>
         

                {{-- Secondary Actions: Wishlist + Share --}}
                <div class="grid grid-cols-2 gap-3 mt-1">
                    {{-- Wishlist Toggle — uses global .wishlist-toggle-btn handler in app.blade.php --}}
                    <button id="wishlist-btn" data-product-id="{{ $product->id }}"
                        data-url="{{ route('wishlist.toggle', $product) }}"
                        class="wishlist-toggle-btn wishlist-detail-extra flex items-center justify-center gap-2 border-2 {{ $inWishlist ? 'border-rose-400 text-rose-500 bg-rose-50' : 'border-slate-200 text-slate-600' }} hover:border-rose-400 hover:text-rose-500 hover:bg-rose-50 font-semibold px-4 py-3 rounded-[14px] transition-all duration-200 text-sm">
                        <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart text-sm"></i>
                        <span class="wishlist-label">{{ $inWishlist ? 'Wishlisted' : 'Add to Wishlist' }}</span>
                    </button>

                    {{-- Share Button --}}
                    <button onclick="shareProduct()"
                        class="flex items-center justify-center gap-2 border-2 border-slate-200 text-slate-600 hover:border-[#001F54]/40 hover:text-[#001F54] hover:bg-slate-50 font-semibold px-4 py-3 rounded-[14px] transition-all duration-200 text-sm">
                        <i class="fa-solid fa-share-nodes text-sm"></i>
                        <span>Share</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- ===== DESCRIPTION SECTION ===== --}}
    @if ($product->description)
        <div class="bg-white border border-slate-100 rounded-[24px] shadow-sm p-8 mb-8">
            <h2 class="text-xl font-extrabold text-[#001F54] mb-4 flex items-center gap-2">
                <span class="w-1 h-6 bg-[#ff7a00] rounded-full inline-block"></span>
                Description
            </h2>
            <p class="text-slate-600 leading-relaxed text-sm">{{ $product->description }}</p>
        </div>
    @endif

    {{-- ===== TRUST BADGES ===== --}}
    <div class="bg-white border border-slate-100 rounded-[24px] shadow-sm p-6 md:p-8 mb-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 shrink-0 flex items-center justify-center rounded-xl bg-[#001F54]/5 text-[#001F54]">
                    <i class="fa-solid fa-truck-fast text-base"></i>
                </div>
                <div>
                    <div class="text-sm font-bold text-[#001F54]">Fast Delivery</div>
                    <div class="text-xs text-slate-500 mt-0.5">Quick delivery across Pakistan.</div>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 shrink-0 flex items-center justify-center rounded-xl bg-[#001F54]/5 text-[#001F54]">
                    <i class="fa-solid fa-shield-halved text-base"></i>
                </div>
                <div>
                    <div class="text-sm font-bold text-[#001F54]">100% Original Products</div>
                    <div class="text-xs text-slate-500 mt-0.5">We only sell original and high quality products.</div>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 shrink-0 flex items-center justify-center rounded-xl bg-[#001F54]/5 text-[#001F54]">
                    <i class="fa-solid fa-rotate-left text-base"></i>
                </div>
                <div>
                    <div class="text-sm font-bold text-[#001F54]">Easy Returns</div>
                    <div class="text-xs text-slate-500 mt-0.5">7 days return policy for unused items.</div>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 shrink-0 flex items-center justify-center rounded-xl bg-[#001F54]/5 text-[#001F54]">
                    <i class="fa-solid fa-lock text-base"></i>
                </div>
                <div>
                    <div class="text-sm font-bold text-[#001F54]">Secure Payments</div>
                    <div class="text-xs text-slate-500 mt-0.5">Safe and secure payment options.</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== JAVASCRIPT ===== --}}
    <script>
        /* ----- Image thumbnail switcher ----- */
        function switchImage(src, btn) {
            const mainImg = document.getElementById('main-product-image');
            mainImg.src = src;
            document.querySelectorAll('.thumbnail-btn').forEach(b => {
                b.classList.remove('border-[#001F54]');
                b.classList.add('border-slate-200');
            });
            btn.classList.remove('border-slate-200');
            btn.classList.add('border-[#001F54]');
        }

        /* ----- Zoom / Lightbox ----- */
        function openLightbox() {
            const src = document.getElementById('main-product-image').src;
            document.getElementById('lightbox-img').src = src;
            const modal = document.getElementById('lightbox-modal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeLightbox();
        });
        document.getElementById('zoom-btn')?.addEventListener('click', openLightbox);
        /* Also allow clicking main image to zoom */
        document.getElementById('main-product-image')?.addEventListener('click', openLightbox);
        document.getElementById('main-product-image')?.classList.add('cursor-zoom-in');

        /* ----- Quantity stepper ----- */
        const qtyInput = document.getElementById('qty-input');
        document.getElementById('qty-minus')?.addEventListener('click', () => {
            if (qtyInput && parseInt(qtyInput.value) > 1) qtyInput.value = parseInt(qtyInput.value) - 1;
        });
        document.getElementById('qty-plus')?.addEventListener('click', () => {
            if (qtyInput) {
                const max = parseInt(qtyInput.max) || 9999;
                if (parseInt(qtyInput.value) < max) qtyInput.value = parseInt(qtyInput.value) + 1;
            }
        });

        /* ----- Wishlist label sync (piggybacks on global .wishlist-toggle-btn handler) ----- */
        /* The global jQuery handler in app.blade.php handles the AJAX call.
           We just need to also update the label text & border classes on the detail button. */
        $(document).on('click', '#wishlist-btn', function() {
            /* After a short delay the global handler will have updated the icon.
               We update the label & border classes here. */
            setTimeout(() => {
                const btn = document.getElementById('wishlist-btn');
                if (!btn) return;
                const icon = btn.querySelector('i');
                const label = btn.querySelector('.wishlist-label');
                const added = icon && icon.classList.contains('fa-solid');
                if (label) label.textContent = added ? 'Wishlisted' : 'Add to Wishlist';
                if (added) {
                    btn.classList.add('border-rose-400', 'text-rose-500', 'bg-rose-50');
                    btn.classList.remove('border-slate-200', 'text-slate-600');
                } else {
                    btn.classList.remove('border-rose-400', 'text-rose-500', 'bg-rose-50');
                    btn.classList.add('border-slate-200', 'text-slate-600');
                }
            }, 400);
        });

        /* ----- Share ----- */
        function shareProduct() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ addslashes($product->name) }}',
                    url: window.location.href,
                });
            } else {
                navigator.clipboard?.writeText(window.location.href).then(() => {
                    const btn = event.currentTarget;
                    const orig = btn.innerHTML;
                    btn.innerHTML = '<i class="fa-solid fa-check text-sm"></i><span>Copied!</span>';
                    setTimeout(() => btn.innerHTML = orig, 2000);
                });
            }
        }
    </script>

@endsection
