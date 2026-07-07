@extends('layouts.app') {{-- Change to 'storefront.layouts.app' if your master layout is there --}}

@section('title', 'About Us - Bookish & Beyond')

@section('content')
<div class="bg-white min-h-screen font-sans text-gray-900 selection:bg-black selection:text-white">

    <!-- Premium Real-Website Hero Section -->
    <div class="relative bg-gray-950 min-h-[520px] md:min-h-[580px] flex items-center justify-center px-4 overflow-hidden border-b border-gray-200">
        <!-- Editorial Background Layer -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1506880018603-83d5b814b5a6?auto=format&fit=crop&q=80&w=2000" 
                 alt="Bookish & Beyond Classic Academic Heritage" 
                 class="w-full h-full object-cover opacity-40 object-center filter contrast-115 brightness-90">
            <!-- Smooth Gradient Vignette for Readability -->
            <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-black/40 to-black/80"></div>
        </div>

        <!-- Hero Central Typography Box -->
        <div class="relative max-w-5xl mx-auto text-center z-10 py-12">
            <span class="text-blue-400 text-xs font-bold tracking-[0.3em] uppercase mb-4 block">
                Our Journey | Who We Are | What We Stand For
            </span>
            
            <h1 class="text-4xl sm:text-6xl md:text-7xl font-black text-white tracking-tight uppercase leading-none mb-4">
                Cultivating Curiosity <br class="hidden sm:inline">Since 2026
            </h1>

            <!-- Editorial Accent Divider Line -->
            <div class="w-24 h-[2px] bg-white mx-auto my-6 opacity-80"></div>
            
            <p class="max-w-2xl mx-auto text-base sm:text-lg md:text-xl text-gray-200 font-serif italic leading-relaxed mb-8">
                "Empowering Students & Schools in Lahore, Punjab, Pakistan by engineering a flawless ecosystem for academic supplies."
            </p>

            <!-- Action Callouts -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#our-story" class="w-full sm:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm uppercase tracking-wider rounded transition-all duration-300 shadow-lg shadow-blue-900/20">
                    Our Full Story
                </a>
                <a href="#pillars" class="w-full sm:w-auto px-8 py-3 bg-transparent border border-white hover:bg-white hover:text-black text-white font-medium text-sm uppercase tracking-wider rounded transition-all duration-300">
                    Learn More
                </a>
            </div>
        </div>
    </div>

    <!-- Main Dynamic Section Layout -->
    <div id="our-story" class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Grid: Text Editorial Content -->
            <div class="lg:col-span-5 order-2 lg:order-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-blue-50 text-blue-600 rounded">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-950 tracking-tight">
                        Our Story | Bookish & Beyond
                    </h2>
                </div>
                
                <div class="w-12 h-1 bg-blue-600 mb-6 rounded-full"></div>

                <div class="space-y-4 text-gray-600 leading-relaxed font-light">
                    <p>
                        Welcome to <strong class="font-medium text-gray-900">Bookish & Beyond</strong>, your premium, trusted digital marketplace built specifically to redefine the way families shop for school uniforms, high-caliber stationery, and coordinated book bundles.
                    </p>
                    <p>
                        Our operations are built closely around localized educational guidelines, transforming the stressful and chaotic seasonal school prep rush into a luxury, single-click checkout. No long queues, no generic fits, and no missing items.
                    </p>
                    <p>
                        We stand by our absolute promise to provide premium textiles, exact institutional matching color codes, and pristine customer support tailored right out of Kasur to homes all across the region.
                    </p>
                </div>
            </div>

            <!-- Right Grid: High Contrast Group Showcase Image -->
            <div class="lg:col-span-7 order-1 lg:order-2">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl bg-gray-100 h-[350px] sm:h-[450px] group">
                    <div class="absolute inset-0 bg-black/10 z-10 transition-opacity duration-300 group-hover:opacity-0"></div>
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=1200" 
                         alt="Academic Group Collaborating" 
                         class="w-full h-full object-cover transform scale-100 transition-transform duration-1000 group-hover:scale-105"
                         loading="lazy">
                    <div class="absolute bottom-4 right-4 z-20 bg-black/90 backdrop-blur-sm px-4 py-2 rounded text-white shadow-md">
                        <p class="text-xs font-mono tracking-widest uppercase">Production Environment Setup</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Layout Border Grid Separator -->
        <hr class="my-20 border-gray-200">

        <!-- Core Pillars / Contact Details Split Section -->
        <div id="pillars" class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Card Pillar 1 -->
            <div class="bg-white border border-gray-100 p-8 rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mb-6">
                        <span class="text-lg font-black tracking-tighter">A+</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-950 mb-3">Behtareen Quality</h3>
                    <p class="text-gray-600 text-sm leading-relaxed font-light">
                        We deploy meticulously vetted fabrics and sturdy stationery lines designed carefully to endure standard heavy physical academic year workflows.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100 text-xs font-bold text-blue-600 uppercase tracking-wider">Verified Asset Guarantee</div>
            </div>

            <!-- Card Pillar 2 -->
            <div class="bg-white border border-gray-100 p-8 rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-950 mb-3">On-Time Delivery</h3>
                    <p class="text-gray-600 text-sm leading-relaxed font-light">
                        Never miss an academic milestone. Every single bundle layout gets verified, securely packed, and routed early straight to your doorstep.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100 text-xs font-bold text-blue-600 uppercase tracking-wider">Fast-Track Tracking Ready</div>
            </div>

            <!-- Card Pillar 3: Corporate Real Contact Matrix Card -->
            <div class="bg-gray-950 text-white p-8 rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-white/10 text-blue-400 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold tracking-tight mb-4 uppercase">Contact Us</h3>
                    
                    <ul class="space-y-3 text-xs text-gray-300 font-mono tracking-tight">
                        <li class="flex items-center gap-2">
                            <span class="text-blue-400">⚡</span> info@bookishandbeyond.com
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-blue-400">📞</span> +92 320 4735908
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-blue-400">📍</span> Lahore, Punjab, Pakistan
                        </li>
                    </ul>
                </div>
                <div class="mt-6 pt-4 border-t border-white/10 text-xs font-bold text-gray-400 uppercase tracking-widest">Customer Support Grid</div>
            </div>

        </div>

    </div>
</div>
@endsection