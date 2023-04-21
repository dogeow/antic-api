<?php

namespace App\Models;

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

    protected $fillable = ['title', 'url', 'bookmark_sub_category_id', 'bookmark_category_id', 'order'];

    public function bookmarkCategory()
    {
        return $this->belongsTo(BookmarkCategory::class);
    }

    public function bookmarkSubCategory()
    {
        return $this->belongsTo(BookmarkSubCategory::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($bookmark) {
            if (empty($bookmark->category_id)) {
                $bookmark->category_id = BookmarkSubCategory::query()
                    ->where('id', $bookmark->sub_category_id)
                    ->value('category_id');
            }
        });
    }
}
