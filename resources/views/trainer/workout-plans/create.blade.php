@extends('layouts.trainer')
@section('title', 'Create Workout Plan - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-6">Create Workout Plan</h1>

<div class="bg-white rounded-lg shadow p-6 max-w-lg">
    <form action="{{ route('trainer.workout-plans.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Member</label>
            <select name="member_id" required class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">Select member</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>{{ $member->name }} ({{ $member->email }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Save</button>
        <a href="{{ route('trainer.workout-plans.index') }}" class="ml-2 px-4 py-2 border rounded">Cancel</a>
    </form>
</div>
@endsection
