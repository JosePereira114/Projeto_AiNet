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
        'type' => 'string|in:C', // Adicione outras opções se necessário
        'photo_filename' => 'nullable|string|max:255', // ou outros critérios de validação para foto
        ];
    }
}