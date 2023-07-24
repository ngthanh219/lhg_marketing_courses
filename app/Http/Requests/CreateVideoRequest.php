<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVideoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'course_section_id' => 'required|integer|min:1',
            'description' => 'max:1000',
            'source' => 'file|mimes:mp4,avi,mov,wmv',
            'duration' => 'integer|min:0',
            'is_show' => 'required|integer|min:0|max:1'
        ];
    }
}
