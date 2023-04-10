<?php

namespace App\Models\Weibo;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WeiboToTop.
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ToTop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ToTop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ToTop query()
 * @method static \Illuminate\Database\Eloquent\Builder|ToTop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToTop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToTop whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToTop whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToTop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToTop whereUrl($value)
 * @mixin \Eloquent
 */
class ToTop extends Model
{
    protected $fillable = ['title', 'url', 'status'];
}
