<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
class AddressRequest extends FormRequest
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
        return  [
            'name' => ['required','regex:/^[A-Za-z0-9]+$/'],
            'postal_code' => ['required'],
            'street_number' => ['required'],
            'city' => ['required'],
            'type' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'name.regex' => 'No space and special characters.',
        ];
    }
}
