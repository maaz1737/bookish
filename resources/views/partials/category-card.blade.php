<div class="category-card card group product-card filter-card">
    <div>
        <div class="image-container" style="background:url({{ $category->imageUrl()}})">
            {{-- @if ($category->image ?? false)
            <img src="{{ url('storage/' . $category->image) }}" alt="{{ $category->name }} category"
                class="card-img-cover" loading="lazy" />
            @else
            <i class="fa-solid fa-book text-4xl text-[#001F54] opacity-30"></i>
            @endif --}}
        </div>
        <div class="py-3 pt-5">
            <h3 class="text-base font-bold text-[#001F54] text-center filter-name">
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