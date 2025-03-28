<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CartConfirmationFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
        'customer_email' => 'required|email|max:255',
        'customer_nif' => 'required|numeric',
        'payment_type' => 'required|string|in:VISA,PAYPAL,MBWAY',
        'payment_ref' => [
                'nullable',
                Rule::requiredIf(function () {
                    return in_array($this->payment_type, ['VISA', 'MBWAY', 'PAYPAL']);
                }),
                Rule::when($this->payment_type === 'VISA', ['digits:16']),
                Rule::when($this->payment_type === 'MBWAY', ['digits:9']),
                Rule::when($this->payment_type === 'PAYPAL', ['email']),
            ],
        ];
    }
}
