<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\WeiboToTop.
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|WeiboToTop newModelQuery()
 * @method static Builder|WeiboToTop newQuery()
 * @method static Builder|WeiboToTop query()
 * @method static Builder|WeiboToTop whereCreatedAt($value)
 * @method static Builder|WeiboToTop whereId($value)
 * @method static Builder|WeiboToTop whereStatus($value)
 * @method static Builder|WeiboToTop whereTitle($value)
 * @method static Builder|WeiboToTop whereUpdatedAt($value)
 * @method static Builder|WeiboToTop whereUrl($value)
 * @mixin \Eloquent
 */
class WeiboToTop extends Model
{
    protected $fillable = ['title', 'url', 'status'];
}
