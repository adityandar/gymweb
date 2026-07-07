@extends('layouts.admin')
@section('title', 'Classes - GymFlow')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Classes</h1>
    <a href="{{ route('admin.classes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Class</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Name</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Trainer</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Schedule</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Capacity</th>
                <th class="text-right px-6 py-3 text-sm font-medium text-gray-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($classes as $class)
            <tr>
                <td class="px-6 py-4 text-sm font-medium">{{ $class->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $class->trainer?->name ?? 'N/A' }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $class->schedule->format('d M Y, H:i') }}</td>
                <td class="px-6 py-4 text-sm">{{ $class->capacity }}</td>
                <td class="px-6 py-4 text-right text-sm">
                    <a href="{{ route('admin.classes.edit', $class) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                    <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" class="inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No classes yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
