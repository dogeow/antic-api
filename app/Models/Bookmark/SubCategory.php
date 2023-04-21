<?php

namespace App\Models\Bookmark;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'bookmark_sub_categories';

    protected $fillable = ['category_id', 'name', 'order'];

    public function bookmarkCategory()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}
