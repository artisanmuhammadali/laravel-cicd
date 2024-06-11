<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupportRequest extends FormRequest
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
            'category' => 'required|max:255',
            'subject' => 'required|max:255',
            'issue' => 'required',
            'terms' => 'required|max:255',
            'g-recaptcha-response' => 'required',
            'email' => 'required',
            'attachment_file' => ['mimes:jpeg,png,jpg','max:2048'],
        ];
    }
    public function messages()
    {
        return [
            'attachment_file.mimes' => 'Formats must be jpeg,png,jpg and maximum size is 2MB.',
        ];
    }
}
