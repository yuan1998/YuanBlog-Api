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

        $arr = [];
        switch($this->method()) {
            case 'POST' :
                $arr = [
                    'username' => 'string|min:6|required',
                    'password' => 'string|min:6|required',
                    'phone' => 'empty_if:sms_key|unique:users',
                    'sms_key' => 'empty_if:phone',
                    'sms_code' => 'required'
                    //
                ];
                break;
            case 'PATCH':
                $arr = [
                    'username' => 'string',
                    'email' => 'email',
                    'description' => 'string',
                    'avatar' => 'exists:images,id',
                ];
                break;
        }

        return $arr ;
    }
}
