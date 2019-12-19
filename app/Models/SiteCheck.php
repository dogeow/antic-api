<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteCheck extends Model
{
    protected $fillable = ['site_id', 'status'];

    public function sites()
    {
        return $this->belongsTo(Site::class);
    }
}
