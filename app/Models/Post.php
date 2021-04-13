<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\morphMany;
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PostCategory|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PostTag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post public ()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUserId($value)
 * @mixin \Eloquent
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

    public function image(): morphMany
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
