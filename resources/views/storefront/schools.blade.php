@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 sm:py-8">

    <!-- Header Section -->
    <section class="relative bg-gradient-to-r from-slate-900 via-indigo-900 to-slate-950 text-white rounded-2xl overflow-hidden p-6 sm:p-10 md:p-12 mb-8 shadow-md">
        {{-- Background glowing circles --}}
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-indigo-500 rounded-full blur-3xl opacity-20 pointer-events-none"></div>
        <div class="absolute -bottom-10 -right-10 w-52 h-52 bg-purple-500 rounded-full blur-3xl opacity-35 pointer-events-none"></div>
        
        <div class="max-w-2xl relative z-10">
            <span class="inline-block bg-yellow-400 text-slate-900 text-[10px] font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-wider">Academic Bundles</span>
            <h1 class="text-2xl sm:text-4xl font-extrabold mb-3 leading-tight">
                Browse Schools
            </h1>
            <p class="text-sm sm:text-base text-slate-300 leading-relaxed max-w-xl">
                Select your school and find class-wise books, uniforms, accessories, and complete academic bundles curated specifically for your curriculum.
            </p>
        </div>
    </section>

    <!-- Search Bar -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-5 mb-8">
        <div class="relative max-w-md">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input id="search" type="text" placeholder="Search school name..."
                class="w-full border border-slate-200 bg-slate-50 rounded-xl pl-10 pr-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
        </div>
    </div>

    <!-- Schools Grid -->
    <div id="con" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        @foreach ($schools as $school)
            <a href="{{ route('schools.show', $school) }}"
                class="group bg-white rounded-2xl border border-slate-200 hover:border-indigo-300 shadow-sm hover:shadow-md transition duration-300 overflow-hidden flex flex-col justify-between">
                
                <!-- Top Banner -->
                <div class="h-20 bg-gradient-to-r from-blue-500 to-indigo-600 relative">
                    <div class="absolute left-4 bottom-[-24px]">
                        <div class="w-12 h-12 rounded-xl bg-white shadow flex items-center justify-center text-2xl border border-slate-100 group-hover:scale-110 transition duration-300">
                            🏫
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4 pt-8 flex-1 flex flex-col justify-between">
                    <div>
                        <h2 class="school-name text-sm sm:text-base font-bold text-[#0B1B47] group-hover:text-indigo-600 transition line-clamp-2 min-h-[40px] leading-tight">
                            {{ $school->name }}
                        </h2>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs text-slate-500 font-medium bg-slate-100 px-2 py-0.5 rounded">
                            {{ $school->classes_count }} {{ Str::plural('Class', $school->classes_count) }}
                        </span>
                        <span class="text-indigo-600 text-xs font-semibold group-hover:translate-x-1 transition duration-150 flex items-center gap-0.5">
                            View <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Empty State -->
    @if ($schools->count() == 0)
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center max-w-md mx-auto mt-8">
            <div class="text-5xl mb-4">🏫</div>
            <h3 class="text-lg font-bold text-[#0B1B47] mb-1">No Schools Found</h3>
            <p class="text-slate-500 text-sm">
                Schools will appear here once added by the administrator.
            </p>
        </div>
    @endif

    <!-- Bottom CTA -->
    <section class="mt-12 sm:mt-16">
        <div class="bg-gradient-to-br from-indigo-900 to-indigo-950 text-white rounded-2xl p-6 sm:p-10 text-center relative overflow-hidden shadow-sm">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
            <div class="relative z-10 max-w-lg mx-auto">
                <h2 class="text-xl sm:text-3xl font-extrabold mb-3">
                    Can't Find Your School?
                </h2>
                <p class="text-sm text-indigo-200 mb-6 max-w-md mx-auto leading-relaxed">
                    Contact our support team and we will quickly add your school's official booklists and uniform bundles.
                </p>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-300 text-blue-900 font-bold px-6 py-3 rounded-xl text-sm transition shadow shadow-yellow-950/20">
                    <i class="fa-solid fa-envelope text-sm"></i> Contact Us
                </a>
            </div>
        </div>
    </section>

</div>

<script>
    $('#search').on('keyup', function() {
        let value = $(this).val().toLowerCase();

        $('#con > a').each(function() {
            let schoolName = $(this).find('.school-name').text().toLowerCase();

            $(this).toggle(schoolName.includes(value));
        });
    });
</script>
@endsection
