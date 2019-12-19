<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    public function history()
    {
        return $this->hasMany(SiteCheck::class);
    }

    public function todayLatest()
    {
        return $this->hasOne(SiteCheck::class)->whereDate('created_at', Carbon::today())->latest();
    }

    public function todayLatestWithFailed()
    {
        return $this->hasOne(SiteCheck::class)->whereDate('created_at', Carbon::today())->latest();
    }
}
