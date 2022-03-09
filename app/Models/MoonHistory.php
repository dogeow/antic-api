<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Moon $moon
 *
 * @method static Builder|MoonHistory newModelQuery()
 * @method static Builder|MoonHistory newQuery()
 * @method static Builder|MoonHistory query()
 * @method static Builder|MoonHistory whereCreatedAt($value)
 * @method static Builder|MoonHistory whereId($value)
 * @method static Builder|MoonHistory whereMoney($value)
 * @method static Builder|MoonHistory whereMoonId($value)
 * @method static Builder|MoonHistory whereName($value)
 * @method static Builder|MoonHistory whereNum1($value)
 * @method static Builder|MoonHistory whereNum2($value)
 * @method static Builder|MoonHistory whereNum3($value)
 * @method static Builder|MoonHistory whereNum4($value)
 * @method static Builder|MoonHistory whereNum5($value)
 * @method static Builder|MoonHistory whereNum6($value)
 * @method static Builder|MoonHistory whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class MoonHistory extends Model
{
    protected $guarded = [];

    public function moon()
    {
        return $this->belongsTo(Moon::class);
    }
}
