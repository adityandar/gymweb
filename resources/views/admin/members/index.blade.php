@extends('layouts.admin')
@section('title', 'Members - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-6">Members</h1>

<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..."
               class="flex-1 border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Search</button>
        @if(request('search'))
            <a href="{{ route('admin.members.index') }}" class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-50">Clear</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Name</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Email</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Member Since</th>
                <th class="text-right px-6 py-3 text-sm font-medium text-gray-500">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($members as $member)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $member->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $member->email }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $member->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4 text-right text-sm">
                    <a href="{{ route('admin.members.show', $member) }}" class="text-blue-600 hover:underline">View</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No members found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $members->links() }}
</div>
@endsection
