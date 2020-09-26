<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'project_id', 'is_completed', 'priority'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * 数字转优先级.
     *
     * @param  string  $value
     * @return string
     */
    public function getPriorityAttribute($value)
    {
        switch ($value) {
            case 1:
                $priority = '低';
                break;
            case 2:
                $priority = '中';
                break;
            case 3:
                $priority = '高';
                break;
            default:
                $priority = '中';
        }

        return $priority;
    }

    public function setPriorityAttribute($value)
    {
        switch ($value) {
            case '高':
                $this->attributes['priority'] = 3;
                break;
            case '中':
                $this->attributes['priority'] = 2;
                break;
            case '低':
                $this->attributes['priority'] = 1;
                break;
            default:
                $this->attributes['priority'] = $value;
        }
    }
}
