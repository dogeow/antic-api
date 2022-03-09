<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;

/**
 * App\Models\Post.
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property int $public
 * @property string|null $secret
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read PostCategory|null $category
 * @property-read Collection|array<PostTag> $tags
 * @property-read int|null $tags_count
 * @property-read User $user
 *
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post public ()
 * @method static Builder|Post query()
 * @method static Builder|Post whereContent($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post wherePublic($value)
 * @method static Builder|Post whereSecret($value)
 * @method static Builder|Post whereTitle($value)
 * @method static Builder|Post whereUpdatedAt($value)
 * @method static Builder|Post whereUserId($value)
 *
 * @mixin Eloquent
 */
class Post extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['title', 'content', 'category_id', 'public'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'secret',
    ];

    public function tags(): HasMany
    {
        return $this->hasMany(PostTag::class);
    }

    public function category(): HasOne
    {
        return $this->hasOne(PostCategory::class, 'id', 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublic($query)
    {
        $userId = auth()->user()->id ?? 0;
        if ($userId === 1) {
            return $query;
        }

        return $query->where('public', 1);
    }

    public function image(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function shouldBeSearchable()
    {
        return self::Public();
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array['category'] = $this->category->name;

        return $array;
    }
}
