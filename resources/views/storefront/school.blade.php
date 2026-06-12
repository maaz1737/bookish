@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 min-h-screen">

        <!-- School Banner -->
        <section class="relative h-80 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7" class="w-full h-full object-cover"
                alt="">

            <div class="absolute inset-0 bg-black/60"></div>

            <div class="absolute inset-0 flex items-center">
                <div class="max-w-7xl mx-auto px-6 w-full">
                    <div class="flex items-center gap-6">

                        <div class="h-28 w-28 rounded-2xl bg-white p-2">
                            <img src="https://cdn-icons-png.flaticon.com/512/2436/2436636.png"
                                class="w-full h-full object-contain" alt="">
                        </div>

                        <div class="text-white">
                            <h1 class="text-4xl font-bold">
                                {{ $school->name }}
                            </h1>

                            <p class="mt-2 text-gray-200 max-w-2xl">
                                Find books, uniforms, school diaries and class-specific
                                learning material for all classes.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-6 py-10">

            <!-- Classes Section -->
            <section class="mb-12">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">
                        Browse By Class
                    </h2>

                    <a href="#" class="text-indigo-600 font-medium">
                        View All
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

                    @forelse ($school->classes as $class)
                        <a href="{{ route('bundle.show', [$school, $class->slug]) }}"
                            class="bg-white rounded-2xl p-6 text-center shadow hover:shadow-lg transition">
                            <h3 class="font-bold text-xl">{{ $class->name }}</h3>
                            <p class="text-sm text-gray-500 mt-2">
                                Books & Supplies
                            </p>
                        </a>
                    @empty
                        <div class="col-span-full flex items-center justify-center py-16">
                            <div class="text-center">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20 13V7a2 2 0 00-2-2h-3V3H9v2H6a2 2 0 00-2 2v6m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4">
                                    </path>
                                </svg>

                                <h3 class="text-lg font-semibold text-gray-700">
                                    No Class Found
                                </h3>

                                <p class="text-gray-500 mt-2">
                                    There are currently no Class available for this school.
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- School Essentials -->
            <section class="mb-12">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">
                        School Essentials
                    </h2>

                    <a href="#" class="text-indigo-600 font-medium">
                        View All
                    </a>
                </div>

                <div class="grid md:grid-cols-3 gap-6">

                    @forelse ($school->products as $product)
                        <div class="bg-white rounded-2xl overflow-hidden shadow">
                            <img src="{{ asset((app()->environment('production') ? 'public/' : '') . 'storage/' . $product->images[0]) }}"
                                class="h-56 w-full object-cover" alt="{{ $product->name }}">

                            <div class="p-5">
                                <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">
                                    School Item
                                </span>

                                <h3 class="font-semibold text-lg mt-4">
                                    {{ $product->name }}
                                </h3>

                                <p class="text-gray-500 text-sm mt-2">
                                    Required for all students.
                                </p>

                                <div class="mt-4 flex justify-between items-center">
                                    <span class="font-bold">Rs. 2,500</span>

                                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full flex items-center justify-center py-16">
                            <div class="text-center">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20 13V7a2 2 0 00-2-2h-3V3H9v2H6a2 2 0 00-2 2v6m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4">
                                    </path>
                                </svg>

                                <h3 class="text-lg font-semibold text-gray-700">
                                    No Products Found
                                </h3>

                                <p class="text-gray-500 mt-2">
                                    There are currently no products available for this school.
                                </p>
                            </div>
                        </div>
                    @endforelse


                </div>
            </section>
            <!-- General Accessories -->
            <section>

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">
                        General Accessories
                    </h2>
                </div>

                <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6">

                    <div class="bg-white rounded-2xl p-5 shadow">
                        <h3 class="font-semibold text-lg">
                            School Bag
                        </h3>

                        <p class="text-gray-500 text-sm mt-2">
                            Suitable for all schools.
                        </p>

                        <div class="mt-4 flex justify-between items-center">
                            <span class="font-bold">Rs. 3,200</span>
                            <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
                                Add
                            </button>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-5 shadow">
                        <h3 class="font-semibold text-lg">
                            Water Bottle
                        </h3>

                        <p class="text-gray-500 text-sm mt-2">
                            Suitable for all schools.
                        </p>

                        <div class="mt-4 flex justify-between items-center">
                            <span class="font-bold">Rs. 850</span>
                            <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
                                Add
                            </button>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-5 shadow">
                        <h3 class="font-semibold text-lg">
                            Lunch Box
                        </h3>

                        <p class="text-gray-500 text-sm mt-2">
                            Suitable for all schools.
                        </p>

                        <div class="mt-4 flex justify-between items-center">
                            <span class="font-bold">Rs. 1,200</span>
                            <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
                                Add
                            </button>
                        </div>
                    </div>

                </div>

            </section>

        </div>

    </div>
@endsection
