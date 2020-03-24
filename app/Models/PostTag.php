<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
