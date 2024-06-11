<?php

namespace App\Http\Requests\Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use App\Models\User;

class RegisterRequest extends FormRequest
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
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class ,'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                'password' => ['required', 'confirmed',  'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/','min:8','max:20'],
                'first_name' => ['required','regex:/^[a-zA-Z\-\s\']+$/', 'string','min:3', 'max:20'],
                'last_name' => ['required','regex:/^[a-zA-Z\-\s\']+$/', 'string','min:3', 'max:20'],
                'hear_about_us' => ['required', 'string', 'max:255','regex:/^[a-zA-Z0-9\s]+$/'],
                'g-recaptcha-response' => ['required'],
                'dob' => 'required|date|date|date_format:Y-m-d|before:'.now()->subYears(18)->toDateString(). '|after:' .now()->subYears(100)->toDateString(),
            ];
    }
  public function messages()
  {
    return [
        'password.regex' => 'Minimum  8 characters, at least 1 uppercase, 1 lowercase letter, 1 number, 1 special character.',
        'email.regex' => 'Must enter a valid email address',
        'user_name.regex' => 'Minimum 4 and maximum 20 letters or numbers, no space and special characters.',
        'first_name.regex' => 'Minimum 3 and maximum 20 , no number and special characters.',
        'last_name.regex' => 'Minimum 3 and maximum 20 , no number and special characters.',
        'hear_about_us.regex' => 'Special character are not allowed.',
        'dob.before' => 'Date of birth should be 18 year old',
        'dob.after' => 'Your age should be maximum 100 year older',
        'dob.date_format' => 'Date of birth must be valid',
        'dob.date' => 'Date of birth must be valid',
    ];
  }
}
