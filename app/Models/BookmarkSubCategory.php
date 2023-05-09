<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookmarkSubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['bookmark_category_id', 'name', 'order'];

    public function bookmarkCategory()
    {
        return $this->belongsTo(BookmarkCategory::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}
