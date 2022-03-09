<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\PostTag.
 *
 * @property int $id
 * @property int $post_id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Post $post
 *
 * @method static Builder|PostTag newModelQuery()
 * @method static Builder|PostTag newQuery()
 * @method static Builder|PostTag query()
 * @method static Builder|PostTag whereCreatedAt($value)
 * @method static Builder|PostTag whereId($value)
 * @method static Builder|PostTag whereName($value)
 * @method static Builder|PostTag wherePostId($value)
 * @method static Builder|PostTag whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class PostTag extends Model
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
}
