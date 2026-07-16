<div class="category-card card group product-card filter-card cursor-pointer">
    <div>
        <div class="image-container overflow-hidden" style="background:url({{ $category->imageUrl()}})">
            <img src="{{ $category->imageUrl()}}" alt="{{ $category->name }}" loading="lazy"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
        </div>
        <div class="py-3 pt-5">
            <h3 class="text-base font-bold text-[#001F54] group-hover:text-[#ff7a00] hover:text-[#ff7a00] px-4 filter-name transition-colors cursor-pointer">
                {{ $category->name }}
            </h3>
        </div>
    </div>
    <div class="px-3 pb-4">
        <a href="{{ route('category.show', $category->slug) }}" class="primary-btn block hover:bg-[#223a8f]">
            Explore Now →
        </a>
    </div>
</div>