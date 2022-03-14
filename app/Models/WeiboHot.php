<?php

declare(strict_types=1);

namespace App\Models;

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
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboHot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboHot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboHot query()
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboHot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboHot whereEmoji($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboHot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboHot whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboHot whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboHot whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboHot whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboHot whereUrl($value)
 * @mixin \Eloquent
 */
class WeiboHot extends Model
{
    protected $fillable = ['title', 'url', 'rank', 'emoji', 'status'];

    public function getUpdatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }

    public function getRankAttribute(): string
    {
        return weiboHotForHuman($this->attributes['rank'] ?? 0);
    }
}
