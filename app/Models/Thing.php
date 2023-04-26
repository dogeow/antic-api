<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thing extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photos',
        'tags',
        'amount',
        'money',
        'bought_at',
        'expired_at',
        'description',
        'is_expiration_reminder'
    ];

    public function tags()
    {
        return $this->hasMany(ThingTag::class);
    }

    public function photos()
    {
        return $this->hasMany(ThingPhoto::class);
    }

    public function place()
    {
        return $this->belongs(Place::class);
    }
}
