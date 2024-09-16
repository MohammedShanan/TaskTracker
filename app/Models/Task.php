<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'completed',
        'position',
        'due_date',
        'priority',
        'list_id',
    ];

    /**
     * Get the list that owns the task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function list()
    {
        return $this->belongsTo(TasksList::class);
    }

    /**
     * Get the default position for the task.
     *
     * @return int
     */
    public function getDefaultPosition()
    {
        // Calculate the default position based on the highest existing position in the same list
        return Task::where('list_id', $this->list_id)->max('position') + 1;
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
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
