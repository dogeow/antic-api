<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThingPlace extends Model
{
    use HasFactory;

    public function things()
    {
        return $this->hasMany(Thing::class);
    }
}
