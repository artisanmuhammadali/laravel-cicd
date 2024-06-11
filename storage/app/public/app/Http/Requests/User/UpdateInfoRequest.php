<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class UpdateInfoRequest extends FormRequest
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
            'dob'=>'nullable|date_format:Y/m/d|before:'.now()->subYears(18)->toDateString(),
            'telephone'=>'nullable|numeric',
            'email' => ['nullable','email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }
    public function messages()
    {
        return [
            'dob.before' => 'Date of birth should be 18 year old',
            'dob.date_format' => 'Date of birth must match the format Y/m/d',
        ];
    }
}
