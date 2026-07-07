@extends('layouts.member')
@section('title', 'Workout - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-6">My Workout Plans</h1>

@forelse ($plans as $plan)
<div class="bg-white rounded-lg shadow p-6 mb-4">
    <h2 class="text-lg font-semibold mb-2">{{ $plan->title }}</h2>
    <p class="text-sm text-gray-500 mb-4">Trainer: {{ $plan->trainer->name }}</p>
    @if ($plan->exerciseLogs->count())
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left text-gray-500">
                <th class="pb-2">Exercise</th><th class="pb-2">Sets</th><th class="pb-2">Reps</th><th class="pb-2">Weight</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($plan->exerciseLogs as $log)
            <tr class="border-t">
                <td class="py-2">{{ $log->exercise_name }}</td>
                <td class="py-2">{{ $log->sets }}</td>
                <td class="py-2">{{ $log->reps }}</td>
                <td class="py-2">{{ $log->weight ? $log->weight . ' kg' : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="text-gray-400 text-sm">No exercises assigned yet.</p>
    @endif
</div>
@empty
<p class="text-gray-500">No workout plans assigned yet.</p>
@endforelse
@endsection
