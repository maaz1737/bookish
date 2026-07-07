@extends('layouts.app')

@section('title', 'Frequently Asked Questions - Bookish & Beyond')

@section('content')
<!-- 1. Main State Wrapper: Isme activeCategory variable 'orders' par initialized hai -->
<div class="bg-white min-h-screen font-sans text-gray-900 selection:bg-black selection:text-white" 
     x-data="{ activeCategory: 'orders' }">

    <!-- Hero Section -->
    {{-- <div class="relative bg-gray-950 min-h-[400px] flex items-center border-b border-gray-200 overflow-hidden">
        <div class="absolute inset-0 opacity-5 mix-blend-overlay pointer-events-none">
            <div class="w-full h-full bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>
        </div>
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-12 relative z-10">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-white tracking-tight uppercase">
                How can we <br><span class="text-gray-400">Help You?</span>
            </h1>
        </div>
    </div> --}}

    <!-- Premium Editorial Split-Panel Hero Section -->
    <div class="relative bg-gray-950 min-h-[460px] flex items-center border-b border-gray-200 overflow-hidden">
        <!-- Abstract Architectural Mesh Background (Subtle Layout Depth) -->
        <div class="absolute inset-0 opacity-5 mix-blend-overlay pointer-events-none">
            <div class="w-full h-full bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>
        </div>

        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-12 md:py-20 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Column: High-Contrast Editorial Content Layer -->
                <div class="lg:col-span-7 text-left space-y-6">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                        <span class="text-blue-400 text-xs font-black tracking-[0.35em] uppercase block">
                            Knowledge Base & Resolution Matrix
                        </span>
                    </div>
                    
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-white tracking-tight uppercase leading-[0.95]">
                        How can we <br class="hidden md:inline">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-200 to-gray-500">Help You?</span>
                    </h1>
                    
                    <div class="w-20 h-[3px] bg-gradient-to-r from-blue-600 to-transparent"></div>
                    
                    <p class="max-w-xl text-sm sm:text-base text-gray-400 font-serif italic leading-relaxed">
                        Find instantaneous operational answers regarding custom uniform sizing, mandatory book bundle configurations, and automated reverse packaging tracking.
                    </p>

                    <!-- Real-Time Support Status Stack -->
                    <div class="pt-4 flex flex-wrap gap-4 items-center text-[10px] font-mono uppercase tracking-widest text-gray-400 border-t border-gray-900 w-fit">
                        <div class="flex items-center gap-2 bg-gray-900/60 px-3 py-1.5 rounded-md border border-gray-800">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Live Resolution Desk Active
                        </div>
                        <div class="flex items-center gap-2 bg-gray-900/60 px-3 py-1.5 rounded-md border border-gray-800">
                            Average Response: <span class="text-blue-400 font-bold">&lt; 15 Mins</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Immersive Geometric Content Frame -->
                <div class="lg:col-span-5 relative hidden lg:block">
                    <!-- Layer 1: Ambient Lighting Glow Accent -->
                    <div class="absolute -inset-4 bg-gradient-to-tr from-blue-600/10 to-transparent rounded-2xl blur-xl opacity-50"></div>
                    
                    <!-- Layer 2: Main Conceptual Media Box -->
                    <div class="relative border border-gray-800 bg-gray-900 p-3 rounded-2xl shadow-2xl overflow-hidden group">
                        <div class="relative h-[280px] rounded-xl overflow-hidden bg-gray-950">
                            <img src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&q=80&w=1000" 
                                 alt="Premium Academic Stationery & Books Layout" 
                                 class="w-full h-full object-cover opacity-45 transform scale-100 transition-transform duration-[1500ms] ease-out group-hover:scale-105 filter contrast-110 brightness-75">
                            
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/20 to-transparent"></div>
                            
                            <!-- Floating Interactive Metric Badge -->
                            <div class="absolute bottom-4 left-4 right-4 bg-gray-950/80 backdrop-blur-md border border-gray-800 p-4 rounded-lg flex items-center justify-between">
                                <div class="space-y-0.5">
                                    <p class="text-[9px] font-mono uppercase text-gray-500 tracking-wider">Self-Service Utility</p>
                                    <p class="text-xs font-bold text-white">94% Instant Solution Rate</p>
                                </div>
                                <span class="bg-blue-600 text-white text-[10px] font-mono px-2 py-1 rounded font-bold uppercase tracking-wider">
                                    Verified
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Layer 3: Asymmetric Secondary Micro-Badge -->
                    <div class="absolute -top-6 -right-6 bg-white text-gray-950 font-black text-[10px] font-mono tracking-wider w-24 h-24 rounded-full flex flex-col items-center justify-center border-4 border-gray-950 shadow-2xl uppercase text-center p-2 transform -rotate-12 group-hover:rotate-0 transition-transform duration-500">
                        <span>24/7<br>Support<br>Hub</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Main FAQ Interface Section -->
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- LEFT SIDEBAR: FILTER BUTTONS -->
            <div class="lg:col-span-4 space-y-2 sticky top-6">
                <p class="text-[11px] font-mono uppercase tracking-widest text-gray-400 mb-4 px-3">Filter Matrix</p>
                
                <!-- Orders Tab Trigger -->
                <button @click="activeCategory = 'orders'" 
                        :class="activeCategory === 'orders' ? 'bg-gray-950 text-white font-bold border-l-4 border-blue-600 pl-5' : 'bg-gray-50 text-gray-700 hover:bg-gray-100 font-medium pl-4'"
                        class="w-full text-left py-3.5 pr-4 rounded-lg text-xs uppercase tracking-wider transition-all duration-200 flex items-center justify-between outline-none">
                    <span>📦 Orders & Shipping</span>
                    <span>→</span>
                </button>

                <!-- Uniforms Tab Trigger -->
                <button @click="activeCategory = 'uniforms'" 
                        :class="activeCategory === 'uniforms' ? 'bg-gray-950 text-white font-bold border-l-4 border-blue-600 pl-5' : 'bg-gray-50 text-gray-700 hover:bg-gray-100 font-medium pl-4'"
                        class="w-full text-left py-3.5 pr-4 rounded-lg text-xs uppercase tracking-wider transition-all duration-200 flex items-center justify-between outline-none">
                    <span>👚 Uniform Sizing & Fabric</span>
                    <span>→</span>
                </button>

                <!-- Books Tab Trigger -->
                <button @click="activeCategory = 'books'" 
                        :class="activeCategory === 'books' ? 'bg-gray-950 text-white font-bold border-l-4 border-blue-600 pl-5' : 'bg-gray-50 text-gray-700 hover:bg-gray-100 font-medium pl-4'"
                        class="w-full text-left py-3.5 pr-4 rounded-lg text-xs uppercase tracking-wider transition-all duration-200 flex items-center justify-between outline-none">
                    <span>📚 Curriculum & Book Bundles</span>
                    <span>→</span>
                </button>

                <!-- Payments Tab Trigger -->
                <button @click="activeCategory = 'payments'" 
                        :class="activeCategory === 'payments' ? 'bg-gray-950 text-white font-bold border-l-4 border-blue-600 pl-5' : 'bg-gray-50 text-gray-700 hover:bg-gray-100 font-medium pl-4'"
                        class="w-full text-left py-3.5 pr-4 rounded-lg text-xs uppercase tracking-wider transition-all duration-200 flex items-center justify-between outline-none">
                    <span>💳 Payments & Refunds</span>
                    <span>→</span>
                </button>
            </div>

            <!-- RIGHT COLUMN: DYNAMIC CONTENT BLOCKS -->
            <div class="lg:col-span-8 space-y-6">

                <!-- 1. ORDERS CONTENT -->
                <div x-show="activeCategory === 'orders'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-2"
                     class="space-y-4">
                    <h2 class="text-xl font-black text-gray-950 uppercase tracking-tight mb-6 border-b border-gray-100 pb-2">Orders & Shipping</h2>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-xl overflow-hidden bg-white shadow-sm">
                        <button @click="open = !open" class="w-full flex items-center justify-between p-5 text-left font-bold text-sm uppercase text-gray-950 bg-gray-50/50">
                            <span>How long will it take to receive my package?</span>
                            <span :class="open ? 'rotate-45 text-blue-600' : ''" class="transition-transform duration-200">+</span>
                        </button>
                        <div x-show="open" x-collapse class="border-t border-gray-100 p-5 text-sm text-gray-600 font-light">
                            Standard delivery takes 3-5 business days across major networks.
                        </div>
                    </div>
                </div>

                <!-- 2. UNIFORMS CONTENT -->
                <div x-show="activeCategory === 'uniforms'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-2"
                     class="space-y-4" 
                     style="display: none;"> {{-- Blade starting hidden setting --}}
                    <h2 class="text-xl font-black text-gray-950 uppercase tracking-tight mb-6 border-b border-gray-100 pb-2">Uniform Sizing & Fabric</h2>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-xl overflow-hidden bg-white shadow-sm">
                        <button @click="open = !open" class="w-full flex items-center justify-between p-5 text-left font-bold text-sm uppercase text-gray-950 bg-gray-50/50">
                            <span>What if the ordered school uniform does not fit properly?</span>
                            <span :class="open ? 'rotate-45 text-blue-600' : ''" class="transition-transform duration-200">+</span>
                        </button>
                        <div x-show="open" x-collapse class="border-t border-gray-100 p-5 text-sm text-gray-600 font-light">
                            We offer a complete free size-exchange within 7 days of physical delivery. Fabric must be unworn and unwashed.
                        </div>
                    </div>
                </div>

                <!-- 3. BOOKS CONTENT -->
                <div x-show="activeCategory === 'books'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-2"
                     class="space-y-4" 
                     style="display: none;">
                    <h2 class="text-xl font-black text-gray-950 uppercase tracking-tight mb-6 border-b border-gray-100 pb-2">Curriculum & Book Bundles</h2>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-xl overflow-hidden bg-white shadow-sm">
                        <button @click="open = !open" class="w-full flex items-center justify-between p-5 text-left font-bold text-sm uppercase text-gray-950 bg-gray-50/50">
                            <span>Are these textbooks verified by the official school systems?</span>
                            <span :class="open ? 'rotate-45 text-blue-600' : ''" class="transition-transform duration-200">+</span>
                        </button>
                        <div x-show="open" x-collapse class="border-t border-gray-100 p-5 text-sm text-gray-600 font-light">
                            Yes, all bundles directly align with the explicit institutional syllabus guidelines.
                        </div>
                    </div>
                </div>

                <!-- 4. PAYMENTS CONTENT -->
                <div x-show="activeCategory === 'payments'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-2"
                     class="space-y-4" 
                     style="display: none;">
                    <h2 class="text-xl font-black text-gray-950 uppercase tracking-tight mb-6 border-b border-gray-100 pb-2">Payments & Refunds</h2>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-xl overflow-hidden bg-white shadow-sm">
                        <button @click="open = !open" class="w-full flex items-center justify-between p-5 text-left font-bold text-sm uppercase text-gray-950 bg-gray-50/50">
                            <span>What modes of payment are accepted?</span>
                            <span :class="open ? 'rotate-45 text-blue-600' : ''" class="transition-transform duration-200">+</span>
                        </button>
                        <div x-show="open" x-collapse class="border-t border-gray-100 p-5 text-sm text-gray-600 font-light">
                            We accept Cash on Delivery (COD), Direct Bank Transfers, EasyPaisa, and JazzCash.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection