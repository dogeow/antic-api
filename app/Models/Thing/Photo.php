<?php

namespace App\Models\Thing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'thing_id',
        'path',
    ];
    public function thing()
    {
        return $this->belongsTo(Thing::class);
    }
}
