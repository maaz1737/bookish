<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        $categoryType = optional(
            \App\Models\Category::find($this->input('category_id'))
        )->type;

        return [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'sub_category_id' => [
                'nullable',
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->where('parent_id', request('category_id'));
                }),
            ],
            'school_id' => [
                'nullable',
                'exists:schools,id',
                'required_with:class_id',
            ],

            'class_id' => [
                'nullable',
                'exists:school_classes,id',
            ],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'stock' => ['required', 'integer', 'min:0'],
            'low_stock_threshold' => ['nullable', 'integer', 'min:0'],
            'publisher' => ['nullable', 'string', 'max:255'], // books only; hidden publicly
            // Uniform variants are strictly required for uniform category (Section 6.2)
            'size' => [Rule::requiredIf($categoryType === 'uniform'), 'nullable', 'string', 'max:50'],
            'gender' => [Rule::requiredIf($categoryType === 'uniform'), 'nullable', Rule::in(['boys', 'girls', 'unisex'])],
            'description' => ['nullable', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active' => ['boolean'],
            'is_best_seller' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active'),
            'is_best_seller' => $this->has('is_best_seller'),
        ]);
    }

    public function messages(): array
    {
        return [
            'school_id.required_with' => 'Please select a school before selecting a class.',
        ];
    }
}
