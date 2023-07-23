<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCourseSectionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'course_id' => 'required|integer|min:1',
            'name' => 'required|max:255',
            'description' => 'max:1000',
            'is_show' => 'required|min:0|max:1'
        ];
    }
}
