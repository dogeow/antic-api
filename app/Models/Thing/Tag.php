<?php

namespace App\Models\Thing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'thing_id',
        'name',
    ];

    public function thing()
    {
        return $this->belongsTo(Thing::class);
    }
}
