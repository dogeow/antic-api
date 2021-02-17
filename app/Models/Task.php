<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = ['title', 'project_id', 'is_completed', 'order'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('is_completed', 1);
    }

    public function scopeUndone(Builder $query): Builder
    {
        return $query->where('is_completed', 0);
    }
}
