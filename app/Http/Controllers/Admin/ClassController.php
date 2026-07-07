<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GymClass;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClassController extends Controller
{
    public function index(): View
    {
        $classes = GymClass::with('trainer')->latest('schedule')->get();
        return view('admin.classes.index', compact('classes'));
    }

    public function create(): View
    {
        $trainers = User::role('trainer')->get();
        return view('admin.classes.create', compact('trainers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'trainer_id' => 'nullable|exists:users,id',
            'schedule' => 'required|date',
            'capacity' => 'required|integer|min:1',
        ]);

        GymClass::create($validated);

        return redirect()->route('admin.classes.index')->with('success', 'Class created.');
    }

    public function edit(GymClass $class): View
    {
        $trainers = User::role('trainer')->get();
        return view('admin.classes.edit', compact('class', 'trainers'));
    }

    public function update(Request $request, GymClass $class): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'trainer_id' => 'nullable|exists:users,id',
            'schedule' => 'required|date',
            'capacity' => 'required|integer|min:1',
        ]);

        $class->update($validated);

        return redirect()->route('admin.classes.index')->with('success', 'Class updated.');
    }

    public function destroy(GymClass $class): RedirectResponse
    {
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Class deleted.');
    }
}
