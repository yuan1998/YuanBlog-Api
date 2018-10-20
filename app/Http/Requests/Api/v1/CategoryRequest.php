<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $result = [
            'title'       => 'string',
            'description' => 'string',
            'title_en'    => 'string',
            'parent_id'   => 'cat_parent',
        ];

        switch (request()->method()) {
            case 'POST' :
                $result['title']       .= '|required';
                $result['description'] .= '|required';
                break;
        }

        return $result;
    }
}
