<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $image = '';

        if ($this->input('is_change_image') === "true") {
            $image = 'required|file|mimes:jpg,jpeg,png';
        }

        return [
            'name' => 'required|max:255',
            'is_change_image' => 'required',
            'image_url' => $image,
            'is_show' => 'required|integer|min:0|max:1'
        ];
    }
}
