<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Product.
 *
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 *
 * @mixin \Eloquent
 */
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
