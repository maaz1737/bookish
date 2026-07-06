<div class="ml-4 mt-2">

    <label class="flex items-center gap-2">
        <input type="checkbox" class="checkbox">
        {{ $cat->name }}
    </label>

    @if ($cat->allChildren->count())
        @foreach ($cat->allChildren as $child)
            @include('admin.categories.category_tree', ['cat' => $child])
        @endforeach
    @endif

</div>