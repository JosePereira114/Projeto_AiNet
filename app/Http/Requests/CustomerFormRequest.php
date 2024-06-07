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
    public function rules(): array
    {
        return [
            'nif' => 'sometimes|number|max:9|unique:customers,',
            'payment_type' => 'string|max:20',
            'payment_reference' => 'sometimes|string|max:20', 
        ];
    }
}
