<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UserUploadKycRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => ['required','mimes:jpeg,png,jpg,svg','max:2048'],
        ];
    }
    public function messages()
    {
        return [
            'file' => 'Formats must be jpeg,png,jpg,svg and maximum size is 2MB.',
        ];
    }
}
