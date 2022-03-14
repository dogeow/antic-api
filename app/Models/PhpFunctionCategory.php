<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PhpFunctionCategory.
 *
 * @property int $id
 * @property string $name 分类名
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunctionCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunctionCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunctionCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunctionCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunctionCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunctionCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunctionCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PhpFunctionCategory extends Model
{
    use HasFactory;
}
