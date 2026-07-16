<a href="{{ route('category.show', $category->slug) }}"
    class="category-card card group product-card filter-card cursor-pointer">
    <div>
        <div class="image-container overflow-hidden" style="background:url({{ $category->imageUrl()}})">
            <img src="{{ $category->imageUrl()}}" alt="{{ $category->name }}" loading="lazy"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
        </div>
        <div class="py-3 pt-5">
            <h3
                class="text-sm font-bold text-[#0a1a3d] hover:text-[#1e3a8a] transition-colors leading-snug line-clamp-2 filter-name  px-4">
                {{ ucfirst($category->name)}}
            </h3>
        </div>
    </div>
    <div class="px-3 pb-4">
        <button class="primary-btn group/button inline-flex items-center justify-center gap-2 hover:bg-[#223a8f]">
            <span>Explore Now</span>

            <span class="inline-flex transition-transform duration-300 ease-out group-hover/button:translate-x-1">
                <i class="fa-solid fa-arrow-right text-sm"></i>
            </span>
        </button>
    </div>
</a>