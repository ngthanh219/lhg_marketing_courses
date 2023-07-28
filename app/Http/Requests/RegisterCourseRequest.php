<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'description' => 'max:255',
            'billing_image_url' => 'file|mimes:jpg,jpeg,png'
        ];
    }
}
