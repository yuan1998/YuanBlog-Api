<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catagory extends Model
{
    protected $fillable = ['title' , 'title_ne' , 'description','parent_id'];

    protected $table = "categorys";

}
