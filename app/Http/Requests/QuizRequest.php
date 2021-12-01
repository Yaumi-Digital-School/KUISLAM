<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul Wajib Diisi!',
            'title.string' => 'Judul Harus berupa Huruf!',
            'image.required' => 'Gambar Wajib Diisi!',
            'image.image' => 'Format gambar hanya : jpg,jpeg,png dan Ukuran file maksimal : 1024 Kb!',
        ];
    }
}
