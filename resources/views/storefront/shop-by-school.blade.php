@extends('layouts.app') {{-- Change to 'storefront.layouts.app' if your master layout is there --}}

@section('title', 'Shop by School - Bookish & Beyond')

@section('content')
<div class="bg-white min-h-screen font-sans text-gray-900 selection:bg-black selection:text-white">

    <!-- Premium Editorial Hero Section -->
    <div class="relative bg-gray-950 min-h-[340px] flex items-center justify-center px-4 overflow-hidden border-b border-gray-200">
        <!-- Background Overlay Layer -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&q=80&w=2000" 
                 alt="Academic Campus Bricks" 
                 class="w-full h-full object-cover opacity-25 object-center filter contrast-115 brightness-70">
            <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-black/40 to-black/80"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative max-w-4xl mx-auto text-center z-10 py-8">
            <span class="text-blue-400 text-xs font-bold tracking-[0.3em] uppercase mb-3 block">Official Partner Ecosystem</span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-white tracking-tight uppercase leading-none mb-4">
                Shop By School
            </h1>
            <div class="w-16 h-[2px] bg-white mx-auto my-4 opacity-70"></div>
            <p class="max-w-xl mx-auto text-sm sm:text-base text-gray-300 font-serif italic leading-relaxed">
                Select your institution to browse customized uniform bundles, accurate color-coded badges, and mandatory book structures.
            </p>
        </div>
    </div>

    <!-- Institutional Matrix Grid -->
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        
        <!-- Section Title & Search/Filter Utility Bar -->
        <div class="flex flex-col md:flex-row md:items-end justify-between border-b border-gray-200 pb-6 mb-12 gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-950 uppercase tracking-tight">Select Your Institution</h2>
                <p class="text-sm text-gray-500 font-light mt-1">Showing active verified school catalogs in your region.</p>
            </div>
            
            <!-- Quick Client-Side Filter Input Placeholder -->
            <div class="relative w-full md:w-80">
                <input type="text" 
                       placeholder="Search your school..." 
                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded text-sm font-light focus:outline-none focus:border-gray-950 focus:bg-white transition-all duration-300">
                <span class="absolute right-3 top-3 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
            </div>
        </div>

        <!-- Schools Visual Grid Layout -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- School Card 1 -->
            <div class="group bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="relative h-48 bg-gray-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&q=80&w=800" 
                             alt="Beaconhouse School System" 
                             class="w-full h-full object-cover transform scale-100 transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/5"></div>
                    </div>
                    <div class="p-6">
                        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest bg-blue-50 px-2 py-0.5 rounded">Verified Bundle</span>
                        <h3 class="text-xl font-bold text-gray-950 mt-3 group-hover:text-blue-600 transition-colors duration-300">Beaconhouse School System</h3>
                        <p class="text-gray-500 text-xs font-light mt-2 leading-relaxed">
                            Complete custom summer/winter uniforms, standard premium fabrics, and grade-wise textbook bundles.
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="#" class="block w-full text-center py-2.5 bg-gray-950 hover:bg-blue-600 text-white font-medium text-xs uppercase tracking-widest rounded transition-all duration-300">
                        View Catalogue
                    </a>
                </div>
            </div>

            <!-- School Card 2 -->
            <div class="group bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="relative h-48 bg-gray-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&q=80&w=800" 
                             alt="The City School" 
                             class="w-full h-full object-cover transform scale-100 transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/5"></div>
                    </div>
                    <div class="p-6">
                        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest bg-blue-50 px-2 py-0.5 rounded">Verified Bundle</span>
                        <h3 class="text-xl font-bold text-gray-950 mt-3 group-hover:text-blue-600 transition-colors duration-300">The City School</h3>
                        <p class="text-gray-500 text-xs font-light mt-2 leading-relaxed">
                            Official matching uniform items including monogrammed shirts, trousers, belts, and specific stationery gears.
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="#" class="block w-full text-center py-2.5 bg-gray-950 hover:bg-blue-600 text-white font-medium text-xs uppercase tracking-widest rounded transition-all duration-300">
                        View Catalogue
                    </a>
                </div>
            </div>

            <!-- School Card 3 -->
            <div class="group bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="relative h-48 bg-gray-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1546410531-bb4caa6b424d?auto=format&fit=crop&q=80&w=800" 
                             alt="Army Public Schools & Colleges System" 
                             class="w-full h-full object-cover transform scale-100 transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/5"></div>
                    </div>
                    <div class="p-6">
                        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest bg-blue-50 px-2 py-0.5 rounded">Verified Bundle</span>
                        <h3 class="text-xl font-bold text-gray-950 mt-3 group-hover:text-blue-600 transition-colors duration-300">APSACS Catalog</h3>
                        <p class="text-gray-500 text-xs font-light mt-2 leading-relaxed">
                            Standard regular and sports uniforms with precise insignia embroidery and mandatory multi-subject book packages.
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="#" class="block w-full text-center py-2.5 bg-gray-950 hover:bg-blue-600 text-white font-medium text-xs uppercase tracking-widest rounded transition-all duration-300">
                        View Catalogue
                    </a>
                </div>
            </div>

            <!-- School Card 4 (Divisional Public School Placeholder) -->
            <div class="group bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="relative h-48 bg-gray-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&q=80&w=800" 
                             alt="Divisional Public School" 
                             class="w-full h-full object-cover transform scale-100 transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/5"></div>
                    </div>
                    <div class="p-6">
                        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest bg-blue-50 px-2 py-0.5 rounded">Verified Bundle</span>
                        <h3 class="text-xl font-bold text-gray-950 mt-3 group-hover:text-blue-600 transition-colors duration-300">Divisional Public School (DPS)</h3>
                        <p class="text-gray-500 text-xs font-light mt-2 leading-relaxed">
                            Premium stitching layouts for tailored school suits, high-grade notebooks, and recommended session gear.
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="#" class="block w-full text-center py-2.5 bg-gray-950 hover:bg-blue-600 text-white font-medium text-xs uppercase tracking-widest rounded transition-all duration-300">
                        View Catalogue
                    </a>
                </div>
            </div>

        </div>

        <!-- Pagination / Bottom Note -->
        <div class="mt-16 text-center border-t border-gray-100 pt-8">
            <p class="text-xs text-gray-400 font-mono tracking-wider uppercase">
                Don't see your school? Contact our customer support matrix to request your institution bundle layout.
            </p>
        </div>

    </div>
</div>
@endsection