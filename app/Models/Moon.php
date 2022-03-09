<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Moon.
 *
 * @property int $id
 * @property string $name
 * @property string $ip
 * @property int $count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|array<MoonHistory> $moonHistory
 * @property-read int|null $moon_history_count
 *
 * @method static Builder|Moon newModelQuery()
 * @method static Builder|Moon newQuery()
 * @method static Builder|Moon query()
 * @method static Builder|Moon whereCount($value)
 * @method static Builder|Moon whereCreatedAt($value)
 * @method static Builder|Moon whereId($value)
 * @method static Builder|Moon whereIp($value)
 * @method static Builder|Moon whereName($value)
 * @method static Builder|Moon whereUpdatedAt($value)
 *
 * @mixin Eloquent
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
