<?php

namespace App\Models;

use Dogeow\PhpHelpers\Str;
use Illuminate\Database\Eloquent\Builder;
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
 * @method static Builder|WeiboHot newModelQuery()
 * @method static Builder|WeiboHot newQuery()
 * @method static Builder|WeiboHot query()
 * @method static Builder|WeiboHot whereCreatedAt($value)
 * @method static Builder|WeiboHot whereEmoji($value)
 * @method static Builder|WeiboHot whereId($value)
 * @method static Builder|WeiboHot whereRank($value)
 * @method static Builder|WeiboHot whereStatus($value)
 * @method static Builder|WeiboHot whereTitle($value)
 * @method static Builder|WeiboHot whereUpdatedAt($value)
 * @method static Builder|WeiboHot whereUrl($value)
 * @mixin \Eloquent
 */
class WeiboHot extends Model
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
