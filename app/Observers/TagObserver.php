<?php

namespace App\Observers;


use App\Models\Tag;
use App\Models\TagIndex;

class TagObserver
{

    /**
     * Handle the post "deleted" event.
     *
     * @param  \App\Models\Post $post
     * @return void
     */
    public function saving(Tag $tag)
    {
        TagIndex::countAdd($tag->title);
    }

    public function deleting(Tag $tag)
    {
        TagIndex::countLess($tag->title);
    }

}
