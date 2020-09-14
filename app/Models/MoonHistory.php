<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoonHistory extends Model
{
    protected $guarded = [];

    public function moon()
    {
        return $this->belongsTo(Moon::class);
    }
}
