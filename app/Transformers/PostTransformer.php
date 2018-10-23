<?php

namespace App\Transformers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user', 'category' , 'tags'];

    public $type;

    public function __construct($type = 'default')
    {
        $this->type = $type;
    }

    public function transform(Post $post)
    {
        $result = [
            'id'             => (int) $post->id,
            'title'          => (string) $post->title,
            'description'    => (string) $post->description,
            'excerpt'        => (string) $post->excerpt,
            'user_id'        => (int) $post->user_id,
            'read_count'     => (int) $post->read_count,
            'like_count'     => (int) $post->like_count,
            'reply_count'    => (int) $post->reply_count,
            'category_id'    => (int) $post->category_id,
            'article_status' => (int) $post->article_status,
            'slug_title'     => (string) $post->slug_title,
            'cover'          => Storage::url($post->cover),
            'create_at'      => $post->created_at->toDateTimeString(),
            'updated_at'     => $post->updated_at->toDateTimeString(),
            'cover_other'    => $post->cover_other,
            'other'          => $post->other,
        ];

        switch ($this->type) {
            case 'info' :
                $result['body'] = $post->body;
                break;
        }

        return $result;
    }

    public function includeUser(Post $post)
    {
        return $this->item($post->user, new UserTransformer());
    }

    public function includeCategory(Post $post)
    {
        if($post->category_id === null) {
            return null;
        }else {
            return $this->item($post->category, new CategoryTransformer());
        }
    }

    public function includeTags (Post $post)
    {
        return $this->collection($post->tags , new TagTransformer());
    }
}