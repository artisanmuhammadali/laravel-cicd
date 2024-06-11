<?php

namespace App\Http\Requests\Admin\MTG;

use Illuminate\Foundation\Http\FormRequest;

class SetsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255|min:3|unique:mtg_sets,name,',
            'released_at' => 'required',
            'code' => 'required',
            'icon_img' => 'nullable|mimes:png,jpg,jpeg,gif,svg |max:4096',
            'banner_img' => 'nullable|mimes:png,jpg,jpeg,gif,svg |max:4096',
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
            'released_at.required' => 'Release Date is required',
            'icon_img.mimes' => 'Icon Type must be in png,jpg,jpeg,gif,svg',
            'banner_img.mimes' => 'Banner Image Type must be in png,jpg,jpeg,gif,svg',
        ];
    }
}
