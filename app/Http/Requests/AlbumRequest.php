<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
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


        if(in_array($this->method(),['PUT','PATCH'])){
            return ['name'=>'required|string|max:255'];
        }
        return [
            'name'=>'required|string|max:255',
            'arr_numbers' => 'required|string',
        ];


    }

    public function messages()
    {
        return [
            'required'=>"The filed is required",
        ];
    }
}
