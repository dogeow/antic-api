<?php

declare(strict_types=1);

namespace App\Models;

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
 * @method static Builder|SiteCheck newModelQuery()
 * @method static Builder|SiteCheck newQuery()
 * @method static Builder|SiteCheck query()
 * @method static Builder|SiteCheck whereCreatedAt($value)
 * @method static Builder|SiteCheck whereId($value)
 * @method static Builder|SiteCheck whereSiteId($value)
 * @method static Builder|SiteCheck whereStatus($value)
 * @method static Builder|SiteCheck whereUpdatedAt($value)
 * @mixin Eloquent
 */
class SiteCheck extends Model
{
    protected $fillable = ['site_id', 'status'];

    public function sites(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function scopeLastPerGroup(Builder $query, ?array $fields = null): Builder
    {
        return $query->whereIn('id', fn(QueryBuilder $query) => $query->from(static::getTable())
            ->selectRaw('max(`id`)')
            ->groupBy($fields));
    }
}
