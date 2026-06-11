@extends('layouts.app')

@section('content')

    <!-- School Header -->
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-3xl p-10 mb-10">

        <div class="flex items-center gap-5">

            <div class="w-20 h-20 bg-white text-indigo-600 rounded-full flex items-center justify-center text-4xl shadow-lg">
                🏫
            </div>

            <div>
                <h1 class="text-4xl font-bold">
                    {{ $school->name }}
                </h1>

                <p class="mt-2 text-indigo-100">
                    Select a class to view books, bundles, uniforms and accessories.
                </p>

                <div class="mt-3 inline-flex items-center bg-white/20 px-4 py-2 rounded-full text-sm">
                    {{ $school->classes->count() }} Classes Available
                </div>
            </div>

        </div>

    </section>


    <!-- Classes Section -->

    @if ($school->classes->count())
        <div class="flex items-center justify-between mb-8">

            <h2 class="text-3xl font-bold text-gray-800">
                Available Classes
            </h2>

            <span class="text-gray-500">
                {{ $school->classes->count() }} Classes
            </span>

        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach ($school->classes as $class)
                <a href="{{ route('bundle.show', [$school, $class->slug]) }}"
                    class="group bg-white rounded-3xl shadow-sm hover:shadow-2xl transition duration-300 overflow-hidden">

                    <!-- Top Banner -->
                    <div class="h-24 bg-gradient-to-r from-indigo-500 to-purple-500"></div>

                    <!-- Content -->
                    <div class="p-6">

                        <div
                            class="w-14 h-14 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl -mt-12 shadow-md">
                            📚
                        </div>

                        <h3 class="text-xl font-bold mt-4 group-hover:text-indigo-600 transition">
                            {{ $class->name }}
                        </h3>

                        <p class="text-gray-500 mt-2">
                            Complete class-wise bundle available.
                        </p>

                        <div class="mt-5 flex items-center justify-between">

                            <span class="text-sm text-gray-400">
                                Books & Accessories
                            </span>

                            <span class="text-indigo-600 font-semibold">
                                View Bundle →
                            </span>

                        </div>

                    </div>

                </a>
            @endforeach

        </div>
    @else
        <!-- Empty State -->

        <div class="bg-white rounded-3xl shadow p-12 text-center">

            <div class="text-7xl mb-5">
                📚
            </div>

            <h2 class="text-3xl font-bold text-gray-800 mb-3">
                No Classes Found
            </h2>

            <p class="text-gray-500 max-w-md mx-auto">
                There are currently no classes available for
                <strong>{{ $school->name }}</strong>.
                Please check back later or contact support.
            </p>

            <a href="{{ route('schools.index') }}"
                class="inline-block mt-6 bg-indigo-600 text-white px-6 py-3 rounded-xl hover:bg-indigo-700">
                Browse Other Schools
            </a>

        </div>
    @endif


    <!-- Bottom CTA -->

    @if ($school->classes->count())
        <section class="mt-16">

            <div class="bg-white rounded-3xl shadow p-8 text-center">

                <h2 class="text-2xl font-bold mb-3">
                    Can't Find Your Class?
                </h2>

                <p class="text-gray-500 mb-5">
                    Contact us and we'll help you find the correct books and bundle.
                </p>

                <button class="bg-indigo-600 text-white px-6 py-3 rounded-xl hover:bg-indigo-700">
                    Contact Support
                </button>

            </div>

        </section>
    @endif

@endsection
