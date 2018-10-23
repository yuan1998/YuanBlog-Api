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

$api->version( 'v1', [
    'namespace' => "App\Http\Controllers\Api\\v1",
    'middleware' => ["serializer:array",'bindings'],
], function($api) {

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires'),
    ],function ($api) {

        // Get All Cat
        $api->get('category','CategoryController@index')
            ->name('api.cat.index');
        $api->get('category/tree','CategoryController@tree')
            ->name('api.cat.tree');
        $api->get('category/{category}','CategoryController@show')
            ->name('api.cat.show');
        $api->get('category/{category}/tree','CategoryController@showTree')
            ->name('api.cat.showTree');


        $api->get('posts','PostController@index')
            ->name('api.post.index');
        $api->get('posts/{post}','PostController@show')
            ->name('api.post.show');


        $api->get('tags/{tagIndex}/post','TagController@post')
            ->name('api.tags.post');


        /**
         *  登录才能调用的接口.
         */
        $api->group([
            'middleware' => 'api.auth'
        ],function ($api) {

            // Create Cat
            $api->post('category','CategoryController@store')
                ->name('api.cat.store');
            $api->patch('category/{category}','CategoryController@store')
                ->name('api.cat.update');
            $api->delete('category/{category}','CategoryController@destroy')
                ->name('api.cat.destroy');

            // Tag
            $api->post('tag','TagController@store')
                ->name('api.tag.store');
            $api->delete('tag/{tag}','TagController@destroy')
                ->name('api.tag.destroy');




            $api->post('post','PostController@store')
                ->name('api.post.store');
            $api->patch('post/{post}','PostController@update')
                ->name('api.post.update');
            $api->delete('post/{post}','PostController@destroy')
                ->name('api.post.destroy');

            $api->post('images','ImageController@store')
                ->name('api.image.store');

        });


    });


    /**
     * 有限制的接口.
     *
     */
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function ($api) {

        // 注册
        $api->post('user', "UserController@store")
            ->name('user.store');

        //发送短信验证码
        $api->post('sms','SmsController@store')
            ->name('sms.send');

        // Log in
        $api->post('auth','AuthController@store')
            ->name('api.auth.store');


        /**
         *  登录才能调用的接口.
         */
        $api->group([
            'middleware' => 'api.auth'
        ],function ($api) {

            // check is Log
            $api->get('user','UserController@me')
                ->name('api.user.me');

            $api->patch('user','UserController@update')
                ->name('api.user.me');

            //  刷新 Token
            $api->put('auth/current','AuthController@update')
                ->name('api.auth.update');

            // 删除Token
            $api->delete('auth/current','AuthController@destroy')
                ->name('api.auth.destroy');

        });




    });



});
