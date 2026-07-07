<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\ExerciseLog;
use App\Models\User;
use App\Models\WorkoutPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkoutPlanController extends Controller
{
    public function index(): View
    {
        $plans = WorkoutPlan::with('member', 'trainer')
            ->where('trainer_id', auth()->id())
            ->latest()
            ->get();

        return view('trainer.workout-plans.index', compact('plans'));
    }

    public function create(): View
    {
        $members = User::role('member')->get();
        return view('trainer.workout-plans.create', compact('members'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
        ]);

        WorkoutPlan::create([
            'trainer_id' => auth()->id(),
            ...$validated,
        ]);

        return redirect()->route('trainer.workout-plans.index')->with('success', 'Workout plan created.');
    }

    public function show(WorkoutPlan $workoutPlan): View
    {
        $workoutPlan->load('exerciseLogs', 'member', 'trainer');
        return view('trainer.workout-plans.show', compact('workoutPlan'));
    }

    public function edit(WorkoutPlan $workoutPlan): View
    {
        $members = User::role('member')->get();
        return view('trainer.workout-plans.edit', compact('workoutPlan', 'members'));
    }

    public function update(Request $request, WorkoutPlan $workoutPlan): RedirectResponse
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
        ]);

        $workoutPlan->update($validated);

        return redirect()->route('trainer.workout-plans.index')->with('success', 'Workout plan updated.');
    }

    public function destroy(WorkoutPlan $workoutPlan): RedirectResponse
    {
        $workoutPlan->delete();

        return redirect()->route('trainer.workout-plans.index')->with('success', 'Workout plan deleted.');
    }
}
