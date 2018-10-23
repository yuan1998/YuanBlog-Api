<?php

namespace App\Http\Requests\Api\v1;

use Dingo\Api\Http\FormRequest;

class PostRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title'       => 'string',
            'description' => 'string',
            'body'        => 'string',
            'image'       => 'mimes:jpeg,bmp,png,gif',
            'category_id' => 'exists:categories,id',
            'tags'        => 'string'
        ];

        switch ($this->method()) {
            case "POST" :
                $rules['title']       .= '|required';
                $rules['description'] .= '|required';
                $rules['body']        .= '|required';
                $rules['image']       .= '|required';
                $rules['category_id'] .= '|required';
                break;
        }
        return $rules;
    }

}
