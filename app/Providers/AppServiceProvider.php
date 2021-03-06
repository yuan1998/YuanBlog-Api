<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Observers\CategoryObserver;
use App\Observers\PostObserver;
use App\Observers\TagObserver;
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
        \Carbon\Carbon::setLocale('zh');

        Post::observe(PostObserver::class);
        Category::observe(CategoryObserver::class);
        Tag::observe(TagObserver::class);

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
        \API::error(function (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            abort(404);
        });

        \API::error(function (\Illuminate\Auth\Access\AuthorizationException $exception) {
            abort(403, $exception->getMessage());
        });
    }
}
