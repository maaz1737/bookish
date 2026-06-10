<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBundleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'school_id'          => ['required', 'exists:schools,id'],
            'class_id'           => ['required', 'exists:school_classes,id'],
            'discount'           => ['required', 'numeric', 'min:0', 'max:100'],
            'is_active'          => ['boolean'],
            'items'              => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity'   => ['required', 'integer', 'min:1'],
        ];
    }
}
