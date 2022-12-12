<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules=  [
            'name'=>'required|string|max:255',
            'image'=>'required|mimes:jpeg,jpg,png|max:2048'
        ];

        if(in_array($this->method(),['PUT','PATCH'])){
            $rules['image'] = 'nullable|mimes:jpeg,jpg,png|max:2048';
        }

        return $rules;
    }
}
