<?php

namespace App\Models\Weibo;

use Dogeow\PhpHelpers\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\WeiboHot.
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string $rank
 * @property string|null $emoji
 * @property string|null $status
 * @property Carbon|null $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Hot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hot query()
 * @method static \Illuminate\Database\Eloquent\Builder|Hot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hot whereEmoji($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hot whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hot whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hot whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hot whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hot whereUrl($value)
 * @mixin \Eloquent
 */
class Hot extends Model
{
    protected $fillable = ['title', 'url', 'rank', 'emoji', 'status'];

    protected function updatedAt(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->attributes['updated_at'])->diffForHumans()
        );
    }

    public function getRankAttribute(): string
    {
        return Str::bytesForHuman($this->attributes['rank'] ?? 0);
    }
}
