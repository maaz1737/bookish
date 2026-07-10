@extends('layouts.app')

@section('content')

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-navy-800 to-navy-900 text-white rounded-3xl p-10 mb-10">
        <div class="flex items-center gap-5">
            <div class="w-20 h-20 bg-white text-navy-800 rounded-full flex items-center justify-center text-4xl shadow-lg">
                📚
            </div>
            <div>
                <h1 class="text-4xl font-bold">
                    All Products Collection
                </h1>
                <p class="mt-2 text-slate-200">
                    Explore high-quality school essentials, books, uniforms, bags, and baby wear.
                </p>
                <div class="mt-4 inline-flex bg-white/20 px-4 py-2 rounded-full text-sm">
                    {{ $products->total() }} Products Available
                </div>
            </div>
        </div>
    </section>

    <!-- Description Banner -->
    <div class="bg-white rounded-3xl shadow-sm p-6 mb-10 border border-slate-200">
        <div class="flex items-center gap-4">
            <div class="text-4xl">
                🎒
            </div>
            <div>
                <h2 class="font-bold text-xl text-navy-950">
                    Everything Your Child Needs For School
                </h2>
                <p class="text-gray-500 mt-1">
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