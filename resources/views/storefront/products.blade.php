@extends('layouts.app')

@section('content')

    <!-- Hero Section -->
    <section
        class="sm:bg-transparent bg-gradient-to-r from-navy-800 to-navy-900 text-white rounded-3xl p-2 sm:p-2 md:p-10 mb-10">

        <div class="flex flex-col items-center text-center gap-4 md:flex-row md:items-center md:text-left md:gap-5">

            <div
                class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 bg-white text-navy-800 rounded-full flex items-center justify-center text-3xl md:text-4xl shadow-lg">
                📚
            </div>

            <!-- Content -->
            <div>
                <h1 class="text-white text-2xl sm:text-3xl md:text-4xl font-semibold md:font-bold">
                    All Products Collection
                </h1>

                <p class="mt-2 text-slate-200 text-sm sm:text-base">
                    Explore high-quality school essentials, books, uniforms, bags, and baby wear.
                </p>

                <div class="mt-4 inline-flex bg-white/20 text-white px-4 py-2 rounded-full text-xs sm:text-sm">
                    {{ $products->total() }} Products Available
                </div>
            </div>

        </div>
    </section>

    <!-- Description Banner -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-3 sm:p-4 md:p-6 mb-10">
        <div class="flex flex-col items-center text-center gap-4 md:flex-row md:items-center md:text-left">
            <div class="hidden md:block text-3xl sm:text-4xl md:text-5xl shrink-0">
                🎒
            </div>
            <!-- Content -->
            <div>
                <h2 class="text-lg sm:text-xl md:text-2xl font-semibold md:font-bold text-navy-950">
                    Everything Your Child Needs For School
                </h2>

                <p class="text-sm sm:text-base text-gray-500 mt-2">
                    Find books, uniforms, bags, stationery and other school items carefully selected for students.
                </p>
            </div>

        </div>
    </div>

    <!-- Products Grid -->
    @if ($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($products as $product)
                @include('partials.product-card', ['product' => $product])
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
                No products have been added yet. Please check back later.
            </p>
        </div>
    @endif

    <!-- Pagination -->
    @if ($products->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $products->links() }}
        </div>
    @endif

@endsection