<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;

/**
 * App\Models\PostCategory.
 *
 * @property int $id
 * @property int $post_id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Post $post
 *
 * @method static Builder|PostCategory newModelQuery()
 * @method static Builder|PostCategory newQuery()
 * @method static Builder|PostCategory query()
 * @method static Builder|PostCategory whereCreatedAt($value)
 * @method static Builder|PostCategory whereId($value)
 * @method static Builder|PostCategory whereName($value)
 * @method static Builder|PostCategory wherePostId($value)
 * @method static Builder|PostCategory whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class PostCategory extends Model
{
    use Searchable;

    protected $guarded = [];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }
}
