<?php

namespace App\Http\Requests\Admin\MTG\Set;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SeoRequest extends FormRequest

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
        $idd = $this->route('id');
        return [
            'title' => ['required','max:255',Rule::unique('mtg_sets')->ignore($idd)],
            'slug' =>  ['required','max:255',Rule::unique('mtg_sets')->ignore($idd)],
            'heading' => 'required',
            'name' => 'required',
            'sub_heading' => 'required',
            'meta_description' => 'required',
            'icon_img' => 'nullable|mimes:png,jpg,jpeg,svg|max:4096',
            'banner_img' => 'nullable|mimes:png,jpg,jpeg,svg|max:4096',
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
        'name.required' => 'Set Name is required',
        'meta_description.required' => 'Meta Description is required',
        'slug.required' => 'URL is required',
        'slug.unique' => 'URL must be Unique',
        'sub_heading.required' => 'Sub Heading is required',
        'icon_img.mimetypes' => 'Icon Type must be in png,jpg,jpeg,gif,svg',
        'banner_img.mimes' => 'Banner Image Type must be in png,jpg,jpeg,gif,svg',
    ];
  }
}
