<?php

namespace App\Models\Site;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Carbon;

/**
 * App\Models\SiteCheck.
 *
 * @property int $id
 * @property int $site_id
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Site $sites
 *
 * @method static Builder|Check newModelQuery()
 * @method static Builder|Check newQuery()
 * @method static Builder|Check query()
 * @method static Builder|Check whereCreatedAt($value)
 * @method static Builder|Check whereId($value)
 * @method static Builder|Check whereSiteId($value)
 * @method static Builder|Check whereStatus($value)
 * @method static Builder|Check whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Check extends Model
{
    protected $fillable = ['site_id', 'status'];

    public function sites(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function scopeLastPerGroup(Builder $query, ?array $fields = null): Builder
    {
        return $query->whereIn('id', fn (QueryBuilder $query) => $query->from(static::getTable())
            ->selectRaw('max(`id`)')
            ->groupBy($fields));
    }
}
