<?php

namespace App\Http\Requests;

use App\Libraries\Constant;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVideoRequest extends FormRequest
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
            'source' => 'nullable',
            'duration' => 'required|integer|min:0',
            'is_show' => 'required|integer|min:0|max:1'
        ];
    }
}
