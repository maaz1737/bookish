@csrf
<div class="grid sm:grid-cols-2 gap-4">
    <label class="block sm:col-span-2"><span class="text-sm font-medium">Name</span>
        <input name="name" value="{{ old('name', $product->name ?? '') }}" required
            class="w-full border rounded px-3 py-2 mt-1"></label>
    <label class="block"><span class="text-sm font-medium">Category</span>
        <select name="category_id" required class="w-full border rounded px-3 py-2 mt-1">
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id ?? null) == $c->id)>{{ $c->name }} </option>
            @endforeach
        </select></label>
    <label class="block"><span class="text-sm font-medium">School (optional)</span>
        <select name="school_id" id="school_id" class="w-full border rounded px-3 py-2 mt-1">
            <option value="">—</option>
            @foreach ($schools as $s)
                <option value="{{ $s->id }}" @selected(old('school_id', $product->school_id ?? null) == $s->id)>{{ $s->name }}</option>
            @endforeach
        </select></label>
    <label class="block"><span class="text-sm font-medium">Class (optional)</span>
        <select name="class_id" id="class_id" class="w-full border rounded px-3 py-2 mt-1">
            <option value="">—</option>
        </select>
    </label>
    <label class="block"><span class="text-sm font-medium">Publisher (hidden from customers)</span>
        <input name="publisher" value="{{ old('publisher', $product->publisher ?? '') }}"
            class="w-full border rounded px-3 py-2 mt-1"></label>
    <label class="block"><span class="text-sm font-medium">Base Price</span>
        <input name="price" type="number" step="0.01" value="{{ old('price', $product->price ?? '') }}" required
            class="w-full border rounded px-3 py-2 mt-1"></label>
    <label class="block"><span class="text-sm font-medium">Discount Price</span>
        <input name="discount_price" type="number" step="0.01"
            value="{{ old('discount_price', $product->discount_price ?? '') }}"
            class="w-full border rounded px-3 py-2 mt-1"></label>
    <label class="block"><span class="text-sm font-medium">Stock</span>
        <input name="stock" type="number" value="{{ old('stock', $product->stock ?? 0) }}" required
            class="w-full border rounded px-3 py-2 mt-1"></label>
    <label class="block"><span class="text-sm font-medium">Low-stock threshold</span>
        <input name="low_stock_threshold" type="number"
            value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 5) }}"
            class="w-full border rounded px-3 py-2 mt-1"></label>
    <label class="block"><span class="text-sm font-medium">Size (uniforms)</span>
        <input name="size" value="{{ old('size', $product->size ?? '') }}"
            class="w-full border rounded px-3 py-2 mt-1"></label>
    <label class="block"><span class="text-sm font-medium">Gender (uniforms)</span>
        <select name="gender" class="w-full border rounded px-3 py-2 mt-1">
            <option value="">—</option>
            @foreach (['boys', 'girls', 'unisex'] as $g)
                <option value="{{ $g }}" @selected(old('gender', $product->gender ?? null) == $g)>{{ ucfirst($g) }}</option>
            @endforeach
        </select></label>
    <label class="block sm:col-span-2"><span class="text-sm font-medium">Description</span>
        <textarea name="description" class="w-full border rounded px-3 py-2 mt-1">{{ old('description', $product->description ?? '') }}</textarea>
    </label>
    <label class="block sm:col-span-2"><span class="text-sm font-medium">Images</span>
        <input name="images[]" type="file" multiple accept="image/*" class="w-full mt-1"></label>
    <label class="flex items-center gap-2 sm:col-span-2">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))>
        Active
    </label>
    <label class="flex items-center gap-2 sm:col-span-2">
        <input type="checkbox" name="is_best_seller" value="1" @checked(old('is_best_seller', $product->is_best_seller ?? false))>
        Best Seller Product
    </label>
    <label class="flex items-center gap-2 sm:col-span-2">
        <input type="checkbox" name="has_variant" value="1" @checked(old('has_variant', $product->has_variant ?? true))>
        Product Has Variant
    </label>
</div>
<button class="mt-6 bg-indigo-600 text-white px-6 py-2 rounded">Save</button>



<script>
    $(document).ready(function() {

        // When school changes
        $('#school_id').on('change', function() {

            let schoolId = $(this).val();
            let classSelect = $('#class_id');

            classSelect.html('<option value="">Loading...</option>');

            if (!schoolId) {
                classSelect.html('<option value="">—</option>');
                return;
            }

            $.get(`/get-classes/${schoolId}`, function(data) {

                classSelect.html('<option value="">—</option>');

                $.each(data, function(index, cls) {
                    classSelect.append(
                        `<option value="${cls.id}">${cls.name}</option>`
                    );
                });

            });
        });


        // On page load (edit mode)
        let schoolId = $('#school_id').val();

        if (schoolId) {

            $.get(`/get-classes/${schoolId}`, function(data) {

                let selectedClass = "{{ $product->class_id ?? '' }}";

                let classSelect = $('#class_id');

                classSelect.html('<option value="">—</option>');

                $.each(data, function(index, cls) {

                    let selected = (cls.id == selectedClass) ? 'selected' : '';

                    classSelect.append(
                        `<option value="${cls.id}" ${selected}>${cls.name}</option>`
                    );
                });
            });
        }

    });
</script>
