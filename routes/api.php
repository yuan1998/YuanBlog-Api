<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version( 'v1', ['namespace' => "App\Http\Controllers\Api\\v1"], function($api) {

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function ($api) {

        $api->post('user', "UserController@store")
            ->name('user.store');

        $api->post('sms','SmsController@store')
            ->name('sms.send');



        // Log in
        $api->post('auth','AuthController@store')
            ->name('api.auth.store');

        //  刷新 Token
        $api->put('auth/current','AuthController@update')
            ->name('api.auth.update');

        // 删除Token
        $api->delete('auth/current','AuthController@destroy')
            ->name('api.auth.destroy');

    });



});
