@extends('layouts.app')

@section('content')

    <!-- Breadcrumb -->
    <nav class="text-xs text-slate-500 mb-6 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-[#001F54] transition-colors">Home</a>
        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
        <span class="text-[#001F54] font-semibold">All Categories</span>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-[#001F54] mb-3">
            View All Categories
        </h1>
        <p class="text-slate-600 text-sm sm:text-base max-w-2xl leading-relaxed">
            Browse all product categories and subcategories.
        </p>
    </div>

    <!-- Search categories... -->
    {{-- <div class="mb-10 max-w-xl relative">
        <div
            class="flex border border-slate-300 rounded-xl overflow-hidden shadow-sm bg-white focus-within:border-[#001F54] focus-within:ring-2 focus-within:ring-[#001F54]/10 transition-all duration-200">
            <span class="pl-4 flex items-center text-slate-400">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input type="text" id="categorySearchInput" placeholder="Search categories..."
                class="w-full pl-3 pr-4 py-3.5 text-sm outline-none text-slate-800 bg-white placeholder-slate-400">
            <select class="border-l border-slate-300 px-3 text-sm bg-white " id="categoryFilter">
                <option value="">All Categories</option>
                @foreach ($parentCategories as $parent)
                <option value="{{ $parent->slug }}">{{ $parent->name }}</option>
                @endforeach
            </select>
            <button type="button" id="categorySearchClear" class="pr-4 text-slate-400 hover:text-slate-600 text-sm hidden">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div> --}}

    <!-- Explore products by category alert box -->
    {{-- <div
        class="bg-gradient-to-r from-blue-50/50 to-indigo-50/50 border border-slate-200/80 rounded-[24px] p-6 sm:p-8 mb-12 shadow-sm">
        <h2 class="text-xl font-bold text-[#001F54] mb-2">
            Explore products by category
        </h2>
        <p class="text-slate-600 text-sm mb-6 leading-relaxed">
            This page focuses on product categories only. School-specific books and uniforms should remain under the
            separate Shop By School journey.
        </p>

        <!-- Nested card: Looking for school books? -->
        <div
            class="bg-white border border-slate-100 rounded-2xl p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4 hover:shadow-md transition-shadow duration-300 max-w-3xl">
            <div
                class="w-14 h-14 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-center text-3xl shadow-sm shrink-0">
                🏫
            </div>
            <div>
                <h3 class="font-bold text-base text-[#001F54] mb-0.5">
                    Looking for school books?
                </h3>
                <p class="text-slate-500 text-xs sm:text-sm">
                    Use <a href="{{ route('schools.index') }}" class="text-[#001F54] font-semibold hover:underline">Shop By
                        School</a> to select school, class, books and uniforms.
                </p>
            </div>
        </div>
    </div> --}}

    <!-- Categories List Sections -->
    <div class="space-y-16" id="categories-container">
        @foreach ($parentCategories as $parent)
            @php
                // Parent icons mapping
                $parentIcons = [
                    'school-essentials' => '🎒',
                    'gifts-decor' => '🎁',
                    'fragrances' => '🧴'
                ];
                $parentIcon = $parentIcons[$parent->slug] ?? '📁';
            @endphp
            <div class="parent-category-section" data-parent-name="{{ strtolower($parent->name) }}">

                <!-- Main Heading Section -->
                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-4 mb-6">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#001F54] flex items-center gap-3">
                            <span class="text-3xl">{{ $parentIcon }}</span>
                            {{ $parent->name }}
                        </h2>
                        {{-- <p class="text-slate-500 text-xs sm:text-sm mt-1">
                            {{ $parent->description }}
                        </p> --}}
                    </div>
                    <a href="{{ route('category.show', $parent->slug) }}"
                        class="text-[#001F54] hover:text-[#ff7a00] font-bold text-sm flex items-center gap-1 transition-colors mt-2 sm:mt-0">
                        View All {{ str_replace(' & ', ' ', $parent->name) }} <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <!-- Subcategories Grid -->
                <div class="grid-3 subcategories-grid">
                    @foreach ($parent->children as $sub)

                        @include('partials.category-card', ['category' => $sub])
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Live Search Script -->
    <script>
        $(document).ready(function () {
            var $searchInput = $('#categorySearchInput');
            var $categoryFillter = $('#categoryFilter');
            var $searchClear = $('#categorySearchClear');

            function filterCategories(query) {
                query = query.toLowerCase().trim();

                if (query === '') {
                    $searchClear.addClass('hidden');
                    $('.parent-category-section').show();
                    $('.subcategory-card').show();
                    return;
                }

                $searchClear.removeClass('hidden');

                $('.parent-category-section').each(function () {
                    var $section = $(this);
                    var parentName = $section.data('parent-name');
                    var matchesParent = parentName.indexOf(query) > -1;

                    var visibleCards = 0;

                    $section.find('.subcategory-card').each(function () {
                        var $card = $(this);
                        var subName = $card.data('sub-name');

                        if (matchesParent || subName.indexOf(query) > -1) {
                            $card.show();
                            visibleCards++;
                        } else {
                            $card.hide();
                        }
                    });

                    if (visibleCards > 0 || matchesParent) {
                        $section.show();
                        if (matchesParent) {
                            $section.find('.subcategory-card').show();
                        }
                    } else {
                        $section.hide();
                    }
                });
            }

            $searchInput.on('input keyup', function () {
                filterCategories($(this).val());
            });

            $searchClear.on('click', function () {
                $searchInput.val('').focus();
                filterCategories('');
            });
        });
    </script>

@endsection