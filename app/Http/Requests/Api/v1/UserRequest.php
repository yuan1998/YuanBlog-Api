<?php

namespace App\Http\Requests\Api\v1;

use Dingo\Api\Http\FormRequest;

class UserRequest extends FormRequest
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
        return [
            'username' => 'string|min:6|required',
            'password' => 'string|min:6|required',
            'sms_key' => 'required',
            'sms_code' => 'required'
            //
        ];
    }
}
