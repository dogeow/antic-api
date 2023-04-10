<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Task.
 *
 * @property int $id
 * @property string $title
 * @property int $project_id
 * @property int|null $is_completed
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Task\Project $project
 *
 * @method static Builder|Task completed()
 * @method static Builder|Task newModelQuery()
 * @method static Builder|Task newQuery()
 * @method static Builder|Task query()
 * @method static Builder|Task undone()
 * @method static Builder|Task whereCreatedAt($value)
 * @method static Builder|Task whereId($value)
 * @method static Builder|Task whereIsCompleted($value)
 * @method static Builder|Task whereOrder($value)
 * @method static Builder|Task whereProjectId($value)
 * @method static Builder|Task whereTitle($value)
 * @method static Builder|Task whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
