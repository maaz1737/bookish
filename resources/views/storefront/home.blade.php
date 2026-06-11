@extends('layouts.app')

@section('content')
    <!-- HERO -->
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-3xl overflow-hidden">

        <div class="grid md:grid-cols-2 items-center">

            <div class="p-12">

                <h1 class="text-5xl font-bold leading-tight">
                    Everything For The
                    <span class="text-yellow-300">
                        New School Year
                    </span>
                </h1>

                <p class="mt-6 text-lg opacity-90">
                    Class-wise book bundles, uniforms and accessories delivered
                    anywhere in Pakistan.
                </p>

                <div class="mt-8 flex gap-4">
                    <a href="{{ route('schools.index') }}"
                        class="bg-white text-indigo-600 px-6 py-3 rounded-xl font-semibold">
                        Browse Schools
                    </a>

                    <a href="#featured" class="border border-white px-6 py-3 rounded-xl">
                        Explore Products
                    </a>
                </div>

            </div>

            <div class="hidden md:block">
                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7" class="w-full h-full object-cover"
                    alt="">
            </div>

        </div>

    </section>


    <!-- POPULAR SCHOOLS -->

    <section class="mt-16">

        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">
                Popular Schools
            </h2>

            <a href="{{ route('schools.index') }}" class="text-indigo-600 font-semibold">
                View All →
            </a>
        </div>

        <div class="grid md:grid-cols-4 gap-6">

            @foreach ($schools as $school)
                <a href="{{ route('schools.show', $school) }}"
                    class="bg-white rounded-2xl shadow hover:shadow-xl transition p-6">

                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center text-2xl">
                        🏫
                    </div>

                    <h3 class="font-bold text-lg mt-4">
                        {{ $school->name }}
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Books & Uniforms Available
                    </p>

                    <span class="text-indigo-600 font-semibold mt-4 inline-block">
                        View Classes →
                    </span>

                </a>
            @endforeach

        </div>

    </section>


    <!-- CATEGORIES -->

    <section class="mt-20">

        <h2 class="text-3xl font-bold mb-8">
            Shop By Category
        </h2>

        <div class="grid md:grid-cols-3 gap-6">

            <a href="{{ route('category.show', 'books') }}" class="bg-white p-8 rounded-2xl shadow hover:shadow-lg">
                <div class="text-5xl">📚</div>
                <h3 class="font-bold text-xl mt-4">Books</h3>
            </a>

            <a href="{{ route('category.show', 'uniforms') }}" class="bg-white p-8 rounded-2xl shadow hover:shadow-lg">
                <div class="text-5xl">👕</div>
                <h3 class="font-bold text-xl mt-4">Uniforms</h3>
            </a>

            <a href="{{ route('category.show', 'accessories') }}" class="bg-white p-8 rounded-2xl shadow hover:shadow-lg">
                <div class="text-5xl">🎒</div>
                <h3 class="font-bold text-xl mt-4">Accessories</h3>
            </a>

        </div>

    </section>


    <!-- PRODUCTS -->

    {{-- <section id="featured" class="mt-20">

        <h2 class="text-3xl font-bold mb-8">
            Featured Products
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

            @foreach ($featured as $product)
                <div class="bg-white rounded-2xl shadow overflow-hidden hover:shadow-xl">

                    <div class="h-48 bg-gray-100"></div>

                    <div class="p-4">

                        <h3 class="font-semibold">
                            {{ $product->name }}
                        </h3>

                        <div class="text-indigo-600 text-xl font-bold mt-3">
                            PKR {{ number_format($product->effectivePrice()) }}
                        </div>

                        <a href="{{ route('product.show', $product) }}"
                            class="mt-4 block text-center bg-indigo-600 text-white py-2 rounded-lg">
                            View Product
                        </a>

                    </div>

                </div>
            @endforeach

        </div>

    </section> --}}


    <!-- WHY US -->

    <section class="mt-20">

        <div class="bg-white rounded-3xl p-10 shadow">

            <h2 class="text-3xl font-bold text-center mb-10">
                Why Choose Bookish?
            </h2>

            <div class="grid md:grid-cols-3 gap-8 text-center">

                <div>
                    <div class="text-5xl mb-4">🚚</div>
                    <h3 class="font-bold">Fast Delivery</h3>
                    <p class="text-gray-500 mt-2">
                        Nationwide delivery across Pakistan.
                    </p>
                </div>

                <div>
                    <div class="text-5xl mb-4">📚</div>
                    <h3 class="font-bold">Complete Bundles</h3>
                    <p class="text-gray-500 mt-2">
                        Class-wise book packages.
                    </p>
                </div>

                <div>
                    <div class="text-5xl mb-4">🔒</div>
                    <h3 class="font-bold">Secure Shopping</h3>
                    <p class="text-gray-500 mt-2">
                        Safe checkout experience.
                    </p>
                </div>

            </div>

        </div>

    </section>
@endsection
