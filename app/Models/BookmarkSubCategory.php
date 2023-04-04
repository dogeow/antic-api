<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookmarkSubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'order'];

    public function bookmarkCategory()
    {
        return $this->belongsTo(BookmarkCategory::class);
    }
}
