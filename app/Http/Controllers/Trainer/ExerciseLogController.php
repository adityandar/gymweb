<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\ExerciseLog;
use App\Models\WorkoutPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExerciseLogController extends Controller
{
    public function store(Request $request, WorkoutPlan $plan): RedirectResponse
    {
        $validated = $request->validate([
            'exercise_name' => 'required|string|max:255',
            'sets' => 'required|integer|min:1',
            'reps' => 'required|integer|min:1',
            'weight' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $plan->exerciseLogs()->create($validated);

        return back()->with('success', 'Exercise added.');
    }

    public function destroy(WorkoutPlan $plan, ExerciseLog $log): RedirectResponse
    {
        $log->delete();
        return back()->with('success', 'Exercise removed.');
    }
}
