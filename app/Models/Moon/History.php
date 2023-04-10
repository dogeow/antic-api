<?php

namespace App\Models\Moon;

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
 * @property-read \App\Models\Moon\Moon $moon
 *
 * @method static \Illuminate\Database\Eloquent\Builder|History newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|History newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|History query()
 * @method static \Illuminate\Database\Eloquent\Builder|History whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereMoonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereNum1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereNum2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereNum3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereNum4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereNum5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereNum6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|History whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class History extends Model
{
    protected $guarded = [];

    public function moon()
    {
        return $this->belongsTo(Moon::class);
    }
}
