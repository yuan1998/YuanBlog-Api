<?php

namespace App\Observers;

use App\Http\Controllers\Api\v1\TagController;
use App\Models\Post;
use App\Models\Tag;

class PostObserver
{


    public function saving(Post $post)
    {
        $post->excerpt = make_excerpt($post->body);

    }

    public function saved(Post $post)
    {
        if (request()->has('tags')) {
            $tags        = explode(',', request()->get('tags'));
            $tags        = collect($tags);
            $articleTags = Tag::query()
                ->where('article_id', $post->id)
                ->get()
                ->pluck('title')
                ->flatten();

            $deleteId = $articleTags->diff($tags);
            $saveId   = $tags->diff($articleTags);

            !$deleteId->isEmpty() && TagController::deleteArticleTag($deleteId->toArray(), $post->id);
            !$saveId->isEmpty() &&  TagController::createTag($saveId->toArray(), $post->id);
        }
    }


    /**
     * Handle the post "deleted" event.
     *
     * @param  \App\Models\Post $post
     * @return void
     */
    public function deleting(Post $post)
    {
        $id = Tag::query()->where('article_id', $post->id)->get()->pluck('id');

        TagController::deleteTags($id->implode(''));
    }


}
