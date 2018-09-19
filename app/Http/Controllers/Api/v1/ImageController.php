<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\ImageRequest;
use App\Models\Images;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    use ImageTrait;

    public function store (ImageRequest $request)
    {

        $user = $this->user();


        $result = $this->createImage($user , $request);


        dd($result);

    }


    public function createImage ($user , $request)
    {
        $result = $this->saveImage($request->image , $request->type , $user->id , $request->size);

//        Images::create($result);
        return $result;
    }


}
