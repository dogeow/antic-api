<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Like.
 *
 * @property int $id
 * @property string $name
 * @property string $sub_header
 * @property string $img
 * @property string $intro
 * @property string $link
 * @property string $feeling 对 ta 的感觉
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Like newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Like newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Like query()
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereFeeling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereIntro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereSubHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @method static \Database\Factories\LikeFactory factory(...$parameters)
 */
class Like extends Model
{
    use HasFactory;
}
