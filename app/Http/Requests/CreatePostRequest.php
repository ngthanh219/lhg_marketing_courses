<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'image_url' => 'file|mimes:jpg,jpeg,png',
            'is_show' => 'required|integer|min:0|max:1'
        ];
    }
}
