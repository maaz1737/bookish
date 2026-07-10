@extends('layouts.app')

@section('title', 'About Us - Bookish & Beyond')

@section('content')

    {{-- ===== BREADCRUMB ===== --}}
    <nav class="text-xs text-slate-500 mb-6 flex items-center gap-2 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-[#001F54] transition-colors">Home</a>
        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
        <span class="text-[#001F54] font-semibold">About Us</span>
    </nav>

    {{-- ===== HERO BANNER ===== --}}
    <section class="relative overflow-hidden bg-gradient-to-r from-slate-50 via-slate-100 to-indigo-50/50 border border-slate-200/60 rounded-[24px] shadow-sm mb-14 p-8 md:p-12">
        <div class="grid md:grid-cols-12 items-center gap-8 relative z-10">
            <div class="md:col-span-7">
                <span class="text-[#ff7a00] font-bold text-xs uppercase tracking-widest flex items-center gap-2 mb-3">
                    <i class="fa-solid fa-star text-[10px]"></i> Welcome to Bookish &amp; Beyond
                </span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-[#001F54] leading-tight tracking-tight">
                    About <span class="text-[#ff7a00]">Us</span>
                </h1>
                <p class="text-slate-600 text-sm md:text-base mt-4 max-w-xl leading-relaxed">
                    Your trusted destination for school essentials, gifts, decor, and everyday family products — all in one place.
                    Quality you can trust, service you can rely on.
                </p>

                {{-- Mini trust badges --}}
                <div class="flex flex-wrap gap-4 mt-7">
                    <div class="flex items-center gap-2 text-xs text-slate-600 font-medium">
                        <div class="w-8 h-8 bg-[#001F54]/8 rounded-lg flex items-center justify-center text-[#001F54]">
                            <i class="fa-solid fa-shield-halved text-sm"></i>
                        </div>
                        100% Original
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-600 font-medium">
                        <div class="w-8 h-8 bg-[#001F54]/8 rounded-lg flex items-center justify-center text-[#001F54]">
                            <i class="fa-solid fa-truck text-sm"></i>
                        </div>
                        Fast Delivery
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-600 font-medium">
                        <div class="w-8 h-8 bg-[#001F54]/8 rounded-lg flex items-center justify-center text-[#001F54]">
                            <i class="fa-solid fa-rotate-left text-sm"></i>
                        </div>
                        Easy Returns
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-600 font-medium">
                        <div class="w-8 h-8 bg-[#001F54]/8 rounded-lg flex items-center justify-center text-[#001F54]">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        Secure Payments
                    </div>
                </div>
            </div>

            <div class="md:col-span-5 flex justify-center md:justify-end">
                <img src="{{ url('images/about_hero_collage.png') }}"
                     alt="Bookish & Beyond Products"
                     class="max-h-64 md:max-h-72 object-contain drop-shadow-lg hover:scale-[1.03] transition-transform duration-500">
            </div>
        </div>
        <div class="absolute -top-12 -right-12 w-64 h-64 bg-gradient-to-br from-[#001F54]/5 to-transparent rounded-full pointer-events-none"></div>
    </section>

    {{-- ===== OUR STORY ===== --}}
    <section class="mb-14">
        <div class="grid lg:grid-cols-12 gap-12 items-start">
            {{-- Left: Story text --}}
            <div class="lg:col-span-5">
                <h2 class="text-2xl md:text-3xl font-extrabold text-[#001F54] tracking-tight mb-2">Our Story</h2>
                <div class="w-10 h-1 bg-[#ff7a00] rounded-full mb-5"></div>
                <div class="text-slate-500 text-sm leading-relaxed space-y-4">
                    <p>Bookish &amp; Beyond started in <strong class="text-[#001F54]">2017</strong> as a physical store in Lahore Cantt, serving students and parents with school essentials such as books, uniforms, stationery, bags, and other related items.</p>
                    <p>We initially began our services with the <strong class="text-[#001F54]">Fazaia School System</strong> and later expanded our product range to include gifts, baby wear, accessories, decoration pieces, metal models, metal crafts, handicrafts, and other useful family products.</p>
                    <p>To make shopping more convenient, we extended our services through our <strong class="text-[#001F54]">e-commerce store</strong>, where customers can easily explore and purchase school essentials, gift items, and everyday family products from one place.</p>
                </div>
            </div>

            {{-- Right: Journey timeline --}}
            <div class="lg:col-span-7">
                <h2 class="text-2xl md:text-3xl font-extrabold text-[#001F54] tracking-tight mb-2">Our Journey</h2>
                <div class="w-10 h-1 bg-[#ff7a00] rounded-full mb-8"></div>

                <div class="space-y-0">
                    @php
                        $timeline = [
                            ['year' => '2017', 'icon' => 'fa-store', 'title' => 'Started as a Physical Store', 'desc' => 'We opened our physical store in Lahore Cantt to serve students and parents with quality school-related products.'],
                            ['year' => '', 'icon' => 'fa-graduation-cap', 'title' => 'Expanded with Fazaia School System', 'desc' => 'We began our journey by providing school essentials and related products to the Fazaia School System.'],
                            ['year' => '', 'icon' => 'fa-boxes-stacked', 'title' => 'Grew Our Product Range', 'desc' => 'Over time, we expanded to include gifts, baby wear, accessories, decoration pieces, metal models, metal crafts, handicrafts, and other useful family products.'],
                            ['year' => 'Today', 'icon' => 'fa-cart-shopping', 'title' => 'Serving You Online', 'desc' => 'We now bring our products closer to customers through our e-commerce store, making it easier to shop from anywhere.'],
                        ];
                    @endphp

                    @foreach ($timeline as $i => $step)
                        <div class="flex gap-5 {{ !$loop->last ? 'pb-8' : '' }} relative">
                            {{-- Line --}}
                            @if (!$loop->last)
                                <div class="absolute left-5 top-10 w-0.5 h-full bg-slate-100 -translate-x-1/2"></div>
                            @endif

                            {{-- Icon --}}
                            <div class="shrink-0 w-10 h-10 rounded-full bg-[#F97316] text-white flex items-center justify-center z-10 shadow-md">
                                <i class="fa-solid {{ $step['icon'] }} text-sm"></i>
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 pt-1">
                                @if ($step['year'])
                                    <span class="text-[#ff7a00] font-extrabold text-xs uppercase tracking-widest">{{ $step['year'] }}</span>
                                @endif
                                <h3 class="font-extrabold text-[#001F54] text-sm mt-0.5 mb-1">{{ $step['title'] }}</h3>
                                <p class="text-slate-500 text-xs leading-relaxed">{{ $step['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ===== OUR VALUES ===== --}}
    <section class="mb-14">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-extrabold text-[#001F54] tracking-tight">Our Values</h2>
            <div class="w-12 h-1 bg-[#ff7a00] mx-auto mt-3 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @php
                $values = [
                    ['icon' => 'fa-handshake', 'title' => 'Honesty is the Key to Success', 'desc' => 'We believe in honesty and transparency in everything we do. Our goal is to build long-term relationships with our customers through trust and fair dealing.'],
                    ['icon' => 'fa-gem', 'title' => 'Quality Products', 'desc' => 'We carefully select products to ensure good quality and better value for our customers.'],
                    ['icon' => 'fa-shield-halved', 'title' => 'Customer Trust', 'desc' => 'Customer trust is our biggest achievement. We believe that when customers receive quality products and reliable service, they come back with confidence.'],
                    ['icon' => 'fa-heart', 'title' => 'Convenience & Care', 'desc' => 'We focus on making shopping easier, more reliable, and more convenient for every customer.'],
                ];
            @endphp

            @foreach ($values as $value)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,31,84,0.03)] p-6 flex flex-col items-center text-center gap-3 group hover:shadow-[0_8px_30px_rgba(0,31,84,0.07)] hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-[#001F54]/5 text-[#001F54] flex items-center justify-center group-hover:bg-[#F97316] group-hover:text-white transition-all duration-300">
                        <i class="fa-solid {{ $value['icon'] }} text-xl"></i>
                    </div>
                    <h3 class="font-extrabold text-[#001F54] text-sm leading-snug">{{ $value['title'] }}</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">{{ $value['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ===== WHAT WE OFFER ===== --}}
    <section class="mb-14">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-extrabold text-[#001F54] tracking-tight">What We Offer</h2>
            <div class="w-12 h-1 bg-[#ff7a00] mx-auto mt-3 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @php
                $offers = [
                    ['img' => 'about_offer_school.png',  'title' => 'School Essentials',    'desc' => 'Books, uniforms, bags, stationery & more.'],
                    ['img' => 'about_offer_gifts.png',   'title' => 'Gifts & Decor',         'desc' => 'Thoughtful gifts, home decor & decorative pieces.'],
                    ['img' => 'about_offer_metal.png',   'title' => 'Metal Models & Crafts', 'desc' => 'Metal models, metal crafts & unique handicrafts.'],
                    ['img' => 'about_offer_family.png',  'title' => 'Family Products',       'desc' => 'Baby wear, accessories & everyday family essentials.'],
                ];
            @endphp

            @foreach ($offers as $offer)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,31,84,0.03)] overflow-hidden group hover:shadow-[0_8px_30px_rgba(0,31,84,0.08)] hover:-translate-y-1 transition-all duration-300">
                    <div class="h-44 bg-slate-50 overflow-hidden">
                        <img src="{{ url('images/' . $offer['img']) }}"
                             alt="{{ $offer['title'] }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-5">
                        <h3 class="font-extrabold text-[#001F54] text-sm mb-1">{{ $offer['title'] }}</h3>
                        <p class="text-slate-500 text-xs leading-relaxed">{{ $offer['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ===== MISSION BANNER ===== --}}
    <section class="mb-14">
        <div class="bg-[#001F54] rounded-2xl p-8 md:p-10 text-white flex flex-col md:flex-row items-center gap-6 shadow-lg">
            <div class="w-16 h-16 shrink-0 bg-white/10 rounded-2xl flex items-center justify-center">
                <i class="fa-solid fa-bullseye text-[#ff7a00] text-3xl"></i>
            </div>
            <div>
                <span class="text-[#ff7a00] text-xs font-bold uppercase tracking-widest">Our Mission</span>
                <p class="text-white font-extrabold text-lg md:text-xl leading-snug mt-1">
                    Our mission is simple: to make school, family, and gift shopping easier, more reliable, and more convenient for every customer.
                </p>
            </div>
        </div>
    </section>

    {{-- ===== WHY CHOOSE US ===== --}}
    <section class="mb-14">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-extrabold text-[#001F54] tracking-tight">Why Choose Bookish &amp; Beyond?</h2>
            <div class="w-12 h-1 bg-[#ff7a00] mx-auto mt-3 rounded-full"></div>
        </div>

        <div class="bg-white rounded-[20px] shadow-[0_8px_24px_rgba(0,31,84,0.04)] border border-slate-100 p-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6 text-sm">
            @php
                $whyUs = [
                    ['icon' => 'fa-shield-halved', 'title' => '100% Original Products', 'desc' => 'Sourced from authorized suppliers.'],
                    ['icon' => 'fa-truck',          'title' => 'Fast & Reliable Delivery', 'desc' => 'Quick and safe order delivery.'],
                    ['icon' => 'fa-lock',           'title' => 'Secure Payments',          'desc' => 'Multiple payment options.'],
                    ['icon' => 'fa-rotate-left',    'title' => 'Easy Returns',              'desc' => 'Hassle-free returns within 14 days.'],
                    ['icon' => 'fa-headset',        'title' => 'Dedicated Support',         'desc' => 'We\'re here to help you anytime.'],
                ];
            @endphp

            @foreach ($whyUs as $item)
                <div class="flex gap-4 items-start p-2">
                    <div class="w-12 h-12 shrink-0 bg-[#001F54]/5 rounded-xl flex items-center justify-center text-[#001F54]">
                        <i class="fa-solid {{ $item['icon'] }} text-xl"></i>
                    </div>
                    <div>
                        <b class="text-[#001F54] font-bold block text-sm leading-snug">{{ $item['title'] }}</b>
                        <p class="text-xs text-slate-500 mt-1 leading-normal">{{ $item['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ===== CLOSING MESSAGE ===== --}}
    {{-- <section class="mb-6">
        <div class="bg-gradient-to-r from-slate-50 to-indigo-50/50 border border-slate-200/60 rounded-2xl p-8 text-center shadow-sm">
            <div class="w-14 h-14 bg-[#ff7a00]/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-heart text-[#ff7a00] text-2xl"></i>
            </div>
            <h2 class="font-extrabold text-[#001F54] text-xl mb-2">Thank you for choosing Bookish &amp; Beyond.</h2>
            <p class="text-slate-500 text-sm leading-relaxed max-w-lg mx-auto">
                We look forward to serving you with honesty, quality, and care.
            </p>
            <a href="{{ route('products.index') }}" class="primary-btn inline-flex mt-6">
                Shop Now <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
    </section> --}}

@endsection