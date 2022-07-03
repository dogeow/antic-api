<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MoonHistory.
 *
 * @property int $id
 * @property int $moon_id
 * @property int $num1
 * @property int $num2
 * @property int $num3
 * @property int $num4
 * @property int $num5
 * @property int $num6
 * @property string $name
 * @property string $money
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Moon $moon
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MoonHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MoonHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MoonHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|MoonHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoonHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoonHistory whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoonHistory whereMoonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoonHistory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoonHistory whereNum1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoonHistory whereNum2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoonHistory whereNum3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoonHistory whereNum4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoonHistory whereNum5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoonHistory whereNum6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoonHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MoonHistory extends Model
{
    protected $guarded = [];

    public function moon()
    {
        return $this->belongsTo(Moon::class);
    }
}
