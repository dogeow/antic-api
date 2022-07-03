<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * App\Models\Image.
 *
 * @property int $id
 * @property int $user_id
 * @property string $original_name
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Image newModelQuery()
 * @method static Builder|Image newQuery()
 * @method static Builder|Image query()
 * @method static Builder|Image whereCreatedAt($value)
 * @method static Builder|Image whereId($value)
 * @method static Builder|Image whereName($value)
 * @method static Builder|Image whereOriginalName($value)
 * @method static Builder|Image whereUpdatedAt($value)
 * @method static Builder|Image whereUserId($value)
 * @mixin Eloquent
 *
 * @property-read Model|Eloquent $imageable
 */
class Image extends Model
{
    protected $guarded = [];

    public function imageable()
    {
        return $this->morphTo();
    }

    protected function image(): Attribute
    {
        return new Attribute(
            get: function () {
                if (Str::contains($this->name, '//')) {
                    return $this->name;
                }

                return Storage::disk('oss')->url($this->path_name);
            }
        );
    }
}
