<?php

namespace App\Providers;

use App\Validations\EmptyValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Validator::resolver(function($translator, $data, $rules, $messages, $attributes)
        {
            return new EmptyValidator($translator, $data, $rules, $messages, $attributes);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

    }
}
