<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'description',
        'excerpt',
        'user_id',
        'read_count',
        'like_count',
        'category_id',
        'article_status',
        'slug_title',
        'cover',
        'cover_other',
        'other',
    ];

    protected $table = "articles";

    protected $casts = [
        'cover_other' => 'json',
        'other' => 'json'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function tags ()
    {
        return $this->hasMany(Tag::class , 'article_id');
    }


}
