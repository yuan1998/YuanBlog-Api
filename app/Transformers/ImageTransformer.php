<?php

namespace App\Transformers;

use App\Models\Images;
use League\Fractal\TransformerAbstract;

class ImageTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user'];

    public function transform(Images $image)
    {
        return [
            'id' => $image->id,
            'user_id' => $image->user_id,
            'path' => $image->path,
            'sm_path' => $image->sm_path,
            'md_path' => $image->md_path,
            'create_at' => $image->created_at->toDateTimeString(),
            'updated_at' => $image->updated_at->toDateTimeString(),
        ];
    }


    public function includeUser (Images $image)
    {
        return $this->item($image->user , new UserTransformer());
    }

}