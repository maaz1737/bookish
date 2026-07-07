@extends('layouts.app')

@section('content')

    {{-- ===== BREADCRUMB ===== --}}
    <nav class="text-xs text-slate-500 mb-6 flex items-center gap-2 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-[#001F54] transition-colors">Home</a>
        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
        <span class="text-[#001F54] font-semibold">Contact Us</span>
    </nav>

    {{-- ===== HERO BANNER ===== --}}
    <section class="relative overflow-hidden bg-gradient-to-r from-slate-50 via-slate-100 to-indigo-50/50 border border-slate-200/60 rounded-[24px] shadow-sm mb-12 p-8 md:p-12">
        <div class="grid md:grid-cols-12 items-center gap-8 relative z-10">
            <div class="md:col-span-7 flex flex-col justify-center">
                <h1 class="text-4xl md:text-5xl font-extrabold text-[#001F54] leading-tight tracking-tight">
                    Contact <span class="text-[#ff7a00]">Us</span>
                </h1>
                <p class="text-slate-600 text-sm md:text-base mt-4 max-w-xl leading-relaxed">
                    We're here to help you with school essentials, uniforms, gifts, and order-related queries.
                </p>
            </div>

            <div class="md:col-span-5 flex justify-center md:justify-end">
                <img src="{{ url('storage/contact_hero_collage.png') }}" 
                     alt="Contact Us Essentials" 
                     class="max-h-60 md:max-h-68 object-contain drop-shadow-lg hover:scale-[1.02] transition-transform duration-500 rounded-2xl">
            </div>
        </div>
        <div class="absolute -top-12 -right-12 w-64 h-64 bg-gradient-to-br from-[#001F54]/5 to-transparent rounded-full pointer-events-none"></div>
    </section>

    {{-- ===== CONTACT INFORMATION SECTION ===== --}}
    <section class="mb-14">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-extrabold text-[#001F54] tracking-tight">Contact Information</h2>
            <div class="w-12 h-1 bg-[#ff7a00] mx-auto mt-3 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Card 1: Store & Address --}}
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,31,84,0.03)] flex flex-col items-center text-center group hover:shadow-[0_8px_30px_rgba(0,31,84,0.06)] transition-all duration-300">
                <div class="w-16 h-16 rounded-2xl bg-[#001F54]/5 text-[#001F54] flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-store text-2xl"></i>
                </div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Store &amp; Address</span>
                <h3 class="font-extrabold text-[#001F54] text-lg mb-2">Bookish &amp; Beyond</h3>
                <p class="text-slate-500 text-sm leading-relaxed max-w-xs">
                    Shop #3, Welfare Market, Sarwar Road, Lahore Cantt.
                </p>
            </div>

            {{-- Card 2: Call Us --}}
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,31,84,0.03)] flex flex-col items-center text-center group hover:shadow-[0_8px_30px_rgba(0,31,84,0.06)] transition-all duration-300">
                <div class="w-16 h-16 rounded-2xl bg-[#001F54]/5 text-[#001F54] flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-phone text-2xl"></i>
                </div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Call Us</span>
                <a href="tel:03204735908" class="font-extrabold text-[#001F54] text-xl mb-2 hover:text-[#ff7a00] transition-colors">
                    0320-4735908
                </a>
                <p class="text-slate-500 text-sm">Mon-Sat from 10am to 8pm.</p>
            </div>

            {{-- Card 3: Business Hours --}}
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,31,84,0.03)] flex flex-col items-center text-center group hover:shadow-[0_8px_30px_rgba(0,31,84,0.06)] transition-all duration-300">
                <div class="w-16 h-16 rounded-2xl bg-[#001F54]/5 text-[#001F54] flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-clock text-2xl"></i>
                </div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Business Hours</span>
                <div class="text-slate-500 text-sm leading-relaxed">
                    <span class="block">Monday to Saturday:</span>
                    <strong class="text-[#001F54] font-bold block text-base my-1">10:00 AM – 8:00 PM</strong>
                    <span class="block text-slate-400 text-xs">Sunday: Closed</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== OUR LOCATION SECTION ===== --}}
    <section class="mb-14">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-extrabold text-[#001F54] tracking-tight">Our Location</h2>
            <div class="w-12 h-1 bg-[#ff7a00] mx-auto mt-3 rounded-full"></div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(0,31,84,0.03)] p-6 md:p-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                {{-- Left details --}}
                <div class="lg:col-span-5 flex flex-col gap-4">
                    <div class="w-12 h-12 rounded-xl bg-[#ff7a00]/10 text-[#ff7a00] flex items-center justify-center">
                        <i class="fa-solid fa-location-dot text-xl"></i>
                    </div>
                    <h3 class="font-extrabold text-[#001F54] text-xl leading-tight">Visit Our Store</h3>
                    <p class="text-slate-500 text-sm md:text-base leading-relaxed">
                        Shop #3, Welfare Market, Sarwar Road, Lahore Cantt.
                    </p>
                    <a href="https://maps.google.com/?q=Shop+%233,+Welfare+Market,+Sarwar+Road,+Lahore+Cantt" 
                       target="_blank" 
                       class="inline-flex items-center gap-2 text-sm font-extrabold text-[#001F54] hover:text-[#ff7a00] transition-colors mt-2">
                        Get Directions <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    </a>
                </div>

                {{-- Right interactive map --}}
                <div class="lg:col-span-7 rounded-xl overflow-hidden border border-slate-100 shadow-sm h-64 md:h-80 relative">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3401.7610427845347!2d74.379109015147!3d31.50325498137357!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391905fb55555555%3A0x2424855555555555!2sSarwar%20Road%2C%20Lahore%20Cantt!5e0!3m2!1sen!2spk!4v1625680000000!5m2!1sen!2spk" 
                        class="w-full h-full border-0" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

@endsection