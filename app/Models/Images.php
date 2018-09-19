<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    //

    protected $fillable = ['type','user_id','path','md_path','sm_path'];


    public function user ()
    {
        return $this->belongsTo(User::class , 'user_id','id');
    }
}
