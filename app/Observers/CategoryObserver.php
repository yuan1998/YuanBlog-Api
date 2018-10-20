<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\Post;

class CategoryObserver
{

    /**
     * Handle the post "deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function deleting(Category $category)
    {
        $posts = Post::where('category_id' , $category->id)->update(['article_status'=> -1]);

    }

}
