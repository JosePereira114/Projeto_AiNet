<?php

namespace App\Http\Requests;

use App\Models\Theater;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TheaterFormRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:theaters,name,'.($this->theater?$this->theater->id:null),
            'photo_filename' => 'sometimes|image|max:4096', // maxsize = 4Mb
            'num_seats' => 'required|integer|min:1|max:260',
        ];
    }
}
