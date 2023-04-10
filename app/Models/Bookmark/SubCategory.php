<?php

namespace App\Models\Bookmark;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'order'];

    public function bookmarkCategory()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}
