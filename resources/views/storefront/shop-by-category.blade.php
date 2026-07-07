@extends('layouts.app') {{-- Change to 'storefront.layouts.app' if your master layout is there --}}

@section('title', 'Shop by Category - Bookish & Beyond')

@section('content')
<div class="bg-white min-h-screen font-sans text-gray-900 selection:bg-black selection:text-white">

    <!-- Premium Editorial Hero Section -->
    <div class="relative bg-gray-950 min-h-[340px] flex items-center justify-center px-4 overflow-hidden border-b border-gray-200">
        <!-- Background Overlay Layer -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&q=80&w=2000" 
                 alt="Organized School Essentials Stationery" 
                 class="w-full h-full object-cover opacity-20 object-center filter contrast-125 brightness-70">
            <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-black/40 to-black/80"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative max-w-4xl mx-auto text-center z-10 py-8">
            <span class="text-blue-400 text-xs font-bold tracking-[0.3em] uppercase mb-3 block">Curated Academic Collections</span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-white tracking-tight uppercase leading-none mb-4">
                Shop By Category
            </h1>
            <div class="w-16 h-[2px] bg-white mx-auto my-4 opacity-70"></div>
            <p class="max-w-xl mx-auto text-sm sm:text-base text-gray-300 font-serif italic leading-relaxed">
                Browse our structural collections meticulously sorted to equip students with top-tier academic gear and precision-stitched apparel.
            </p>
        </div>
    </div>

    <!-- Categories Editorial Layout Grid -->
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section Title -->
        <div class="border-b border-gray-200 pb-6 mb-12">
            <h2 class="text-2xl font-black text-gray-950 uppercase tracking-tight">The Core Collections</h2>
            <p class="text-sm text-gray-500 font-light mt-1">Explore premium essentials engineered for everyday school operations.</p>
        </div>

        <!-- Zara-Inspired High-Contrast Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Category 1: School Uniforms -->
            <div class="group bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="relative h-64 bg-gray-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1503919545889-aef636e10ad4?auto=format&fit=crop&q=80&w=800" 
                             alt="Premium School Uniforms" 
                             class="w-full h-full object-cover transform scale-100 transition-transform duration-1000 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/5"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-950 group-hover:text-blue-600 transition-colors duration-300 uppercase tracking-tight">School Uniforms</h3>
                        <p class="text-gray-500 text-xs font-light mt-2 leading-relaxed">
                            Precision-stitched shirts, trousers, skirts, and blazers matching specific institutional color codes.
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="#" class="block w-full text-center py-2.5 bg-gray-950 hover:bg-blue-600 text-white font-medium text-xs uppercase tracking-widest rounded transition-all duration-300">
                        Explore Uniforms
                    </a>
                </div>
            </div>

            <!-- Category 2: Textbooks & Bundles -->
            <div class="group bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="relative h-64 bg-gray-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1495446815901-a7297e633e8d?auto=format&fit=crop&q=80&w=800" 
                             alt="Curated Book Bundles" 
                             class="w-full h-full object-cover transform scale-100 transition-transform duration-1000 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/5"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-950 group-hover:text-blue-600 transition-colors duration-300 uppercase tracking-tight">Book Bundles</h3>
                        <p class="text-gray-500 text-xs font-light mt-2 leading-relaxed">
                            Grade-wise complete curriculum sets, reference guides, and tailored textbook sequences for smooth learning.
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="#" class="block w-full text-center py-2.5 bg-gray-950 hover:bg-blue-600 text-white font-medium text-xs uppercase tracking-widest rounded transition-all duration-300">
                        Explore Books
                    </a>
                </div>
            </div>

            <!-- Category 3: Premium Stationery -->
            <div class="group bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="relative h-64 bg-gray-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1513542789411-b6a5d4f31634?auto=format&fit=crop&q=80&w=800" 
                             alt="Premium Academic Stationery" 
                             class="w-full h-full object-cover transform scale-100 transition-transform duration-1000 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/5"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-950 group-hover:text-blue-600 transition-colors duration-300 uppercase tracking-tight">Stationery</h3>
                        <p class="text-gray-500 text-xs font-light mt-2 leading-relaxed">
                            High-grade notebooks, geometry setups, premium writing instruments, and artistic drafting accessories.
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="#" class="block w-full text-center py-2.5 bg-gray-950 hover:bg-blue-600 text-white font-medium text-xs uppercase tracking-widest rounded transition-all duration-300">
                        Explore Gear
                    </a>
                </div>
            </div>

            <!-- Category 4: Academic Accessories -->
            <div class="group bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="relative h-64 bg-gray-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&q=80&w=800" 
                             alt="Ergonomic School Bags & Accessories" 
                             class="w-full h-full object-cover transform scale-100 transition-transform duration-1000 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/5"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-950 group-hover:text-blue-600 transition-colors duration-300 uppercase tracking-tight">Accessories</h3>
                        <p class="text-gray-500 text-xs font-light mt-2 leading-relaxed">
                            Ergonomic high-durability school bags, functional water flasks, dynamic lunchboxes, and customized badges.
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="#" class="block w-full text-center py-2.5 bg-gray-950 hover:bg-blue-600 text-white font-medium text-xs uppercase tracking-widest rounded transition-all duration-300">
                        Explore Utilities
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection