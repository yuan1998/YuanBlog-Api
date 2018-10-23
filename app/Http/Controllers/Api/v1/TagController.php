<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\TagRequest;
use App\Models\Post;
use App\Models\Tag;
use App\Models\TagIndex;
use App\Transformers\PostTransformer;

class TagController extends Controller
{


    public function store(TagRequest $request)
    {

        if (!$this->user()->hasRole('administrator'))
            return $this->response->errorUnauthorized();

        $this->createTag( explode(',', $request->tags), $request->article_id);

        return $this->response->created();
    }


    public function destroy($ids)
    {
        if (!$this->user()->hasRole('administrator'))
            return $this->response->errorUnauthorized();

        static::deleteTags(explode(',', $ids));

        return $this->response->noContent();
    }


    public static function deleteTags ($ids)
    {
        $tags = Tag::query()->whereIn('id', $ids )->get();

        $tags->each(function ($item) {
            $item->delete();
        });
    }


    public static function deleteArticleTag ( $tags , $id )
    {
        $tags = Tag::query()->where('article_id' ,  $id)->whereIn('title' , $tags)->get();

        $tags->each(function ($item) {
            $item->delete();
        });
    }


    public static function createTag($tags, $article_id)
    {
        $tags = collect($tags)->map(function ($item) use ($article_id) {
            return [
                'title'      => $item,
                'article_id' => $article_id
            ];
        });

        $tags->each(function ($item) {

            if (!Tag::query()->where([
                ['title', '=', $item['title']],
                ['article_id', '=', $item['article_id']],
            ])->first())
                Tag::create($item);
        });

        return true;
    }


    public function post(TagIndex $tagIndex)
    {

        if(!$tagIndex)
            return $this->response->errorBadRequest('Tag is not Exists');

        $tags = Tag::query()->where('title', '=', $tagIndex->title)->get();

        $post = Post::query()
            ->whereIn('id', $tags->pluck('article_id'))
            ->paginate(request()->get('paginate', 20));

        return $this->response->paginator($post, new PostTransformer())->addMeta('tag', $tagIndex);
    }


    public function getPost($ids)
    {

    }
}
