@extends('layouts.app')

@section('content')
    <!-- HERO SECTION -->
    <section
        class="relative bg-gradient-to-br from-indigo-700 via-indigo-600 to-purple-700 text-white rounded-3xl overflow-hidden shadow-2xl mb-16">
        <div class="grid md:grid-cols-12 items-center min-h-[450px]">
            <!-- Hero Text -->
            <div class="p-8 sm:p-12 md:col-span-7 flex flex-col justify-center z-10">
                <span
                    class="bg-indigo-500/30 text-yellow-300 text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full w-fit mb-4 backdrop-blur-sm">
                    Back To School 2026
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight">
                    Everything For The <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-amber-400">
                        New School Year
                    </span>
                </h1>
                <p class="mt-4 text-base sm:text-lg text-indigo-100 max-w-xl font-medium opacity-90">
                    Class-wise book bundles, high-quality uniforms, and premium accessories delivered straight to your
                    doorstep anywhere in Pakistan.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('schools.index') }}"
                        class="bg-white text-indigo-700 px-6 py-3.5 rounded-xl font-bold shadow-lg hover:bg-indigo-50 hover:-translate-y-0.5 transition-all duration-200 transform">
                        Browse Schools
                    </a>
                    <a href="#featured"
                        class="bg-indigo-600/40 border border-indigo-300/50 backdrop-blur-sm px-6 py-3.5 rounded-xl font-semibold hover:bg-indigo-600/60 hover:-translate-y-0.5 transition-all duration-200 transform">
                        Explore Products
                    </a>
                </div>
            </div>
            <!-- Hero Image -->
            <div class="hidden md:block md:col-span-5 h-full relative min-h-[450px]">
                {{-- <div class="absolute inset-0 bg-gradient-to-r from-indigo-700 to-transparent z-10"></div> --}}
                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7"
                    class="w-full h-full object-cover transform scale-105 hover:scale-100 transition-all duration-700"
                    alt="School Kids">
            </div>
        </div>
    </section>

    <!-- POPULAR SCHOOLS SECTION -->
    <section class="py-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    Popular Schools
                </h2>
                <p class="text-gray-500 text-sm mt-1">Select your school to find the exact required curriculum & dress.</p>
            </div>
            <a href="{{ route('schools.index') }}"
                class="group text-indigo-600 font-bold flex items-center gap-1 hover:text-indigo-800 transition">
                View All Schools
                <span class="transform group-hover:translate-x-1 transition-transform">→</span>
            </a>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($schools as $school)
                <a href="{{ route('schools.show', $school) }}"
                    class="group bg-white rounded-2xl border border-gray-100 p-6 flex flex-col justify-between shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div>
                        <div
                            class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-3xl group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                            🏫
                        </div>
                        <h3
                            class="font-bold text-xl text-gray-800 mt-5 group-hover:text-indigo-600 transition-colors line-clamp-1">
                            {{ $school->name }}
                        </h3>
                        <p class="text-gray-500 text-sm mt-2 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Books & Uniforms Available
                        </p>
                    </div>
                    <div
                        class="text-indigo-600 font-bold text-sm mt-6 pt-4 border-t border-gray-50 flex items-center justify-between">
                        <span>View Classes</span>
                        <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- SHOP BY CATEGORY SECTION -->
    <section class="py-12 md:py-16">
        <div class="text-center max-w-xl mx-auto mb-10">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Shop By Category
            </h2>
            <p class="text-gray-500 mt-2">Get premium quality items strictly tailored to your educational needs.</p>
        </div>

        <div class="grid sm:grid-cols-3 gap-6">
            <!-- Category 1 -->
            <a href="{{ route('category.show', 'books') }}"
                class="group relative overflow-hidden bg-gradient-to-br from-amber-50 to-orange-100/50 p-8 rounded-3xl border border-amber-100 flex flex-col justify-between min-h-[200px] shadow-sm hover:shadow-md transition">
                <div
                    class="absolute -right-4 -bottom-4 text-8xl opacity-15 transform group-hover:scale-110 group-hover:-rotate-12 transition-all duration-300">
                    📚</div>
                <div class="w-12 h-12 bg-amber-500/10 rounded-xl flex items-center justify-center text-2xl">📚</div>
                <div>
                    <h3 class="font-extrabold text-2xl text-gray-800 mt-4">Books & Bundles</h3>
                    <p class="text-gray-600 text-sm mt-1">Syllabus packages by class</p>
                </div>
            </a>

            <!-- Category 2 -->
            <a href="{{ route('category.show', 'uniforms') }}"
                class="group relative overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-100/50 p-8 rounded-3xl border border-blue-100 flex flex-col justify-between min-h-[200px] shadow-sm hover:shadow-md transition">
                <div
                    class="absolute -right-4 -bottom-4 text-8xl opacity-15 transform group-hover:scale-110 group-hover:-rotate-12 transition-all duration-300">
                    👕</div>
                <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-2xl">👕</div>
                <div>
                    <h3 class="font-extrabold text-2xl text-gray-800 mt-4">Official Uniforms</h3>
                    <p class="text-gray-600 text-sm mt-1">Perfect fit and quality fabric</p>
                </div>
            </a>

            <!-- Category 3 -->
            <a href="{{ route('category.show', 'accessories') }}"
                class="group relative overflow-hidden bg-gradient-to-br from-purple-50 to-pink-100/50 p-8 rounded-3xl border border-purple-100 flex flex-col justify-between min-h-[200px] shadow-sm hover:shadow-md transition">
                <div
                    class="absolute -right-4 -bottom-4 text-8xl opacity-15 transform group-hover:scale-110 group-hover:-rotate-12 transition-all duration-300">
                    🎒</div>
                <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center text-2xl">🎒</div>
                <div>
                    <h3 class="font-extrabold text-2xl text-gray-800 mt-4">Accessories</h3>
                    <p class="text-gray-600 text-sm mt-1">Bags, bottles, and stationery</p>
                </div>
            </a>
        </div>
    </section>

    <!-- WHY US SECTION -->
    <section class="py-8 mb-12">
        <div class="bg-gray-50 rounded-3xl p-8 sm:p-12 border border-gray-100 shadow-sm">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-center text-gray-900 tracking-tight mb-12">
                Why Parents Trust Bookish
            </h2>

            <div class="grid md:grid-cols-3 gap-8 lg:gap-12 text-center">
                <!-- Feature 1 -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center text-3xl mb-4 border border-gray-100">
                        🚚
                    </div>
                    <h3 class="font-bold text-lg text-gray-800">Fast Nationwide Delivery</h3>
                    <p class="text-gray-500 text-sm mt-2 max-w-xs">
                        Carefully packed and delivered across Pakistan with real-time tracking.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center text-3xl mb-4 border border-gray-100">
                        📦
                    </div>
                    <h3 class="font-bold text-lg text-gray-800">100% Complete Bundles</h3>
                    <p class="text-gray-500 text-sm mt-2 max-w-xs">
                        No missing books. Get verified packages curated straight from school lists.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center text-3xl mb-4 border border-gray-100">
                        🔒
                    </div>
                    <h3 class="font-bold text-lg text-gray-800">Secure Checkout</h3>
                    <p class="text-gray-500 text-sm mt-2 max-w-xs">
                        Multiple safe payment options including Cash on Delivery (COD).
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
