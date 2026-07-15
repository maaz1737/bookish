@extends('layouts.app')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="text-sm text-slate-500 mb-8 flex items-center gap-2">
        <a href="{{ url('/') }}" class="hover:text-navy-600 transition-colors">Home</a>
        <span class="text-slate-400">/</span>
        <span class="text-slate-800 font-medium">Schools</span>
    </nav>

    <!-- Browse Schools Title Section -->
    <div class="flex items-start gap-4 mb-10">
        <!-- Custom School building SVG icon in orange outline -->
        <div class="w-16 h-16 rounded-2xl bg-orange-50/60 border border-orange-100 flex items-center justify-center shrink-0">
            <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11 stroke-[#e06c00] fill-none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <!-- Flag & Pole -->
                <path d="M32 4v8M32 4l9 3.5-9 3.5" />
                <!-- Main Center Tower -->
                <path d="M26 12h12v40H26V12z" />
                <!-- Triangle Roof for Center Tower -->
                <path d="M24 12l8-7 8 7" />
                <!-- Left Wing -->
                <path d="M8 24h18v28H8V24z" />
                <!-- Right Wing -->
                <path d="M38 24h18v28H38V24z" />
                <!-- Center Clock/Circle -->
                <circle cx="32" cy="20" r="3" />
                <!-- Main Door -->
                <path d="M29 52V44h6v8" />
                <!-- Windows Left Wing -->
                <rect x="12" y="28" width="4" height="6" rx="1" />
                <rect x="20" y="28" width="4" height="6" rx="1" />
                <rect x="12" y="38" width="4" height="6" rx="1" />
                <rect x="20" y="38" width="4" height="6" rx="1" />
                <!-- Windows Right Wing -->
                <rect x="40" y="28" width="4" height="6" rx="1" />
                <rect x="48" y="28" width="4" height="6" rx="1" />
                <rect x="40" y="38" width="4" height="6" rx="1" />
                <rect x="48" y="38" width="4" height="6" rx="1" />
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-extrabold text-navy-800 tracking-tight">
                Browse Schools
            </h1>
            <p class="text-slate-500 mt-1.5 text-base">
                Select your school for books, uniforms, accessories, and bundles.
            </p>
        </div>
    </div>

    <!-- Schools Grid -->
    <div id="con" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($schools as $school)
            <a href="{{ route('schools.show', $school) }}"
                class="group bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_12px_45px_rgb(0,0,0,0.06)] hover:-translate-y-0.5 transition-all duration-300 p-6 flex flex-col justify-between">
                
                <div class="flex items-center gap-5">
                    <!-- School Logo Container -->
                    <div class="w-20 h-20 rounded-2xl border border-slate-100 flex items-center justify-center bg-white p-3 shrink-0 shadow-sm">
                        @if ($school->logo)
                            <img src="{{ asset('storage/' . $school->logo) }}" 
                                 class="max-w-full max-h-full object-contain" 
                                 alt="{{ $school->name }}">
                        @else
                            <i class="fa-solid fa-school text-3xl text-navy-600"></i>
                        @endif
                    </div>
                    
                    <!-- School Info -->
                    <div>
                        <h2 class="school-name text-lg font-bold text-navy-800 leading-tight group-hover:text-blue-900 transition-colors duration-200">
                            {{ $school->name }}
                        </h2>
                        <p class="text-sm text-slate-400 mt-1 font-medium">
                            {{ $school->description ?: 'Shop books, uniforms & essentials' }}
                        </p>
                    </div>
                </div>

                <!-- Explore Now Button -->
                <div class="mt-8">
                    <div class="w-full bg-[#0a1a3d] text-white py-3.5 px-4 rounded-xl text-sm font-semibold transition-all duration-300 group-hover:bg-[#1e3a8a] flex items-center justify-center gap-2 shadow-sm">
                        Explore Now <span class="group-hover:translate-x-1.5 transition-transform duration-300">&rarr;</span>
                    </div>
                </div>

            </a>
        @endforeach
    </div>

    <!-- Empty State -->
    @if ($schools->count() == 0)
        <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] p-16 text-center max-w-lg mx-auto">
            <div class="text-5xl mb-4">🏫</div>
            <h3 class="text-xl font-bold text-navy-800 mb-2">No Schools Found</h3>
            <p class="text-slate-500">Schools will appear here once added by the administrator.</p>
        </div>
    @endif

    <!-- Bottom Contact Section -->
    <div class="mt-16 bg-[#f0f4fa]/60 border border-blue-100/50 rounded-3xl p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
            <!-- Headset support icon in a circular container -->
            <div class="w-14 h-14 rounded-full bg-white shadow-sm border border-blue-100 flex items-center justify-center text-navy-800 shrink-0">
                <i class="fa-solid fa-headset text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-navy-800">
                    Can't Find Your School?
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    Contact us and we'll help you find your school's books and bundles.
                </p>
            </div>
        </div>
        <!-- Contact Us Button -->
        <a href="#" class="shrink-0 flex items-center gap-2 bg-[#0a1a3d] hover:bg-[#1e3a8a] text-white px-6 py-3.5 rounded-xl text-sm font-semibold shadow-sm transition-colors duration-300">
            <i class="fa-regular fa-envelope text-base"></i>
            Contact Us
        </a>
    </div>
        {{-- ===== TRUST / BENEFITS STRIP ===== --}}

    @include('partials.trust-section')
@endsection