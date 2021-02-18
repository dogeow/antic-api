<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Api.
 *
 * @property int $id
 * @property string|null $endpoint
 * @property string|null $param
 * @property string $content
 * @property string $example
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Api newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Api newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Api query()
 * @method static \Illuminate\Database\Eloquent\Builder|Api whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Api whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Api whereEndpoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Api whereExample($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Api whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Api whereParam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Api whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Api extends Model
{
}
