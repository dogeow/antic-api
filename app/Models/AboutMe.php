<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AboutMe.
 *
 * @property int $id
 * @property string $category
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AboutMe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AboutMe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AboutMe query()
 * @method static \Illuminate\Database\Eloquent\Builder|AboutMe whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutMe whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutMe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutMe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutMe whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class AboutMe extends Model
{
}
