@extends('layouts.trainer')
@section('title', $workoutPlan->title . ' - GymFlow')

@section('content')
<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('trainer.workout-plans.index') }}" class="text-indigo-600 hover:underline">&larr; Back</a>
    <h1 class="text-2xl font-bold">{{ $workoutPlan->title }}</h1>
</div>
<p class="text-gray-500 mb-6">Member: {{ $workoutPlan->member->name }}</p>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold mb-4">Add Exercise</h2>
    <form action="{{ route('trainer.exercise-logs.store', $workoutPlan) }}" method="POST" class="grid grid-cols-5 gap-3">
        @csrf
        <input type="text" name="exercise_name" placeholder="Exercise name" required class="border rounded px-3 py-2 col-span-2">
        <input type="number" name="sets" placeholder="Sets" required min="1" class="border rounded px-3 py-2">
        <input type="number" name="reps" placeholder="Reps" required min="1" class="border rounded px-3 py-2">
        <button type="submit" class="bg-indigo-600 text-white rounded px-3 py-2 hover:bg-indigo-700">Add</button>
        <input type="number" name="weight" placeholder="Weight (kg)" step="0.5" class="border rounded px-3 py-2">
        <input type="text" name="notes" placeholder="Notes" class="border rounded px-3 py-2 col-span-3">
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Exercise</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Sets</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Reps</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Weight</th>
                <th class="text-right px-6 py-3 text-sm font-medium text-gray-500">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($workoutPlan->exerciseLogs as $log)
            <tr>
                <td class="px-6 py-4 text-sm">{{ $log->exercise_name }}</td>
                <td class="px-6 py-4 text-sm">{{ $log->sets }}</td>
                <td class="px-6 py-4 text-sm">{{ $log->reps }}</td>
                <td class="px-6 py-4 text-sm">{{ $log->weight ? $log->weight . ' kg' : '-' }}</td>
                <td class="px-6 py-4 text-right">
                    <form action="{{ route('trainer.exercise-logs.destroy', [$workoutPlan, $log]) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline text-sm">Remove</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No exercises added.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
