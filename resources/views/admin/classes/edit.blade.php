@extends('layouts.admin')
@section('title', 'Edit Class - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Class</h1>

<div class="bg-white rounded-lg shadow p-6 max-w-lg">
    <form action="{{ route('admin.classes.update', $class) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name', $class->name) }}" required class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Trainer</label>
            <select name="trainer_id" class="w-full border rounded px-3 py-2">
                <option value="">Select trainer</option>
                @foreach ($trainers as $trainer)
                    <option value="{{ $trainer->id }}" {{ $class->trainer_id == $trainer->id ? 'selected' : '' }}>{{ $trainer->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Schedule</label>
            <input type="datetime-local" name="schedule" value="{{ old('schedule', $class->schedule->format('Y-m-d\TH:i')) }}" required class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Capacity</label>
            <input type="number" name="capacity" value="{{ old('capacity', $class->capacity) }}" required min="1" class="w-full border rounded px-3 py-2">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
        <a href="{{ route('admin.classes.index') }}" class="ml-2 px-4 py-2 border rounded">Cancel</a>
    </form>
</div>
@endsection
