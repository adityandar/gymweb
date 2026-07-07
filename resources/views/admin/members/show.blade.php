@extends('layouts.admin')
@section('title', 'Member Detail - GymFlow')

@section('content')
<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.members.index') }}" class="text-blue-600 hover:underline text-sm">&larr; Back to Members</a>
    <h1 class="text-2xl font-bold">{{ $member->name }}</h1>
</div>

<div class="grid grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Profile</h2>
        <dl class="space-y-2 text-sm">
            <div class="flex justify-between"><dt class="text-gray-500">Email</dt><dd>{{ $member->email }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Phone</dt><dd>{{ $member->phone ?? '-' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Registered</dt><dd>{{ $member->created_at->format('d M Y') }}</dd></div>
        </dl>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Membership</h2>
        @if ($member->activeMembership)
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-gray-500">Plan</dt><dd>{{ $member->activeMembership->plan->name }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Start</dt><dd>{{ $member->activeMembership->start_date->format('d M Y') }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">End</dt><dd>{{ $member->activeMembership->end_date->format('d M Y') }}</dd></div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Status</dt>
                    <dd><span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span></dd>
                </div>
            </dl>
        @else
            <p class="text-gray-500 text-sm">No active membership.</p>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Attendance</h2>
        <p class="text-sm text-gray-500">Total check-ins: {{ $member->attendances->count() }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Workout Plans</h2>
        <p class="text-sm text-gray-500">{{ $member->workoutPlans->count() }} plans assigned</p>
    </div>
</div>
@endsection
