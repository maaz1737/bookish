@extends('layouts.app') {{-- Change to 'storefront.layouts.app' if your master layout is there --}}

@section('title', 'Returns, Exchange & Refunds Policy - Bookish & Beyond')

@section('content')
<div class="bg-white min-h-screen font-sans text-gray-900 selection:bg-black selection:text-white">

    {{-- <div class="relative bg-gray-950 min-h-[320px] flex items-center justify-center px-4 overflow-hidden border-b border-gray-200">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80&w=2000" 
                 alt="Premium Box Logistics Setup" 
                 class="w-full h-full object-cover opacity-15 object-center filter contrast-125 brightness-50">
            <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-black/40 to-black/80"></div>
        </div>

        <div class="relative max-w-4xl mx-auto text-center z-10 py-8">
            <span class="text-blue-400 text-xs font-bold tracking-[0.3em] uppercase mb-3 block">100% Buyer Protection Guarantee</span>
            <h1 class="text-4xl sm:text-5xl font-black text-white tracking-tight uppercase leading-none mb-4">
                Returns & Exchange Policy
            </h1>
            <div class="w-16 h-[2px] bg-white mx-auto my-4 opacity-70"></div>
            <p class="max-w-xl mx-auto text-xs sm:text-sm text-gray-300 font-serif italic leading-relaxed">
                We understand that sizes can vary and requirements can change. Here is our completely transparent roadmap to hassle-free returns and instant cash reversals.
            </p>
        </div>
    </div> --}}

    <!-- Premium Editorial Split-Grid Hero Section -->
    <div class="relative bg-gray-950 min-h-[440px] flex items-center border-b border-gray-200 overflow-hidden">
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
                            Fulfillment Integrity Matrix
                        </span>
                    </div>
                    
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-white tracking-tight uppercase leading-[0.95]">
                        Returns & <br class="hidden md:inline">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-200 to-gray-500">Reimbursement</span>
                    </h1>
                    
                    <div class="w-20 h-[3px] bg-gradient-to-r from-blue-600 to-transparent"></div>
                    
                    <p class="max-w-xl text-sm sm:text-base text-gray-400 font-serif italic leading-relaxed">
                        Our simplified, professional framework engineered for premium size exchanges, automated reverse packaging collections, and instantaneous payment reversals.
                    </p>

                    <!-- Real-Time Trust Badges Stack -->
                    <div class="pt-4 flex flex-wrap gap-4 items-center text-[10px] font-mono uppercase tracking-widest text-gray-400 border-t border-gray-900 w-fit">
                        <div class="flex items-center gap-2 bg-gray-900/60 px-3 py-1.5 rounded-md border border-gray-800">
                            <span class="text-emerald-500">✓</span> Verified Purchaser Protection
                        </div>
                        <div class="flex items-center gap-2 bg-gray-900/60 px-3 py-1.5 rounded-md border border-gray-800">
                            <span class="text-emerald-500">✓</span> 7-Day Window Assurance
                        </div>
                    </div>
                </div>

                <!-- Right Column: Immersive Asymmetric Grid Media Frame -->
                <div class="lg:col-span-5 relative hidden lg:block">
                    <!-- Layer 1: Geometric Visual Accent -->
                    <div class="absolute -inset-4 bg-gradient-to-tr from-blue-600/10 to-transparent rounded-2xl blur-xl opacity-50"></div>
                    
                    <!-- Layer 2: Main Curated Packaging Frame -->
                    <div class="relative border border-gray-800 bg-gray-900 p-3 rounded-2xl shadow-2xl overflow-hidden group">
                        <div class="relative h-[280px] rounded-xl overflow-hidden bg-gray-950">
                            <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&q=80&w=1000" 
                                 alt="Premium Curated Delivery Return Box" 
                                 class="w-full h-full object-cover opacity-60 transform scale-100 transition-transform duration-[1500ms] ease-out group-hover:scale-105 filter contrast-110 brightness-90">
                            
                            <!-- Internal Ambient Lighting Blur Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-transparent to-transparent"></div>
                            
                            <!-- Interactive Live Floating Analytics Badge -->
                            <div class="absolute bottom-4 left-4 right-4 bg-gray-950/80 backdrop-blur-md border border-gray-800 p-3 rounded-lg flex items-center justify-between">
                                <div>
                                    <p class="text-[9px] font-mono uppercase text-gray-500 tracking-wider">Average Reversal Metric</p>
                                    <p class="text-xs font-bold text-white mt-0.5">48 Hours Settlement Window</p>
                                </div>
                                <span class="bg-blue-600 text-white text-[10px] font-mono px-2 py-1 rounded font-bold">
                                    LIVE
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Layer 3: Accent Secondary Micro-Badge Grid -->
                    <div class="absolute -top-6 -right-6 bg-white text-gray-950 font-black text-[11px] font-mono tracking-tighter w-24 h-24 rounded-full flex flex-col items-center justify-center border-4 border-gray-950 shadow-2xl uppercase text-center p-2 transform rotate-12 group-hover:rotate-0 transition-transform duration-500">
                        <span>100%<br>Secure</span>
                    </div>
                </div>

            </div>
        </div>
    </div>





    <div class="max-w-7xl mx-auto pt-16 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-6 text-center">
            <div class="border border-gray-100 p-6 rounded-xl bg-gray-50/50">
                <div class="text-blue-600 text-2xl mb-1">🔄</div>
                <p class="text-xs uppercase tracking-wider font-bold text-gray-950">7-Day Return</p>
                <p class="text-gray-500 text-xs font-light mt-1">Easy claims within 7 days.</p>
            </div>
            <div class="border border-gray-100 p-6 rounded-xl bg-gray-50/50">
                <div class="text-blue-600 text-2xl mb-1">👚</div>
                <p class="text-xs uppercase tracking-wider font-bold text-gray-950">Free Size Exchange</p>
                <p class="text-gray-500 text-xs font-light mt-1">Wrong fit? We will swap it.</p>
            </div>
            <div class="border border-gray-100 p-6 rounded-xl bg-gray-50/50">
                <div class="text-blue-600 text-2xl mb-1">💰</div>
                <p class="text-xs uppercase tracking-wider font-bold text-gray-950">Direct Refund</p>
                <p class="text-gray-500 text-xs font-light mt-1">Bank, EasyPaisa or JazzCash.</p>
            </div>
            <div class="border border-gray-100 p-6 rounded-xl bg-gray-50/50">
                <div class="text-blue-600 text-2xl mb-1">📦</div>
                <p class="text-xs uppercase tracking-wider font-bold text-gray-950">Home Pickup</p>
                <p class="text-gray-500 text-xs font-light mt-1">Available in selected sectors.</p>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-20">
            <h2 class="text-2xl font-black text-gray-950 uppercase tracking-tight text-center mb-12">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <div class="relative flex flex-col items-center text-center p-4">
                    <span class="w-12 h-12 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-lg shadow-md mb-4">1</span>
                    <h3 class="text-lg font-bold text-gray-950 uppercase tracking-tight mb-2">File a Request</h3>
                    <p class="text-sm text-gray-500 font-light">Email us at <span class="text-blue-600 font-medium">returns@bookishandbeyond.com</span> or WhatsApp us with your Order ID & pictures of the item.</p>
                </div>
                <div class="relative flex flex-col items-center text-center p-4">
                    <span class="w-12 h-12 rounded-full bg-gray-950 text-white font-bold flex items-center justify-center text-lg shadow-md mb-4">2</span>
                    <h3 class="text-lg font-bold text-gray-950 uppercase tracking-tight mb-2">Ship Back / Pickup</h3>
                    <p class="text-sm text-gray-500 font-light">Send the product back via any local courier (TCS, Leopard, Post Office) to our Kasur Fulfillment Hub.</p>
                </div>
                <div class="relative flex flex-col items-center text-center p-4">
                    <span class="w-12 h-12 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-lg shadow-md mb-4">3</span>
                    <h3 class="text-lg font-bold text-gray-950 uppercase tracking-tight mb-2">Instant Cash Reversal</h3>
                    <p class="text-sm text-gray-500 font-light">Once quality inspection is approved, your refund is processed into your account within 48 business hours.</p>
                </div>
            </div>
        </div>

        <div class="mb-20">
            <h2 class="text-2xl font-black text-gray-950 uppercase tracking-tight mb-6">Item-Wise Return Policy Matrix</h2>
            <div class="overflow-x-auto border border-gray-200 rounded-xl shadow-sm">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs font-bold uppercase tracking-wider text-gray-700">
                            <th class="p-4">Product Category</th>
                            <th class="p-4">Returnable?</th>
                            <th class="p-4">Condition Required</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-600 font-light divide-y divide-gray-100">
                        <tr>
                            <td class="p-4 font-medium text-gray-900">School Uniforms & Blazers</td>
                            <td class="p-4"><span class="px-2 py-0.5 bg-green-50 text-green-700 font-medium rounded text-xs">Yes (7 Days)</span></td>
                            <td class="p-4">Unwashed, unworn, original tags must be attached. No stains or perfume smells.</td>
                        </tr>
                        <tr>
                            <td class="p-4 font-medium text-gray-900">Textbooks & Notebooks</td>
                            <td class="p-4"><span class="px-2 py-0.5 bg-green-50 text-green-700 font-medium rounded text-xs">Yes (7 Days)</span></td>
                            <td class="p-4">No missing pages, no names written, no folds, bindings must be completely untampered.</td>
                        </tr>
                        <tr>
                            <td class="p-4 font-medium text-gray-900">Stationery Gears & Geometry Sets</td>
                            <td class="p-4"><span class="px-2 py-0.5 bg-green-50 text-green-700 font-medium rounded text-xs">Yes (7 Days)</span></td>
                            <td class="p-4">Must be in original blister packaging. Opened seal stationery is non-returnable.</td>
                        </tr>
                        <tr>
                            <td class="p-4 font-medium text-gray-900">Customized Badges / School Ribbons</td>
                            <td class="p-4"><span class="px-2 py-0.5 bg-red-50 text-red-700 font-medium rounded text-xs">No</span></td>
                            <td class="p-4">Custom-made or tailor-modified items specific to individual students cannot be returned.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-8 text-gray-600 font-light leading-relaxed mb-20 border-t border-gray-100 pt-12">
            <div>
                <h3 class="text-lg font-bold text-gray-950 uppercase tracking-tight mb-2">Non-Refundable Scenarios</h3>
                <p class="text-sm">
                    Please note that refunds will not be issued if:
                </p>
                <ul class="list-disc pl-5 mt-2 space-y-1 text-sm">
                    <li>The item is reported after 7 days from the date of physical delivery.</li>
                    <li>The uniform has been altered or stitched by an outside tailor.</li>
                    <li>Items are damaged due to rough handling or improper washing after delivery.</li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-bold text-gray-950 uppercase tracking-tight mb-2">Shipping Fee Policy</h3>
                <p class="text-sm">
                    If you received a <strong>damaged, wrong product, or incorrect size variation</strong> from our end, <span class="font-medium text-gray-900">Bookish & Beyond will bear 100% of the return shipping charges</span>. However, if you want an exchange due to a change of mind or subjective reason, the customer will be responsible for routing the item back to our hub.
                </p>
            </div>
        </div>

        <div class="bg-gray-950 text-white p-8 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
            <div>
                <span class="text-blue-400 text-xs font-mono uppercase tracking-widest">Immediate Response Matrix</span>
                <h4 class="text-xl font-bold uppercase tracking-tight mt-1">Need an Instant Exchange or Size Change?</h4>
                <p class="text-xs text-gray-400 font-light mt-0.5">Our specialized customer support desk is operational to guide you through reverse logistics.</p>
            </div>
            <div class="flex items-center gap-4 shrink-0 w-full md:w-auto">
                <a href="https://wa.me/923001234567" target="_blank" class="w-full md:w-auto text-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs uppercase tracking-widest font-bold rounded transition-all duration-300 shadow-md">
                    WhatsApp Help
                </a>
                <a href="mailto:returns@bookishandbeyond.com" class="w-full md:w-auto text-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs uppercase tracking-widest font-bold rounded transition-all duration-300 shadow-md">
                    Open Ticket
                </a>
            </div>
        </div>

    </div>
</div>
@endsection