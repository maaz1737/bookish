<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::with('values')->latest()->get();
        return view('admin.attribute.attribute', compact('attributes'));
    }

    public function create()
    {
        return view('admin.attribute.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:attributes,name']
        ]);

        $attribute = Attribute::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);

        return redirect()->route('admin.attributes.value.create', [
            'attribute' => $attribute->id
        ])->with('success', 'Attribute created successfully');
    }

    public function show(Attribute $attribute)
    {
        $attribute->load('values');
        return view('admin.attribute.show', compact('attribute'));
    }

    public function edit(Attribute $attribute)
    {
        $attribute->load('values');

        return view('admin.attribute.edit', compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:attributes,name,' . $attribute->id,
        ]);

        $attribute->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribute updated successfully');
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return back()->with('success', 'Attribute deleted');
    }

    public function attributeValue(Attribute $attribute)
    {

        return view('admin.attributeValue.attribute_value', compact('attribute'));
    }
    public function attributeValueStore(Request $request, Attribute $attribute)
    {

        $request->validate([
            'values' => ['required', 'array'],
            'values.*' => ['required', 'string', 'max:255'],
        ]);


        foreach ($request->values as $value) {
            $attribute->values()->create([
                'value' => $value,
                'slug' => Str::slug($value),
            ]);
        }

        return redirect()
            ->route('admin.attributes.index')
            ->with('success', 'Attribute values added successfully');
    }

    public function attributeValueDestroy(AttributeValue $value)
    {
        $value->delete();
        return back()->with('success', 'Value Deleted Successfully');
    }
    public function attributeValueEdit(Attribute $attribute, AttributeValue $value)
    {

        return view('admin.attributeValue.edit', compact('attribute', 'value'));
    }
    public function attributeValueUpdate(AttributeValue $value, Request $request)
    {
        $request->validate([
            'value' => ['required', 'string']
        ]);
        $value->update([
            'value' => $request->input('value'),
            'slug' => Str::slug($request->input('value')),
        ]);

        return redirect()->route('admin.attributes.edit', $value->attribute->id);
    }


    public function attributeSelection(Product $product)
    {
        $attributes = Attribute::with('values')->get();
        return view('admin.attribute.product_attribute_selection', compact('product', 'attributes'));

    }
    public function ProductAttributeStore(Product $product, Request $request)
    {
        $request->validate([
            'attribute_ids' => ['required', 'array', 'min:1'],
            'attribute_ids.*' => ['integer', 'exists:attributes,id'],
        ], [
            'attribute_ids.required' => 'Please select at least one attribute.',
            'attribute_ids.min' => 'Please select at least one attribute.',
        ]);

        $product->attributes()->sync($request->attribute_ids);

        return redirect()->route('admin.products.attributes.value.select', $product->slug);

    }
    public function attributeValueSelection(Product $product)
    {



        $product->attributes;

        return view('admin.attributeValue.attribute_value_select', compact('product'));


    }

    public function ProductVariantStore(Product $product, Request $request)
    {
        $attributes = $request->input('attribute_values');
        $request->validate([
            'attribute_values' => ['required', 'array'],
            'attribute_values.*' => ['required', 'array', 'min:1'],
            'attribute_values.*.*' => ['integer', 'exists:attribute_values,id'],
        ], [
            'attribute_values.required' => 'Please select values for all attributes.',
            'attribute_values.*.required' => 'Please select at least one value for each attribute.',
            'attribute_values.*.min' => 'Please select at least one value for each attribute.',
        ]);

        $price = $request->input('price');
        $stock = $request->input('stock');

        $combinations = $this->buildCombinations($attributes);

        // Get all value names in one query
        $valueIds = collect($attributes)->flatten()->unique()->toArray();

        $attributeValues = AttributeValue::whereIn('id', $valueIds)
            ->pluck('value', 'id')
            ->toArray();

        $createdVariants = [];

        foreach ($combinations as $combination) {

            $skuParts = [];

            foreach ($combination as $valueId) {
                $skuParts[] = $attributeValues[$valueId] ?? $valueId;
            }

            // red-large
            $sku = Str::slug(implode('-', $skuParts));

            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'sku' => $sku,
                'price' => $price,
                'stock' => $stock,
            ]);

            $createdVariants[] = $variant;
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', count($createdVariants) . ' variants created successfully.');
    }

    private function buildCombinations($arrays)
    {
        $result = [[]];

        foreach ($arrays as $values) {

            $tmp = [];

            foreach ($result as $resultItem) {

                foreach ($values as $value) {

                    $tmp[] = array_merge($resultItem, [$value]);
                }
            }

            $result = $tmp;
        }

        return $result;
    }
}
