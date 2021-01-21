<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class WeiboHot extends Model
{
    protected $fillable = ['title', 'url', 'rank', 'emoji', 'status'];

    public function getUpdatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }

    public function getRankAttribute(): string
    {
        return weiboHotForHuman($this->attributes['rank'] ?? 0);
    }
}
