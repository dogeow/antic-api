<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name', 'price', 'quantity',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
