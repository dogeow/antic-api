<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PhpFunction.
 *
 * @property int $id
 * @property int $category_id 分类 ID
 * @property string $name 函数名
 * @property string $intro 简介、一句话介绍
 * @property string $url 对应 php.net 网址
 * @property string $example 举例
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunction query()
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunction whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunction whereExample($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunction whereIntro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunction whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhpFunction whereUrl($value)
 *
 * @mixin \Eloquent
 */
class PhpFunction extends Model
{
    use HasFactory;
}
