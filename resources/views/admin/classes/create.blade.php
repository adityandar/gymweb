@extends('layouts.admin')
@section('title', 'Create Class - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-6">Create Class</h1>

<div class="bg-white rounded-lg shadow p-6 max-w-lg">
    <form action="{{ route('admin.classes.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Trainer</label>
            <select name="trainer_id" class="w-full border rounded px-3 py-2">
                <option value="">Select trainer</option>
                @foreach ($trainers as $trainer)
                    <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Schedule</label>
            <input type="datetime-local" name="schedule" value="{{ old('schedule') }}" required class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Capacity</label>
            <input type="number" name="capacity" value="{{ old('capacity', 10) }}" required min="1" class="w-full border rounded px-3 py-2">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
        <a href="{{ route('admin.classes.index') }}" class="ml-2 px-4 py-2 border rounded">Cancel</a>
    </form>
</div>
@endsection
