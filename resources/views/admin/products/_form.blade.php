@extends('layouts.app') {{-- Agar aap koi layout use kar rahe hain to isko apne mutabiq set kar lein --}}

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-xl font-bold mb-6">{{ isset($product) ? 'Edit Product' : 'Create Product' }}</h2>
        <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
            method="POST" enctype="multipart/form-data">

            @csrf
            @if (isset($product))
                @method('PUT')
            @endif

            <div class="grid sm:grid-cols-2 gap-4">
                <label class="block sm:col-span-2">
                    <span class="text-sm font-medium">Name</span>
                    <input name="name" value="{{ old('name', $product->name ?? '') }}" required
                        class="w-full border rounded px-3 py-2 mt-1">
                </label>

                <label class="block">
                    <span class="text-sm font-medium">Main Category</span>
                    <select id="categoryId" name="category_id" required class="w-full border rounded px-3 py-2 mt-1">
                        <option value="">Select Category</option>
                        @foreach ($categories as $c)
                            @php
                                $isMainSelected = false;
                                if (old('category_id')) {
                                    $isMainSelected = old('category_id') == $c->id;
                                } elseif (isset($product)) {
                                    // Agar product ki apni category ka parent_id hai, to main category uska parent_id hogi.
                                    $isMainSelected =
                                        $product->category_id == $c->id ||
                                        optional($product->category)->parent_id == $c->id;
                                }
                            @endphp
                            <option value="{{ $c->id }}" @selected($isMainSelected)>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-medium">Sub Category</span>
                    <select id="subcategory_id" name="sub_category_id" class="w-full border rounded px-3 py-2 mt-1">
                        <option value="">Select Sub Category</option>
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-medium">School (optional)</span>
                    <select name="school_id" id="school_id" class="w-full border rounded px-3 py-2 mt-1">
                        <option value="">—</option>
                        @foreach ($schools as $s)
                            <option value="{{ $s->id }}" @selected(old('school_id', $product->school_id ?? null) == $s->id)>
                                {{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-medium">Class (optional)</span>
                    <select name="class_id" id="class_id" class="w-full border rounded px-3 py-2 mt-1">
                        <option value="">—</option>
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-medium">Publisher (hidden from customers)</span>
                    <input name="publisher" value="{{ old('publisher', $product->publisher ?? '') }}"
                        class="w-full border rounded px-3 py-2 mt-1">
                </label>

                <label class="block">
                    <span class="text-sm font-medium">Base Price</span>
                    <input name="price" type="number" step="0.01" value="{{ old('price', $product->price ?? '') }}" required
                        class="w-full border rounded px-3 py-2 mt-1">
                </label>

                <label class="block">
                    <span class="text-sm font-medium">Discount Price</span>
                    <input name="discount_price" type="number" step="0.01"
                        value="{{ old('discount_price', $product->discount_price ?? '') }}"
                        class="w-full border rounded px-3 py-2 mt-1">
                </label>

                <label class="block">
                    <span class="text-sm font-medium">Stock</span>
                    <input name="stock" type="number" value="{{ old('stock', $product->stock ?? 0) }}" required
                        class="w-full border rounded px-3 py-2 mt-1">
                </label>

                <label class="block">
                    <span class="text-sm font-medium">Low-stock threshold</span>
                    <input name="low_stock_threshold" type="number"
                        value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 5) }}"
                        class="w-full border rounded px-3 py-2 mt-1">
                </label>

                <label class="block">
                    <span class="text-sm font-medium">Size (uniforms)</span>
                    <input name="size" value="{{ old('size', $product->size ?? '') }}"
                        class="w-full border rounded px-3 py-2 mt-1">
                </label>

                <label class="block">
                    <span class="text-sm font-medium">Gender (uniforms)</span>
                    <select name="gender" class="w-full border rounded px-3 py-2 mt-1">
                        <option value="">—</option>
                        @foreach (['boys', 'girls', 'unisex'] as $g)
                            <option value="{{ $g }}" @selected(old('gender', $product->gender ?? null) == $g)>
                                {{ ucfirst($g) }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="block sm:col-span-2">
                    <span class="text-sm font-medium">Description</span>
                    <textarea name="description" rows="4"
                        class="w-full border rounded px-3 py-2 mt-1">{{ old('description', $product->description ?? '') }}</textarea>
                </label>

                <div class="block sm:col-span-2">
                    <span class="text-sm font-medium">Images</span>
                    <input name="images[]" type="file" multiple accept="image/*" class="w-full mt-1 mb-3">

                    {{-- Edit mode mein agar product ki pehle se koi images hain to wo yahan show hongi --}}
                    @if (isset($product) && $product->images)
                        <div class="mt-2">
                            <p class="text-xs font-semibold text-gray-500 mb-2">Current Product Images:</p>
                            <div class="flex flex-wrap gap-3 p-3 bg-gray-50 border rounded">
                                @php
                                    // Agar aap database mein images array ya JSON string save kar rahe hain
                                    $productImages = is_string($product->images)
                                        ? json_decode($product->images, true)
                                        : $product->images;
                                @endphp

                                @foreach ($productImages ?? [] as $img)
                                    <div class="relative border rounded p-1 bg-white shadow-sm">
                                        {{-- Apne storage folder path ke mutabiq url change kar saktay hain agar storage/use nahi ho
                                        raha --}}
                                        <img src="{{ asset('storage/' . $img) }}" class="h-20 w-20 object-cover rounded">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <label class="flex items-center gap-2 sm:col-span-2 mt-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))>
                    <span>Active</span>
                </label>

                <label class="flex items-center gap-2 sm:col-span-2">
                    <input type="checkbox" name="is_best_seller" value="1" @checked(old('is_best_seller', $product->is_best_seller ?? false))>
                    <span>Best Seller Product</span>
                </label>

                <label class="flex items-center gap-2 sm:col-span-2">
                    <input type="checkbox" name="has_variant" value="1" @checked(old('has_variant', $product->has_variant ?? true))>
                    <span>Product Has Variant</span>
                </label>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2 rounded shadow transition duration-150">
                    {{ isset($product) ? 'Update Product' : 'Save Product' }}
                </button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            let initialMainCat = $('#categoryId').val();
            let selectedSubCategory = "{{ old('category_id', $product->category_id ?? '') }}";
            let schoolId = $('#school_id').val();

            // Load subcategories immediately on edit mode / validation error
            if (initialMainCat) {
                subCategory(initialMainCat, selectedSubCategory);
            }

            // When Main Category changes
            $('#categoryId').on('change', function () {
                let id = $(this).val();
                subCategory(id);
            });

            function subCategory(id, selectedSub = null) {
                let subCategorySelect = $('#subcategory_id');
                subCategorySelect.html('<option value="">Loading...</option>');

                if (!id) {
                    subCategorySelect.html('<option value="">Select Sub Category</option>');
                    return;
                }

                $.get(`/get-categories/${id}`, function (data) {
                    subCategorySelect.empty();
                    subCategorySelect.append('<option value="">Select Sub Category</option>');

                    if (data.category && data.category.children) {
                        $.each(data.category.children, function (index, item) {
                            let selected = (item.id == selectedSub) ? 'selected' : '';
                            subCategorySelect.append(
                                `<option value="${item.id}" ${selected}>${item.name}</option>`
                            );
                        });
                    }
                });
            }

            // When school changes
            $('#school_id').on('change', function () {
                let schoolId = $(this).val();
                let classSelect = $('#class_id');
                classSelect.html('<option value="">Loading...</option>');

                if (!schoolId) {
                    classSelect.html('<option value="">—</option>');
                    return;
                }

                $.get(`/get-classes/${schoolId}`, function (data) {
                    classSelect.html('<option value="">—</option>');
                    $.each(data, function (index, cls) {
                        classSelect.append(
                            `<option value="${cls.id}">${cls.name}</option>`);
                    });
                });
            });

            // Load classes on page load (edit mode)
            if (schoolId) {
                $.get(`/get-classes/${schoolId}`, function (data) {
                    let selectedClass = "{{ $product->class_id ?? '' }}";
                    let classSelect = $('#class_id');
                    classSelect.html('<option value="">—</option>');

                    $.each(data, function (index, cls) {
                        let selected = (cls.id == selectedClass) ? 'selected' : '';
                        classSelect.append(
                            `<option value="${cls.id}" ${selected}>${cls.name}</option>`);
                    });
                });
            }
        });
    </script>
@endsection