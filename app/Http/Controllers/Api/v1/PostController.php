<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //

    public function store (PostRequest $request)
    {






        return $this->response->created();


    }
}
