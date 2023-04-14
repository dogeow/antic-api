<?php

namespace App\Models\Bookmark;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'bookmark_categories';
    protected $fillable = ['name', 'order'];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
