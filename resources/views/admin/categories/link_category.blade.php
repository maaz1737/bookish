<a href="{{ route('category.show', $cat->slug) }}"
    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-blue-900 hover:bg-slate-50 transition border-b border-slate-50 last:border-0">

    <span
        class="w-8 h-8 shrink-0 rounded-full overflow-hidden bg-slate-50 flex items-center justify-center border border-slate-100">
        @if ($cat->image)
            <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}" class="w-full h-full object-cover"
                loading="lazy">
        @else
            <i class="fa-solid fa-school text-sm text-[#001F54]"></i>
        @endif
    </span>

    <span class="font-semibold leading-tight text-slate-800">
        {{ ucfirst($cat->name) }}
    </span>
</a>


@if ($cat->allChildren->count())
    @foreach ($cat->allChildren as $child)
        @include('admin.categories.link_category', ['cat' => $child])
    @endforeach
@endif