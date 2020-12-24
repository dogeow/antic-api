<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'secret',
    ];

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

    public function scopePublic($query)
    {
        return $query->where('public', 1);
    }
}
