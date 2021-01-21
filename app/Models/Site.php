<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Site extends Model
{
    public function history(): HasMany
    {
        return $this->hasMany(SiteCheck::class);
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
