<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Moon extends Model
{
    protected $guarded = [];

    public function moonHistory(): HasMany
    {
        return $this->hasMany(MoonHistory::class);
    }

    public function statistics(): array
    {
        return [
            'user' => self::count(),
            'count' => MoonHistory::count(),
            'money' => MoonHistory::sum('money'),
        ];
    }
}
