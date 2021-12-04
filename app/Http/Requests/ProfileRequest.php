<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama Wajib Diisi!',
            'name.string' => 'Nama Harus berupa Huruf!',
            'avatar.required' => 'Avatar Wajib Diisi!',
            'avatar.image' => 'Format avatar hanya : jpg,jpeg,png dan Ukuran file maksimal : 1024 Kb!',
        ];
    }
}
