<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutMe extends Model
{
    public function scopeGroupByCategory($query)
    {
        return $query->groupBy('category');
    }
}
