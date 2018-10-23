<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['children' , 'parent'];

    protected $type;

    public function __construct($type= 'default')
    {
        $this->type = $type;
    }

    public function transform(Category $category)
    {
        $result = [
            'id' => $category->id,
            'description' => $category->description,
            'title' => $category->title,
            'title_en' => $category->title_en,
            'parent_id' => $category->parent_id,
        ];

        if($this->type == 'tree') {
            $result['children'] = [];
            if($category->relationLoaded('children') ){
                foreach($category->getRelation('children') as $child) {
                    $result['children'][] = $this->transform($child);
                }
            }
        }

        return $result;
    }


    public function includeChildren (Category $category)
    {
        return $this->collection($category->children , new static());
    }

    public function includeParent (Category $category)
    {
        return $this->collection($category->parent , new static());

    }

}