<?php

namespace App\Models;

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
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboToTop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboToTop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboToTop query()
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboToTop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboToTop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboToTop whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboToTop whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboToTop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeiboToTop whereUrl($value)
 * @mixin \Eloquent
 */
class WeiboToTop extends Model
{
    protected $fillable = ['title', 'url', 'status'];
}
