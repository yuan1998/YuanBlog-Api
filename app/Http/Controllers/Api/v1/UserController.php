<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Images;
use App\Transformers\UserTransformer;
use App\Http\Requests\Api\v1\UserRequest;
use App\Models\User;


class UserController extends Controller
{

    public function store(UserRequest $request)
    {

        $phoneData = !app()->environment('production')
            ? [
                'phone' => $request->phone,
                'code'  => '1234',
            ] :
            \Cache::get($request->sms_key);


        if (!$phoneData)
            return $this->response->error('验证码已经失效', 422);

        if (!hash_equals($phoneData['code'], $request->sms_code))
            return $this->response->errorUnauthorized('验证码错误');

        $user = user::create([
            'username' => $request->username,
            'phone'    => $phoneData['phone'],
            'password' => bcrypt($request->password)
        ]);

        \Cache::forget($request->sms_key);

        return $this->response
            ->item($user, new UserTransformer())
            ->setMeta([
                'access_token' => \Auth::guard('api')->fromUser($user),
                'token_type'   => 'Bearer',
                'expires_in'   => \Auth::guard('api')->factory()->getTTL() * 60
            ])
            ->setStatusCode(201);
    }


    public function update(UserRequest $request)
    {
        $user = $this->user();

        $attr = $request->only(['username', 'description', 'email']);

        if ($path = $this->avatarOrImage($request, $user)) {
            $attr['avatar'] = $path;
        }

        $user->update($attr);
        return $this->response->item($user, new UserTransformer());
    }


    public function avatarOrImage($request, $user)
    {
        $image  = $request->image;
        $avatar = $request->avatar;

        if (!$image && !$avatar)
            return false;

        if (!empty($image)) {
            $r = ImageController::createImage($user->id, $image, 'avatar', $request->size);
        } elseif ($avatar) {
            $r = Images::find($avatar);
        }

        return empty($r['path']) ? false : $r['path'];
    }


    public function me()
    {
        return $this->response->item($this->user(), new UserTransformer());
    }


}
