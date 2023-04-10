<?php

namespace App\Models\Thing;

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
        return $this->hasMany(Tag::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function place()
    {
        return $this->belongs(Place::class);
    }
}
