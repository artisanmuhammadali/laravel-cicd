<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\UserStore as Store;

class SellerAccountRequest extends FormRequest
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
        if(request()->type == "business"){
            return [
                'company_name' => ['required', 'string','min:4', 'max:30','unique:'.Store::class],
                'company_no' => ['required', 'string','min:4', 'max:30','unique:'.Store::class],
                'telephone' => ['required', 'string','min:10', 'max:20'],
                // 'photo_id_scan' => ['required','mimes:jpeg,png,jpg,svg','max:2048'],
                'city_of_birth' => ['required'],
                'street_number' => ['required', 'string','min:4'],
                'city' => ['required', 'string'],
                'country' => ['required', 'string'],
                'postal_code' => ['required', 'string','min:4'],
            ];
        }
        else{
            return [
                'street_number' => ['required', 'string','min:4'],
                'city' => ['required', 'string'],
                'country' => ['required', 'string'],
                'postal_code' => ['required', 'string','min:4'],
            ];
        }
    }
    public function messages()
  {
    return [
        'photo_id_scan.mimes' => 'Formats must be jpeg,png,jpg,svg and maximum size is 2MB.',
        'company_trade.mimes' => 'Formats must be jpeg,png,jpg,svg and maximum size is 2MB.',
    ];
  }
}
