<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SaveCollectionRequest extends FormRequest
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
        if($this->form_type != "publish" && $this->form_type != "bulk" && $this->form_type != "csv"){
            return [
                'price'=>'required|numeric|min:0.01',
                'quantity'=>'required||numeric|min:1',
                'photo' => ['mimes:jpeg,png,jpg','max:5048'],
            ];
        }
        return [];
    }
    public function messages()
    {
        return [
            'photo.mimes' => 'Formats must be jpeg,png,jpg and maximum size is 5MB.',
        ];
    }
}
