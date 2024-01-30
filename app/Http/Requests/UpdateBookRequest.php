<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('id');
        $book = Book::find($id);
        $image = 'array';
        $imageItem = 'file|mimes:jpg,jpeg,png|max:600';

        if (!$book->image || ($this->input('remove_image') && count((array) $book->image) == count($this->input('remove_image')))) {
            $image .= '|required';
            $imageItem .= '|required';
        }

        return [
            'name' => 'required|max:255',
            'introduction' => 'max:500',
            'image' => $image,
            'image.*' => $imageItem,
            'price' => 'required|integer|min:0',
            'discount' => 'required|integer|min:0|between:0,100',
            'is_show' => 'required|integer|min:0|max:1'
        ];
    }
}
