<?php

namespace App\Models\Bookmark;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * App\Models\Bookmark
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark query()
 * @mixin \Eloquent
 */
class Bookmark extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['title', 'url', 'sub_category_id', 'category_id', 'order'];

    public function bookmarkCategory()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookmarkSubCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($bookmark) {
            if (empty($bookmark->bookmark_category_id)) {
                $bookmark->bookmark_category_id = SubCategory::query()
                    ->where('id', $bookmark->bookmark_sub_category_id)
                    ->value('bookmark_category_id');
            }
        });
    }
}
