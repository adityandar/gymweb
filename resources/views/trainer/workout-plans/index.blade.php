@extends('layouts.trainer')
@section('title', 'Workout Plans - GymFlow')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Workout Plans</h1>
    <a href="{{ route('trainer.workout-plans.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Create Plan</a>
</div>

<div class="space-y-4">
    @forelse ($plans as $plan)
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-lg font-semibold">{{ $plan->title }}</h3>
                <p class="text-sm text-gray-500">Member: {{ $plan->member->name }}</p>
                <p class="text-sm text-gray-400">{{ $plan->exerciseLogs->count() }} exercises</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('trainer.workout-plans.show', $plan) }}" class="text-indigo-600 hover:underline text-sm">View</a>
                <a href="{{ route('trainer.workout-plans.edit', $plan) }}" class="text-indigo-600 hover:underline text-sm">Edit</a>
                <form action="{{ route('trainer.workout-plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('Delete?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600 hover:underline text-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <p class="text-gray-500">No workout plans yet.</p>
    @endforelse
</div>
@endsection
