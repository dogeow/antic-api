<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookmarkCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'order'];

    public function subCategories()
    {
        return $this->hasMany(BookmarkSubCategory::class);
    }
}
