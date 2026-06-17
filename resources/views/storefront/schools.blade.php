@extends('layouts.app')

@section('content')
    <!-- Header Section -->
    <section
        class="bg-gradient-to-br from-indigo-700 via-indigo-600 to-purple-700 text-white rounded-3xl p-8 sm:p-12 mb-12 shadow-xl relative overflow-hidden">
        <div class="absolute right-0 top-0 opacity-10 translate-x-10 -translate-y-10 pointer-events-none">
            <span class="text-[200px] font-bold">🏫</span>
        </div>
        <div class="max-w-3xl relative z-10">
            <span
                class="bg-indigo-500/30 text-yellow-300 text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full w-fit mb-4 backdrop-blur-sm inline-block">
                Syllabus & Uniforms
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold mb-4 tracking-tight">
                Browse Registered Schools
            </h1>
            <p class="text-base sm:text-lg text-indigo-100 opacity-90 leading-relaxed">
                Select your school and instantly find class-wise books, customized uniforms, stationery accessories, and
                complete academic bundles.
            </p>
        </div>
    </section>

    <!-- Search Bar -->
    <div
        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-5 mb-10 transition-all duration-300 hover:shadow-md">
        <div class="relative max-w-xl">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input id="search" type="text" placeholder="Type school name to filter..."
                class="w-full border border-gray-200 rounded-xl pl-12 pr-5 py-3.5 bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-700">
        </div>
    </div>

    <!-- Schools Grid -->
    <div id="con" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($schools as $school)
            <a href="{{ route('schools.show', $school) }}"
                class="group bg-white rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 border border-gray-100 transition-all duration-300 overflow-hidden flex flex-col justify-between">

                <div>
                    <!-- Top Banner with Dynamic CSS Pattern overlay -->
                    <div
                        class="h-28 bg-gradient-to-tr from-indigo-600 via-indigo-500 to-purple-600 relative overflow-hidden">
                        <div
                            class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]">
                        </div>
                        <!-- Logo Container -->
                        <div class="absolute left-6 bottom-[-24px]">
                            <div
                                class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center text-3xl border border-gray-50 transform group-hover:scale-105 transition-transform duration-300">
                                🏫
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 pt-10">
                        <h2
                            class="school-name text-xl font-bold text-gray-800 group-hover:text-indigo-600 transition-colors duration-200 line-clamp-1">
                            {{ $school->name }}
                        </h2>
                        <p class="text-gray-400 text-xs mt-1 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Verified Partner School
                        </p>
                    </div>
                </div>

                <!-- Footer area of card -->
                <div class="px-6 pb-6 pt-2 flex items-center justify-between border-t border-gray-50">
                    <span
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100/50">
                        📦 {{ $school->classes_count ?? 0 }} Classes
                    </span>

                    <span
                        class="text-indigo-600 font-bold text-sm flex items-center gap-1 group-hover:text-indigo-800 transition-colors">
                        Get Bundles <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                    </span>
                </div>

            </a>
        @endforeach
    </div>

    <!-- JS Search Dynamic Empty State (Hidden by default) -->
    <div id="js-empty-state" class="hidden bg-white rounded-3xl border border-gray-100 p-12 text-center shadow-sm">
        <div class="text-5xl mb-4">🔍</div>
        <h3 class="text-xl font-bold text-gray-800 mb-1">No Matching Schools</h3>
        <p class="text-gray-500 max-w-xs mx-auto text-sm">
            We couldn't find any school matching your search term. Double check spelling or request us below.
        </p>
    </div>

    <!-- Backend Empty State (If DB is empty) -->
    @if ($schools->count() == 0)
        <div class="bg-white rounded-3xl border border-gray-100 p-12 text-center shadow-sm">
            <div class="text-5xl mb-4">🏫</div>
            <h3 class="text-xl font-bold text-gray-800 mb-1">No Schools Listed Yet</h3>
            <p class="text-gray-500 text-sm">
                Schools will appear here once onboarded by the administrator.
            </p>
        </div>
    @endif

    <!-- Bottom CTA -->
    <section class="mt-20">
        <div
            class="bg-gradient-to-br from-gray-900 to-indigo-950 text-white rounded-3xl p-8 sm:p-12 text-center shadow-xl relative overflow-hidden">
            <div class="absolute -left-10 -bottom-10 opacity-5 pointer-events-none">
                <span class="text-[150px]">📦</span>
            </div>
            <div class="relative z-10 max-w-xl mx-auto">
                <h2 class="text-2xl sm:text-3xl font-extrabold mb-3 tracking-tight">
                    Can't Find Your School?
                </h2>
                <p class="text-gray-300 opacity-90 mb-8 text-sm sm:text-base">
                    Drop us a request with your school's booklist, and our procurement team will arrange everything for you.
                </p>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center justify-center bg-white text-indigo-950 px-6 py-3.5 rounded-xl font-bold hover:bg-indigo-50 hover:-translate-y-0.5 transition-all duration-200 transform shadow-md">
                    Submit School Request
                </a>
            </div>
        </div>
    </section>

    <!-- jQuery Real-time Filter Script -->
    <script>
        $('#search').on('keyup', function() {
            let value = $(this).val().toLowerCase().trim();
            let visibleCards = 0;

            $('#con > a').each(function() {
                let schoolName = $(this).find('.school-name').text().toLowerCase();
                let matches = schoolName.includes(value);

                $(this).toggle(matches);
                if (matches) visibleCards++;
            });

            // Agar koi card match na ho toh real-time empty state show karein
            if (visibleCards === 0 && value !== '') {
                $('#js-empty-state').removeClass('hidden');
            } else {
                $('#js-empty-state').addClass('hidden');
            }
        });
    </script>
@endsection
