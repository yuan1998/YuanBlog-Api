<?php

namespace App\Http\Requests\Api\v1;

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
     * @return array
     */
    public function rules()
    {
        $size = $this->size;
        $rules = [
            "type" => 'required|in:avatar,post',
            'size' => 'string'
        ];

        if ($this->type == 'avatar') {
            $rules['image'] = "required|mimes:jpeg,bmp,png,gif|dimensions:min_width=$size,min_height=$size";
        } else {
            $rules['image'] = 'required|mimes:jpeg,bmp,png,gif';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'image.dimensions' => "图片的清晰度不够，宽和高需要 {$this->size}px 以上",
        ];
    }
}
