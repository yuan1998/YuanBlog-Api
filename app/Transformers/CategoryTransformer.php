<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['tree'];

    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'description' => $category->description,
            'title' => $category->title,
            'title_en' => $category->title_en,
            'parent_id' => $category->parent_id,
        ];
    }


    public function includeTree (Category $category)
    {
        return $this->item($category->children ,new CategoryTransformer());
    }

}