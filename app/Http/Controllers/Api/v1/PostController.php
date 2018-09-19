<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\PostRequest;
use App\Models\Post;
use App\Transformers\PostTransformer;

class PostController extends Controller
{
    //

    public function store (PostRequest $request)
    {

        Post::create($request->toArray());
        return $this->response->created();
    }

    public function index ()
    {
        $arr = Post::paginate(20);
        return $this->response->paginator($arr,new PostTransformer());
    }

    public function show (Post $post)
    {
        return $this->response->item($post,new PostTransformer());
    }


    public function destroy (Post $post)
    {
        $post->delete();
        return $this->response->noContent();
    }

}
