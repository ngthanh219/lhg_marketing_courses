<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            'slogan' => 'max:255',
            'introduction' => 'max:1000',
            'is_change_image' => 'required',
            'image_url' => $image,
            'price' => 'required|integer|min:0',
            'discount' => 'required|integer|min:0|between:0,100',
            'is_show' => 'required|integer|min:0|max:1'
        ];
    }
}
