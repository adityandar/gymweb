@extends('layouts.admin')
@section('title', 'Membership Plans - GymFlow')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Membership Plans</h1>
    <a href="{{ route('admin.plans.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Plan</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Name</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Duration</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Price</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Status</th>
                <th class="text-right px-6 py-3 text-sm font-medium text-gray-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($plans as $plan)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $plan->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $plan->duration_months }} month(s)</td>
                <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($plan->price, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full {{ $plan->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $plan->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right text-sm">
                    <a href="{{ route('admin.plans.edit', $plan) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                    <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('Hapus plan ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No plans yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
