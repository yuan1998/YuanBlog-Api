<?php

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = '1';
        $cats = \App\Models\Catagory::all()->pluck('id')->toArray();

        $faker = app(Faker\Generator::class);

        $posts = factory(Post::class)
                ->times(100)
                ->make()
                ->each(function ($post , $index) use ($users , $cats,$faker) {
                    $post->user_id = $users;
                    $post->category_id = $faker->randomElement($cats);
                });

        Post::insert($posts->toArray());
    }
}
