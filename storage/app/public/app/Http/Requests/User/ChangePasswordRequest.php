<?php

namespace App\Http\Requests\User;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'password' => ['required', 'confirmed',  'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/','min:8','max:20', 'different:current_password'],
            'current_password' => ['required','min:8','max:20' , new MatchOldPassword],
        ];
    }
    public function messages()
  {
    return [
        'password.regex' => 'Minimum 8 character. Must contain atleast a capital letter a numerical character and a symbol.',
    ];
  }
}
