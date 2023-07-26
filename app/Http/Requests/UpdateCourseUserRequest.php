<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $billingImageUrl = '';

        if ($this->input('is_change_billing_image') === "true") {
            $billingImageUrl = 'required|file|mimes:jpg,jpeg,png';
        }

        return [
            'status' => 'required|integer|min:0|max:1',
            'is_show' => 'required|integer|min:0|max:1',
            'is_change_billing_image' => 'required',
            'billing_image_url' => $billingImageUrl
        ];
    }
}
