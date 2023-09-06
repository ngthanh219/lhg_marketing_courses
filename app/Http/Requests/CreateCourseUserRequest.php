<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCourseUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|integer|min:1',
            'course_id' => 'required|integer|min:1',
            'status' => 'required|integer|min:0|max:1',
            'is_show' => 'required|integer|min:0|max:1',
            'billing_image_url' => 'file|mimes:jpg,jpeg,png|max:600'
        ];
    }
}
