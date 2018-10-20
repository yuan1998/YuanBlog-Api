<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\SmsRequest;
use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;

class SmsController extends Controller
{
    //
    public function store (SmsRequest $request , EasySms $easySms)
    {

        $phone = $request['phone'];

        if (app()->environment('production')) {
            $code = '1234';
        } else {
            // 生成4位随机数，左侧补0
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

            try {
                $result = $easySms->send($phone, [
                    'content'  =>  "【哔里哔气】您的验证码是{$code}。如非本人操作，请忽略本短信"
                ]);
            } catch (\GuzzleHttp\Exception\ClientException $exception) {
                $response = $exception->getResponse();
                $result = json_decode($response->getBody()->getContents(), true);
                return $this->response->errorInternal($result['msg'] ?? '短信发送异常');
            }
        }

        $key = 'Sms_' . str_random(17);
        $expiredAt = now()->addMinutes(10);

        // 缓存验证码 10分钟过期。
        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);


        return $this->response->array([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);

    }

}
