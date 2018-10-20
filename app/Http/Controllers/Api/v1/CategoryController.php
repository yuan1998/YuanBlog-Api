<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\CategoryRequest;
use App\Models\Category;
use App\Transformers\CategoryTransformer;
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

    public function index ()
    {

        $arr = Category::all();

        return $this->response->collection($arr,new CategoryTransformer());
    }


    public function treeIndex ()
    {
        $arr = Category::where('id',0)->get();

        return $this->response->array($arr,new CategoryTransformer());
    }

}
