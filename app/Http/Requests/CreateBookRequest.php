<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'introduction' => 'max:500',
            'image_url' => 'file|mimes:jpg,jpeg,png|max:600',
            'price' => 'required|integer|min:0',
            'discount' => 'required|integer|min:0|between:0,100',
            'is_show' => 'required|integer|min:0|max:1'
        ];
    }
}
