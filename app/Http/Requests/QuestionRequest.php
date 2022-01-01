<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'quiz_id'   => ['required', 'exists:quizzes,id'],
            'question'  => ['required', 'max:255'],
            'image'     => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'option_1'  => ['required', 'max:255'],
            'option_2'  => ['required', 'max:255'],
            'option_3'  => ['required', 'max:255'],
            'option_4'  => ['required', 'max:255'],
            'answer'    => ['required'],
            'timer'     => ['required', 'numeric', 'min:15', 'max:60'],
        ];
    }
}
