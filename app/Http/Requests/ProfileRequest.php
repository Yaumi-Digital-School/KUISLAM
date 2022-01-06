<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        // dd($request->username);
        $rules = [
            'name'      => ['required', 'string', 'max:255'],
            'username'  => ['required', 'string', 'max:255', 'alpha_dash'],
            'avatar'    => ['image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ];
        if($request->username !== Auth::user()->username){
            $rules['username'] = ['required', 'string', 'max:255', 'alpha_dash', 'unique:users,username'];
        }
        return $rules;
    }
}
