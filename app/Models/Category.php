<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title' , 'title_en' , 'description','parent_id'];

    protected $table = "categorys";


    public function parentCat (){
        return $this->belongsTo(Category::class,'parent_id','id');
    }

    public function tree ()
    {
        return $this->hasMany(Category::class,'parent_id','id');
    }

}
