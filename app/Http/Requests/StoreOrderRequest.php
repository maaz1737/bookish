<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Guest checkout is always allowed (Section 5.1)
    }

    public function rules(): array
    {
        return [
            'customer_name'        => ['required', 'string', 'max:255'],
            'mobile'               => ['required', 'string', 'max:50'],
            'address'              => ['required', 'string', 'max:1000'],
            'items'                => ['required', 'array', 'min:1'],
            'items.*.type'         => ['required', 'in:product,bundle'],
            'items.*.id'           => ['required', 'integer'],
            'items.*.quantity'     => ['required', 'integer', 'min:1'],
        ];
    }
}
