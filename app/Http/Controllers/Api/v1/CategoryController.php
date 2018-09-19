<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\CategoryRequest;
use App\Models\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function store (CategoryRequest $request)
    {

        Category::create($request->toArray());
        return $this->response->created();
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
