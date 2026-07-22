<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderCheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'customer_name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'max:255',
            ],

            'mobile' => [
                'required',
                'regex:/^(03[0-9]{9}|\+923[0-9]{9})$/',
            ],

            'shipping_zone_id' => [
                'required',
                'exists:shipping_zones,id',
            ],
            'address' => [
                'required',
                'string',
                'min:10',
                'max:1000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Please enter your full name.',

            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',

            'mobile.required' => 'Please enter your mobile number.',
            'mobile.regex' => 'Please enter a valid Pakistani mobile number (e.g. 03XXXXXXXXX).',

            'shipping_zone_id.required' => 'Please select your province.',
            'shipping_zone_id.exists' => 'The selected province is invalid.',

            'shipping_rate_id.required' => 'Please select a shipping method.',
            'shipping_rate_id.exists' => 'The selected shipping method is invalid.',

            'address.required' => 'Please enter your complete address.',
            'address.min' => 'Please enter a more complete delivery address.',
        ];
    }
}
