<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'title',
        'description',
        'article_id'
    ];

    protected $table = 'tags';

    public function article ()
    {
        return $this->belongsTo(Post::class );
    }

}
