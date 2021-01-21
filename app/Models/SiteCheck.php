<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteCheck extends Model
{
    protected $fillable = ['site_id', 'status'];

    public function sites(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
