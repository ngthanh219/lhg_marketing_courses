<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/(0)[0-9]{9}/|max:10',
            'is_login' => 'required|integer|min:0|max:1',
            'role_id' => 'required|integer|min:0|max:1',
            'is_change_password' => 'required',
            'password' => 'required_if:is_change_password,==,1|min:6|max:25',
            'email_verified_at' => 'required|integer|min:0|max:1',
        ];
    }
}
