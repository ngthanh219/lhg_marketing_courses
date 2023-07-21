<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'limit' => 'integer|min:1',
            'offset' => 'integer|min:1',
            'id_sort' => 'string|in:desc,asc',
            'is_login' => 'integer',
            'is_deleted' => 'integer|min:0|max:1'
        ];
    }
}
