<?php

namespace App\Http\Requests\Admin\SW;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Admin\SW\ExpansionRequest;

class ExpansionRequest extends FormRequest
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
            'name' => 'required|max:255|min:3|unique:sw_sets,name,',
            'published_at' => 'required',
            'code' => 'required',
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'name' => 'Max:255 and Min:3 Unique in StarwarExpansions',
            'published_at.required' => 'Release Date is required',
        ];
    }
}
