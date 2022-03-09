<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Site.
 *
 * @property int $id
 * @property string $domain
 * @property bool $online 是否在线
 * @property int $seo 百度收录量
 * @property string $get_type 爬虫或者 API
 * @property string $date_xpath 最新日期的 xpath
 * @property string $date_format 最新日期的格式
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read Collection|array<SiteCheck> $history
 * @property-read int|null $history_count
 * @property-read SiteCheck|null $todayLatest
 * @property-read SiteCheck|null $todayLatestWithFailed
 *
 * @method static Builder|Site newModelQuery()
 * @method static Builder|Site newQuery()
 * @method static Builder|Site query()
 * @method static Builder|Site whereCreatedAt($value)
 * @method static Builder|Site whereDateFormat($value)
 * @method static Builder|Site whereDateXpath($value)
 * @method static Builder|Site whereDomain($value)
 * @method static Builder|Site whereGetType($value)
 * @method static Builder|Site whereId($value)
 * @method static Builder|Site whereOnline($value)
 * @method static Builder|Site whereSeo($value)
 * @method static Builder|Site whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Site extends Model
{
    public function history(): HasMany
    {
        return $this->hasMany(SiteCheck::class);
    }

    public function getLastUpdatedAtAttribute(): string
    {
        if (is_null($this->attributes['last_updated_at'])) {
            return '更新信息错误';
        }

        return \Illuminate\Support\Carbon::parse($this->attributes['last_updated_at'])->diffForHumans();
    }

    public function todayLatest(): HasOne
    {
        return $this->hasOne(SiteCheck::class)->whereDate('created_at', Carbon::today())->latest();
    }

    public function todayLatestWithFailed(): HasOne
    {
        return $this->hasOne(SiteCheck::class)->whereDate('created_at', Carbon::today())->latest();
    }
}
