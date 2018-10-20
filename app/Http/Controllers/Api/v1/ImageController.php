<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\ImageRequest;
use App\Models\Images;
use App\Traits\ImageTrait;
use App\Transformers\ImageTransformer;

class ImageController extends Controller
{

    use ImageTrait;

    public function store (ImageRequest $request)
    {
        $user = $this->user();

        $result = $this->createImage($user->id , $request->image , $request->type , $request->size);

        return $this->response->item($result , new ImageTransformer());
    }


    /**
     * @param $user
     * @param $image
     * @param $type
     * @param $size
     * @return mixed
     */
    public static function createImage ($user , $image , $type , $size)
    {
        $result = self::saveImage($image , $type , $user, $size);

        return Images::create($result);
    }


}
