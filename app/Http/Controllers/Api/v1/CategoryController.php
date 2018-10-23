<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\CategoryRequest;
use App\Models\Category;
use App\Transformers\CategoryTransformer;
use App\Transformers\CategoryTreeTransformer;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function store (CategoryRequest $request , Category $category)
    {

        if(!$this->user()->hasRole('administrator'))
            return $this->response->errorUnauthorized();

        $category->fill($request->all());

        $category->save();

        return $this->response->item($category , new CategoryTransformer());
    }


    public function destroy (Category $category)
    {
        if(!$this->user()->hasRole('administrator'))
            return $this->response->errorUnauthorized();

        $category->delete();

        return $this->response->noContent();
    }

    public function index (Category $category)
    {
        $arr = $category->get();


        return $this->response->collection($arr,new CategoryTransformer());
    }


    public function show (Category $category)
    {

        return $this->response->item($category , new CategoryTransformer());
    }

    public function showTree (Category $category)
    {
        $category->setRelation('children' , $category->descendants);
        return $this->response->item($category , new CategoryTransformer('tree'));

    }

    public function tree (Category $category)
    {
        $tree = $category->all()->toTree();
        return $this->response->collection($tree , new CategoryTransformer('tree'));
    }


}
