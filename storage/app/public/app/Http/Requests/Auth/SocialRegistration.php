<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class SocialRegistration extends FormRequest
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
                'user_name' => ['required','regex:/^[A-Za-z0-9]+$/', 'string','min:4', 'max:20', 'unique:'.User::class],
                'hear_about_us' => ['required', 'string', 'max:255','regex:/^[a-zA-Z0-9\s]+$/'],
                'dob' => 'required|date|date|date_format:Y-m-d|before:'.now()->subYears(18)->toDateString(). '|after:' .now()->subYears(100)->toDateString(),
            ];
    }
    public function messages()
    {
        return [
            'user_name.regex' => 'Minimum 4 and maximum 20 letters or numbers, no space and special characters.',
            'hear_about_us.regex' => 'Special character are not allowed.',
            'dob.before' => 'Date of birth should be 18 year old',
            'dob.after' => 'Your age should be maximum 100 year older',
            'dob.date_format' => 'Date of birth must be valid',
            'dob.date' => 'Date of birth must be valid',
        ];
    }
}
