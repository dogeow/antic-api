<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\SiteCheck.
 *
 * @property int $id
 * @property int $site_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Site $sites
 * @method static \Illuminate\Database\Eloquent\Builder|SiteCheck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteCheck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteCheck query()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteCheck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteCheck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteCheck whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteCheck whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteCheck whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SiteCheck extends Model
{
    protected $fillable = ['site_id', 'status'];

    public function sites(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
