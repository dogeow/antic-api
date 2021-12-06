<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Moon.
 *
 * @property int $id
 * @property string $name
 * @property string $ip
 * @property int $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\MoonHistory> $moonHistory
 * @property-read int|null $moon_history_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Moon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Moon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Moon query()
 * @method static \Illuminate\Database\Eloquent\Builder|Moon whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moon whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moon whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moon whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Moon extends Model
{
    protected $guarded = [];

    public function moonHistory(): HasMany
    {
        return $this->hasMany(MoonHistory::class);
    }

    public function statistics(): array
    {
        return [
            'user' => self::count(),
            'count' => MoonHistory::count(),
            'money' => MoonHistory::sum('money'),
        ];
    }
}
