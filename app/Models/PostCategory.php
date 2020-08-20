<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
