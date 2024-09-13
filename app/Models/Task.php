<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'completed',
        'position',
        'due_date',
        'priority',
        'list_id'
    ];
    public function list()
    {
        return $this->belongsTo(TasksList::class);
    }

    public function getDefaultPosition()
    {
        // Your custom logic for calculating the default position
        return Task::where('list_id', $this->list_id)->max('position') + 1;
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($task) {
            if (is_null($task->position)) {
                $task->position = $task->getDefaultPosition();
            }
        });

        static::deleting(function ($task) {
            Task::where('list_id', $task->list_id)
                ->where('position', '>', $task->position)
                ->decrement('position');
        });
    }
}
