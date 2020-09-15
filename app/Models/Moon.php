<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moon extends Model
{
    protected $guarded = [];

    public function moonHistory()
    {
        return $this->hasMany(MoonHistory::class);
    }

    public function statistics()
    {
        return [
            'user' => Moon::count(),
            'count' => MoonHistory::count(),
            'money' => MoonHistory::sum('money'),
        ];
    }
}
