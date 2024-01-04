<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterBookRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'book_id' => 'required|integer|min:1',
            'name' => 'required|max:100',
            'email' => [
                'required',
                'email',
                'max:100',
                'regex:/^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'phone' => 'required|regex:/(0)[0-9]{9}/|max:10',
            'note' => 'nullable|max:255'
        ];
    }
}
