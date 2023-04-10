<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\PostTag.
 *
 * @property int $id
 * @property int $post_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Post\Post $post
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post\Post[] $posts
 * @property-read int|null $posts_count
 */
class Tag extends Model
{
    protected $fillable = ['name'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'id', 'post_id');
    }

    public function scopeIsUnique($query, bool $isUnique)
    {
        return $query->when($isUnique, function ($query) {
            return $query->groupBy('name');
        });
    }
}
