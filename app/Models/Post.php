<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use Searchable;

    protected $fillable = ['title', 'content'];

    public function tags()
    {
        return $this->hasMany(PostTag::class);
    }

    public function category()
    {
        return $this->hasOne(PostCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
