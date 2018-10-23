<?php

namespace App\Transformers;

use App\Models\Tag;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'article'
    ];

    public function transform(Tag $tag)
    {
        return [
            'id'         => $tag->id,
            'title'      => $tag->title,
            'title'      => $tag->title,
            'create_at'  => $tag->created_at->toDateTimeString(),
            'updated_at' => $tag->updated_at->toDateTimeString(),
        ];
    }


    public function includeArticle (Tag $tag)
    {
        return $this->item($tag->article , new PostTransformer());
    }

}