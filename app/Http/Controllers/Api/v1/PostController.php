<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\PostRequest;
use App\Models\Post;
use App\Transformers\PostTransformer;

class PostController extends Controller
{

    public function saveCover($request, $id)
    {
        $data = [
            'image'   => $request->image,
            'user_id' => $id,
            'type'    => 'article',
            'size'    => false
        ];

        $image = ImageController::createImage($data);

        return $image->path;

    }

    public function store(PostRequest $request)
    {
        if (!$this->user()->hasRole('administrator'))
            return $this->response->errorUnauthorized();

        $data            = $request->all();
        $data['user_id'] = $this->user()->id;
        $data['cover']   = $this->saveCover($request, $data['user_id']);

        if($request->has('tags')) {

        }



        Post::create($data);
        return $this->response->created();
    }

    public function update(PostRequest $request, Post $post)
    {
        if (!$this->user()->hasRole('administrator'))
            return $this->response->errorUnauthorized();

        $data = $request->all();

        if ($request->has('image')) {
            $data['cover'] = $this->saveCover($request, $data['user_id']);
        }

        $post->fill($data);
        $post->save();
        return $this->response->item($post, new PostTransformer());
    }

    public function destroy($ids)
    {
        if (!$this->user()->hasRole('administrator'))
            return $this->response->errorUnauthorized();

        Post::query()
            ->whereIn('id', explode(',', $ids))
            ->get()
            ->each(function ($item) {
                $item->delete();
            });


        return $this->response->noContent();
    }

    public function index()
    {
        $arr = Post::paginate(request()->get('paginate',20));
        return $this->response->paginator($arr, new PostTransformer());
    }

    public function show(Post $post)
    {
        return $this->response->item($post, new PostTransformer('info'));
    }


}
