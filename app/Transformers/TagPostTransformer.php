<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class TagPostTransformer extends TransformerAbstract
{
    public function transform($data)
    {
        return [
            'tag' => $this->item($data->tagIndex,new TagTransformer()),
            'post' => $this->paginator($data->post, new PostTransformer())
        ];
    }

}