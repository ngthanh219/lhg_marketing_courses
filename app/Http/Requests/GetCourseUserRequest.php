<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetCourseUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'limit' => 'integer|min:1',
            'page' => 'integer|min:1',
            'id_sort' => 'string|in:desc,asc',
            'status_sort' => 'string|in:desc,asc',
            'is_show' => 'integer|min:0|max:2',
            'is_deleted' => 'integer|min:0|max:1'
        ];
    }
}
