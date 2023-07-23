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
        $source = '';

        if ($this->input('is_change_video') === "true") {
            $source = 'required|file|mimes:mp4,avi,mov,wmv';
        }

        return [
            'course_section_id' => 'required|integer|min:1',
            'description' => 'max:1000',
            'is_change_video' => 'required',
            'source' => $source,
            'duration' => 'required|integer|min:0',
            'is_show' => 'required|min:0|max:1'
        ];
    }
}
