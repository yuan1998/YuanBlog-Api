<?php

namespace App\Transformers;

use App\Models\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user','category'];

    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'description' => $post->description,
            'excerpt' => $post->excerpt,
            'user_id' => $post->user_id,
            'category_id' => $post->category_id,
            'create_at' => $post->created_at->toDateTimeString(),
            'updated_at' => $post->updated_at->toDateTimeString(),
        ];
    }

    public function includeUser (Post $post)
    {
        return $this->item($post->user , new UserTransformer());
    }

    public function includeCategory (Post $post)
    {
        return $this->item($post->category, new CategoryTransformer());
    }

}