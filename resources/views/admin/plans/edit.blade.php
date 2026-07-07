@extends('layouts.admin')
@section('title', 'Edit Plan - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Membership Plan</h1>

<div class="bg-white rounded-lg shadow p-6 max-w-lg">
    <form action="{{ route('admin.plans.update', $plan) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name', $plan->name) }}" required
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Duration (months)</label>
            <input type="number" name="duration_months" value="{{ old('duration_months', $plan->duration_months) }}" required min="1"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            @error('duration_months')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Price (Rp)</label>
            <input type="number" name="price" value="{{ old('price', $plan->price) }}" required min="0"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            @error('price')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="3"
                      class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $plan->description) }}</textarea>
        </div>
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ $plan->is_active ? 'checked' : '' }} class="rounded border-gray-300">
                <span class="ml-2 text-sm text-gray-700">Active</span>
            </label>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
            <a href="{{ route('admin.plans.index') }}" class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-50">Cancel</a>
        </div>
    </form>
</div>
@endsection
