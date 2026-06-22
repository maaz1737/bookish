<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
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
}
