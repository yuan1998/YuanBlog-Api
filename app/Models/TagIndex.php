<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagIndex extends Model
{

    protected $fillable = [
        'title',
        'count',
    ];

    protected $table = 'tagindex';


    public static function countAdd ($tag)
    {
        $item = self::query()->where('title' , $tag)->first();

        if($item) {
            $item->count++;
        }else {
            $item = new static();
            $item->fill(['title' => $tag , 'count' => 1]);
        }

        $item->save();
    }


    public static function countLess ($tag)
    {
        $item = self::query()->where('title' , $tag)->first();

        if($item->count > 0) {
            $item->count--;
            $item->save();
        }
    }

}
