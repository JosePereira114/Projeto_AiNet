<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerFormRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'nullable|string|min:3',
            'nif' => 'nullable|integer|digits:9|unique:customers',
            'payment_type' => 'required|string|in:VISA,PAYPAL,MBWAY',
            'type' => 'string|in:C',
            'photo_filename' => 'nullable|string|max:255',
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
