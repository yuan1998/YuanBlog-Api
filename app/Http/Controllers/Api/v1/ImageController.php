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

        $data = $request->only(['type' , 'image' , 'size']);

        $data['user_id'] = $user->id || 0;

        $result = $this->createImage( $data);

        return $this->response->item($result , new ImageTransformer());
    }


    /**
     * @param $user
     * @param $image
     * @param $type
     * @param $size
     * @return mixed
     */
    public static function createImage ($data)
    {
        $path = self::saveImage($data['image'] , $data['type'] , $data['user_id'] ,$data['size']);

        $data['path'] = $path;

        return Images::create($data);
    }


}
