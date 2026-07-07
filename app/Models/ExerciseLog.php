<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExerciseLog extends Model
{
    protected $fillable = ['plan_id', 'exercise_name', 'sets', 'reps', 'weight', 'notes'];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(WorkoutPlan::class, 'plan_id');
    }
}
