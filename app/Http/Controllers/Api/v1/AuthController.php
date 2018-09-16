<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\AuthRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{



    public function store (AuthRequest $request)
    {

        $username = $request->username;

        filter_var($username,FILTER_VALIDATE_EMAIL) ?
            $data['email'] = $username :
            $data['username'] = $username ;

        $data['password'] = $request->password;

        if( ! $token = \Auth::guard('api')->attempt($data))
            return $this->response->errorUnauthorized('用户名密码错误');

        return $this->responseWithToken($token)->setStatusCode(201);

    }


    public function update ()
    {
        $token = \Auth::guard('api')->refresh();

        return $this->responseWithToken($token);
    }

    public function destroy ()
    {
        \Auth::guard('api')->logout();
        return $this->response->noContent();
    }


    public function checkLogin () {
        return $this->response->array(\Auth::guard('api')->user());
    }

    public function responseWithToken ($token)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60,
        ]);
    }



}
