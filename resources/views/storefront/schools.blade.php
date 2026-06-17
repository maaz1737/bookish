@extends('layouts.app')

@section('content')
    <!-- Header Section -->
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-3xl p-10 mb-12">

        <div class="max-w-3xl">

            <h1 class="text-4xl font-bold mb-4">
                Browse Schools
            </h1>

            <p class="text-lg opacity-90">
                Select your school and find class-wise books, uniforms,
                accessories and complete academic bundles.
            </p>

        </div>

    </section>


    <!-- Search Bar -->
    <div class="bg-white rounded-2xl shadow p-5 mb-10">

        <div class="relative">

            <input id="search" type="text" placeholder="Search School..."
                class="w-full border border-gray-200 rounded-xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-indigo-500">

        </div>

    </div>


    <!-- Schools Grid -->

    <div id="con" class=" grid md:grid-cols-2 lg:grid-cols-3 gap-8">

        @foreach ($schools as $school)
            <a href="{{ route('schools.show', $school) }}"
                class="group bg-white rounded-3xl shadow-sm hover:shadow-2xl transition duration-300 overflow-hidden">

                <!-- Top Banner -->
                <div class="h-28 bg-gradient-to-r from-indigo-500 to-purple-500 relative">

                    <div class="absolute left-6 bottom-[-30px]">

                        <div class="w-16 h-16 rounded-full bg-white shadow-lg flex items-center justify-center text-3xl">
                            🏫
                        </div>

                    </div>

                </div>

                <!-- Content -->
                <div class="p-6 pt-10">

                    <h2 class="school-name text-xl font-bold text-gray-800 group-hover:text-indigo-600 transition">
                        {{ $school->name }}
                    </h2>

                    <div class="mt-4 flex items-center justify-between">

                        <span class="text-sm text-gray-500">
                            {{ $school->classes_count }} Classes
                        </span>

                        <span class="text-indigo-600 font-semibold">
                            View →
                        </span>

                    </div>

                </div>

            </a>
        @endforeach

    </div>


    <!-- Empty State -->

    @if ($schools->count() == 0)
        <div class="bg-white rounded-2xl shadow p-12 text-center">

            <div class="text-6xl mb-4">
                🏫
            </div>

            <h3 class="text-xl font-bold mb-2">
                No Schools Found
            </h3>

            <p class="text-gray-500">
                Schools will appear here once added by the administrator.
            </p>

        </div>
    @endif


    <!-- Bottom CTA -->

    <section class="mt-16">

        <div class="bg-indigo-600 text-white rounded-3xl p-10 text-center">

            <h2 class="text-3xl font-bold mb-3">
                Can't Find Your School?
            </h2>

            <p class="opacity-90 mb-6">
                Contact us and we'll add your school's books and bundles.
            </p>

            <a href="#" class="inline-block bg-white text-indigo-600 px-6 py-3 rounded-xl font-semibold">
                Contact Us
            </a>

        </div>

    </section>

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
