<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTreeTransformer extends TransformerAbstract
{
    public function transform(Category $category)
    {
        $result = [
            'id' => $category->id,
            'description' => $category->description,
            'title' => $category->title,
            'title_en' => $category->title_en,
            'parent_id' => $category->parent_id,
            'children' => []
        ];

        if( !$category->children->isEmpty()){
            foreach($category->children as $child) {
                $result['children'][] = $this->transform($child);
            }
        }

        return $result;
    }




}