@extends('layouts.app')

@section('content')

    <!-- Category Hero Section -->
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-3xl p-10 mb-10">

        <div class="flex items-center gap-5">

            <div class="w-20 h-20 bg-white text-indigo-600 rounded-full flex items-center justify-center text-4xl shadow-lg">
                🎒
            </div>

            <div>
                <h1 class="text-4xl font-bold">
                    {{ $category->name }}
                </h1>

                <p class="mt-2 text-indigo-100">
                    Explore high-quality school essentials for students.
                </p>

                <div class="mt-4 inline-flex bg-white/20 px-4 py-2 rounded-full text-sm">
                    {{ $products->total() }} Products Available
                </div>
            </div>

        </div>

    </section>


    <!-- Category Description Banner -->

    <div class="bg-white rounded-3xl shadow-sm p-6 mb-10">

        <div class="flex items-center gap-4">

            <div class="text-4xl">
                📚
            </div>

            <div>
                <h2 class="font-bold text-xl">
                    School Essentials Collection
                </h2>

                <p class="text-gray-500 mt-1">
                    Find books, uniforms, bags, stationery and other school items
                    carefully selected for students.
                </p>
            </div>

        </div>

    </div>


    <!-- Products -->

    @if ($products->count())
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

            @foreach ($products as $product)
                <a href="{{ route('product.show', $product) }}"
                    class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition duration-300">

                    <!-- Product Image -->

                    <div class="h-60 bg-gray-100 flex items-center justify-center">

                        @if (count($product->images))
                            <img src="{{ Storage::url($product->images[0]) }}" alt="{{ $product->name }}"
                                class="h-full w-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="text-7xl">
                                🎒
                            </div>
                        @endif

                    </div>

                    <!-- Product Content -->

                    <div class="p-5">

                        <h3 class="font-bold text-lg text-gray-800 group-hover:text-indigo-600 transition">
                            {{ $product->name }}
                        </h3>

                        <p class="text-gray-500 text-sm mt-2 line-clamp-2">
                            School quality products for everyday student needs.
                        </p>

                        <div class="mt-5 flex items-center justify-between">

                            <div>
                                <span class="text-2xl font-bold text-indigo-600">
                                    PKR {{ number_format($product->effectivePrice()) }}
                                </span>
                            </div>

                            <span class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full text-sm font-medium">
                                View
                            </span>

                        </div>

                    </div>

                </a>
            @endforeach

        </div>
    @else
        <!-- Empty State -->

        <div class="bg-white rounded-3xl shadow p-12 text-center">

            <div class="text-8xl mb-5">
                📦
            </div>

            <h2 class="text-3xl font-bold mb-3">
                No Products Found
            </h2>

            <p class="text-gray-500 max-w-lg mx-auto">
                Products for this category have not been added yet.
                Please check back later.
            </p>

        </div>
    @endif


    <!-- Pagination -->

    @if ($products->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $products->links() }}
        </div>
    @endif


    <!-- Bottom CTA -->

    <section class="mt-16">

        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-10 text-white text-center">

            <h2 class="text-3xl font-bold mb-3">
                Everything Your Child Needs For School
            </h2>

            <p class="opacity-90 mb-6">
                Books, uniforms, accessories and educational essentials
                delivered directly to your doorstep.
            </p>

            <a href="{{ route('schools.index') }}"
                class="inline-block bg-white text-indigo-600 px-6 py-3 rounded-xl font-semibold hover:bg-gray-100">
                Browse Schools
            </a>

        </div>

    </section>

@endsection
