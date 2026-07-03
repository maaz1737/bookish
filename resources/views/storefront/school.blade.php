@extends('layouts.app')

@section('title', $school->name . ' — School Essentials | Bookish & Beyond')
@section('meta_description', 'Find all required books, uniforms and essentials for every class at ' . $school->name . '. Shop class-wise bundles at Bookish & Beyond.')

@section('content')

@php
    // Filter: only Class 1 to Class 8 (sort_order 1–8, or name matches)
    $primaryClasses = $school->classes->filter(function($cls) {
        // Match by sort_order 1-8, or by name pattern
        if ($cls->sort_order >= 1 && $cls->sort_order <= 8) return true;
        if (preg_match('/class\s*[1-8]\b/i', $cls->name)) return true;
        return false;
    })->values();

    // School image (use logo or fallback)
    $schoolBg = 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=1600&auto=format&fit=crop';
@endphp

{{-- ======================== SCHOOL BANNER ======================== --}}
<section class="relative overflow-hidden" style="min-height:200px">
    {{-- Background image with overlay --}}
    <div class="absolute inset-0">
        <img src="{{ $schoolBg }}" class="w-full h-full object-cover" alt="{{ $school->name }}" />
        <div class="absolute inset-0" style="background:linear-gradient(135deg,rgba(10,31,68,0.92) 0%,rgba(10,31,68,0.75) 60%,rgba(10,31,68,0.55) 100%)"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
        <div class="flex flex-col lg:flex-row items-center lg:items-center gap-6 lg:gap-10">

            {{-- Left: Logo + name + subtitle --}}
            <div class="flex items-center gap-5 flex-1">
                {{-- School logo badge --}}
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-white flex items-center justify-center flex-shrink-0 shadow-xl border-2 border-white/30 p-2">
                    @if ($school->logo)
                        <img src="{{ asset('storage/' . $school->logo) }}" class="w-full h-full object-contain" alt="{{ $school->name }}" />
                    @else
                        <svg viewBox="0 0 80 80" class="w-full h-full"><circle cx="40" cy="40" r="38" fill="#0a1f44"/><path d="M18 54 Q40 34 62 54" fill="none" stroke="#f59e0b" stroke-width="3"/><polygon points="40,16 44,28 56,28 47,35 50,47 40,40 30,47 33,35 24,28 36,28" fill="#f59e0b"/></svg>
                    @endif
                </div>

                <div>
                    <div class="inline-flex items-center gap-1.5 bg-amber-400/20 border border-amber-400/40 text-amber-300 text-xs font-bold px-3 py-1 rounded-full mb-2 backdrop-blur-sm">
                        <i class="fa-solid fa-shield-halved text-xs"></i> Verified School
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight">{{ $school->name }}</h1>
                    <p class="text-sm sm:text-base text-blue-100 mt-1 max-w-md">Find all required books, uniforms and essentials for every class.</p>
                </div>
            </div>

            {{-- Right: Trust points --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-2 xl:grid-cols-4 gap-3 lg:gap-4 flex-shrink-0">
                @foreach ([
                    ['icon' => 'fa-book-open', 'title' => '100% Original Books', 'sub' => 'Authorized publishers'],
                    ['icon' => 'fa-school', 'title' => 'Recommended by Schools', 'sub' => 'Official booklists'],
                    ['icon' => 'fa-rotate-left', 'title' => 'Easy Returns', 'sub' => 'Within 7 days'],
                    ['icon' => 'fa-heart', 'title' => 'Trusted by Parents', 'sub' => '1000s of families'],
                ] as $trust)
                    <div class="flex flex-col items-center text-center bg-white/10 backdrop-blur-sm border border-white/15 rounded-xl px-3 py-3 min-w-[100px]">
                        <div class="w-9 h-9 rounded-full bg-amber-400/20 flex items-center justify-center mb-1.5">
                            <i class="fa-solid {{ $trust['icon'] }} text-amber-300 text-sm"></i>
                        </div>
                        <span class="text-white text-[11px] font-bold leading-tight">{{ $trust['title'] }}</span>
                        <span class="text-blue-200 text-[10px] mt-0.5">{{ $trust['sub'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ======================== MAIN CONTENT ======================== --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="text-xs text-gray-500 flex items-center gap-1.5 mb-8">
        <a href="{{ url('/') }}" class="hover:text-[#0a1f44]"><i class="fa-solid fa-house text-xs"></i></a>
        <span>/</span>
        <a href="{{ route('schools.index') }}" class="hover:text-[#0a1f44]">Schools</a>
        <span>/</span>
        <span class="text-[#0a1f44] font-semibold">{{ $school->name }}</span>
    </nav>

    {{-- ======================== CLASS SELECTION ======================== --}}
    <section class="mb-14">
        {{-- Section header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-[#0a1f44] text-xs font-bold px-4 py-1.5 rounded-full mb-3">
                <i class="fa-solid fa-chalkboard-user text-xs"></i> Class Selection
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0a1f44]">Select Your Child's Class</h2>
            <p class="text-gray-500 mt-2 text-sm sm:text-base max-w-lg mx-auto">Choose your child's class to explore Save Smarter Bundles and essentials.</p>
        </div>

        @if ($primaryClasses->isEmpty())
            <div class="text-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-school text-[#0a1f44] text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-700">No Classes Available Yet</h3>
                <p class="text-gray-400 text-sm mt-1">Please check back soon.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($primaryClasses as $class)
                    @php
                        $num = str_pad($loop->iteration, 2, '0', STR_PAD_LEFT);
                        $productCount = $class->products->count();
                    @endphp
                    <a href="{{ route('bundle.show', [$school, $class->slug]) }}"
                        class="group flex items-center gap-5 bg-white border border-gray-200 hover:border-[#0a1f44] rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer relative overflow-hidden">

                        {{-- Subtle corner accent --}}
                        <div class="absolute top-0 right-0 w-16 h-16 rounded-bl-3xl bg-slate-50 group-hover:bg-blue-50 transition-colors duration-200"></div>

                        {{-- Class number badge --}}
                        <div class="w-14 h-14 rounded-2xl bg-[#0a1f44] group-hover:bg-[#0d2a5c] flex items-center justify-center flex-shrink-0 transition-colors duration-200 shadow">
                            <span class="text-xl font-extrabold text-white leading-none">{{ $num }}</span>
                        </div>

                        {{-- Class info --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-extrabold text-[#0a1f44] leading-tight">{{ $class->name }}</h3>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $productCount > 0 ? $productCount . ' Items Available' : 'Bundle Available' }}</p>
                        </div>

                        {{-- Arrow --}}
                        <div class="shrink-0 w-8 h-8 rounded-full bg-gray-100 group-hover:bg-[#0a1f44] flex items-center justify-center transition-all duration-200 relative z-10">
                            <i class="fa-solid fa-arrow-right text-gray-400 group-hover:text-white text-xs transition-all duration-200 group-hover:translate-x-0.5"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    {{-- ======================== SAVE SMARTER BUNDLES ======================== --}}
    @if ($bundles->count() > 0)
    <section class="mb-14">
        {{-- Section header --}}
        <div class="flex items-end justify-between mb-6">
            <div>
                <div class="inline-flex items-center gap-2 bg-amber-50 border border-amber-200 text-amber-700 text-xs font-bold px-4 py-1.5 rounded-full mb-2">
                    <i class="fa-solid fa-boxes-stacked text-xs"></i> Exclusive Bundles
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0a1f44]">Save Smarter Bundles</h2>
                <p class="text-gray-500 text-sm mt-1">Curated bundles to give your child everything they need.</p>
            </div>
            <a href="{{ route('bundles.index') }}" class="hidden sm:flex items-center gap-1.5 text-sm font-semibold text-[#0a1f44] hover:text-amber-600 transition-colors whitespace-nowrap">
                View all bundles <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($bundles as $bundle)
                @php
                    $discount = $bundle->total_price > 0
                        ? round((($bundle->total_price - $bundle->final_price) / $bundle->total_price) * 100)
                        : ($bundle->discount ?? 0);
                    $bundleName = optional($bundle->schoolClass)->name . ' Bundle';
                    $allProds   = $bundle->products;
                    $prodImages = $allProds->filter(fn($p) => !empty($p->images))->take(4)->values();
                    $imgCount   = $prodImages->count();
                    $included   = $allProds->pluck('name')->map(fn($n) => \Illuminate\Support\Str::limit($n, 20))->join(' + ');
                    $imgHelper  = fn($path) => app()->environment('production')
                        ? asset('storage/' . $path)
                        : asset('storage/' . $path);
                @endphp
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden group flex flex-col">

                    {{-- Bundle collage image area --}}
                    <div class="relative overflow-hidden bg-gradient-to-br from-slate-50 via-blue-50/40 to-indigo-50 h-[200px]">

                        {{-- Discount badge --}}
                        @if ($discount > 0)
                            <div class="absolute top-3 left-3 z-20 bg-gradient-to-r from-amber-400 to-orange-400 text-white text-[11px] font-black px-3 py-1 rounded-full shadow-md flex items-center gap-1">
                                <i class="fa-solid fa-bolt text-[9px]"></i> Save {{ $discount }}%
                            </div>
                        @endif

                        {{-- Product count pill --}}
                        @if ($allProds->count() > 0)
                            <div class="absolute top-3 right-3 z-20 bg-white/80 backdrop-blur-sm text-[#0a1f44] text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm border border-slate-200">
                                {{ $allProds->count() }} items
                            </div>
                        @endif

                        @if ($imgCount === 0)
                            <div class="w-full h-full flex flex-col items-center justify-center gap-2 opacity-30">
                                <i class="fa-solid fa-boxes-stacked text-5xl text-slate-400"></i>
                                <span class="text-xs text-slate-400 font-medium">Bundle</span>
                            </div>

                        @elseif ($imgCount === 1)
                            <div class="w-full h-full flex items-center justify-center p-6">
                                <img src="{{ $imgHelper($prodImages[0]->images[0]) }}"
                                    class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-500"
                                    alt="{{ $prodImages[0]->name }}"
                                    onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}'">
                            </div>

                        @elseif ($imgCount === 2)
                            <div class="flex h-full">
                                @foreach ($prodImages as $prod)
                                    <div class="flex-1 flex items-center justify-center p-4 {{ !$loop->last ? 'border-r border-white/60' : '' }}">
                                        <img src="{{ $imgHelper($prod->images[0]) }}"
                                            class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-500"
                                            alt="{{ $prod->name }}"
                                            onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}'">
                                    </div>
                                @endforeach
                            </div>

                        @elseif ($imgCount === 3)
                            <div class="flex h-full">
                                @foreach ($prodImages as $prod)
                                    <div class="flex-1 flex items-center justify-center p-3 {{ !$loop->last ? 'border-r border-white/60' : '' }}">
                                        <img src="{{ $imgHelper($prod->images[0]) }}"
                                            class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-500"
                                            alt="{{ $prod->name }}"
                                            onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}'">
                                    </div>
                                @endforeach
                            </div>

                        @else
                            <div class="grid grid-cols-2 grid-rows-2 h-full">
                                @foreach ($prodImages as $prod)
                                    <div class="flex items-center justify-center p-3
                                        {{ $loop->index === 0 ? 'border-r border-b' : '' }}
                                        {{ $loop->index === 1 ? 'border-b' : '' }}
                                        {{ $loop->index === 2 ? 'border-r' : '' }}
                                        border-white/60">
                                        <img src="{{ $imgHelper($prod->images[0]) }}"
                                            class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-500"
                                            alt="{{ $prod->name }}"
                                            onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}'">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Bundle details --}}
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-extrabold text-[#0a1f44] text-base leading-tight">{{ $bundleName }}</h3>

                        @if ($included)
                            <p class="text-xs text-gray-400 mt-1.5 leading-relaxed">{{ $included }}</p>
                        @endif

                        <div class="mt-4 flex items-center gap-3">
                            @if ($bundle->total_price > 0 && $bundle->total_price != $bundle->final_price)
                                <span class="text-xs text-gray-400 line-through">PKR {{ number_format($bundle->total_price) }}</span>
                            @endif
                            <span class="text-lg font-extrabold text-[#0a1f44]">PKR {{ number_format($bundle->final_price) }}</span>
                        </div>

                        <div class="mt-auto pt-4">
                            <a href="{{ route('bundle.show', [$school, optional($bundle->schoolClass)->slug ?? '#']) }}"
                                class="w-full bg-[#0a1f44] hover:bg-[#0d2a5c] text-white text-sm font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition-colors duration-200">
                                View Bundle <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="sm:hidden text-center mt-4">
            <a href="#" class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#0a1f44] hover:text-amber-600 transition-colors">
                View all bundles <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    </section>
    @endif

    {{-- ======================== TRUST STRIP ======================== --}}
    <section class="mt-4 mb-6">
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm px-6 py-6">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach ([
                    ['icon' => 'fa-shield-halved',      'title' => '100% Original Products',  'sub' => 'Sourced from authorized publishers & brands'],
                    ['icon' => 'fa-truck',               'title' => 'Fast & Reliable Delivery', 'sub' => 'Across Pakistan'],
                    ['icon' => 'fa-credit-card',         'title' => 'Secure Payments',          'sub' => 'Multiple payment options'],
                    ['icon' => 'fa-rotate-left',         'title' => 'Easy Returns',             'sub' => 'Hassle-free returns within 7 days'],
                    ['icon' => 'fa-headset',             'title' => 'Dedicated Support',        'sub' => "We're here to help you anytime"],
                ] as $t)
                    <div class="flex items-center gap-3">
                        <i class="fa-solid {{ $t['icon'] }} text-2xl text-[#0a1f44] flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-bold text-[#0a1f44] leading-tight">{{ $t['title'] }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $t['sub'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</div>

@endsection
