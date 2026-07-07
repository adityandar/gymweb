<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class WorkoutController extends Controller
{
    public function index(): View
    {
        $plans = auth()->user()->workoutPlans()->with('exerciseLogs', 'trainer')->latest()->get();

        return view('member.workout', compact('plans'));
    }
}
