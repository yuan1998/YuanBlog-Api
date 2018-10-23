<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller as BaseController;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class Controller extends BaseController
{
    use Helpers;




    public function collection ($model , $transform)
    {
        $list = new Collection($model , $transform);
        $list = (new Manager)->createData($list);

        return $list->toArray();
    }


    public function item ($model , $transform)
    {

    }

}
