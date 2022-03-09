<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Project.
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property int $is_completed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|array<Task> $tasks
 * @property-read int|null $tasks_count
 * @property-read User $user
 *
 * @method static Builder|Project completed()
 * @method static Builder|Project newModelQuery()
 * @method static Builder|Project newQuery()
 * @method static Builder|Project query()
 * @method static Builder|Project undone()
 * @method static Builder|Project whereCreatedAt($value)
 * @method static Builder|Project whereDescription($value)
 * @method static Builder|Project whereId($value)
 * @method static Builder|Project whereIsCompleted($value)
 * @method static Builder|Project whereName($value)
 * @method static Builder|Project whereUpdatedAt($value)
 * @method static Builder|Project whereUserId($value)
 *
 * @mixin Eloquent
 */
class Project extends Model
{
    protected $fillable = ['user_id', 'name', 'description', 'is_completed'];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUndone(Builder $query): Builder
    {
        return $query->where('is_completed', 0);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('is_completed', 1);
    }
}
