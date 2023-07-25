<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|max:25',
            'phone' => 'required|regex:/(0)[0-9]{9}/|max:10',
            "verification_code" => 'required|regex:/[0-9]{5}/|max:5',
        ];
    }
}
