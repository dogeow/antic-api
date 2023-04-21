<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookmarkCategory extends Model
{
    use HasFactory;

    protected $table = 'bookmark_categories';
    protected $fillable = ['name', 'order'];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
