@extends('layouts.member')
@section('title', 'Dashboard - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-2">Welcome, {{ auth()->user()->name }}!</h1>
<p class="text-gray-500 mb-8">Here is your gym overview.</p>

<div class="grid grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-500 text-sm">Membership Status</p>
        <p class="text-2xl font-bold {{ $membership ? 'text-green-600' : 'text-red-600' }}">
            {{ $membership ? 'Active' : 'Inactive' }}
        </p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-500 text-sm">Total Check-ins</p>
        <p class="text-2xl font-bold text-gray-900">{{ $totalAttendances }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-500 text-sm">Pending Payments</p>
        <p class="text-2xl font-bold text-gray-900">{{ $pendingOrders }}</p>
    </div>
</div>

@if ($membership)
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold mb-4">Your Membership</h2>
    <div class="grid grid-cols-3 gap-4 text-sm">
        <div>
            <p class="text-gray-500">Plan</p>
            <p class="font-medium">{{ $membership->plan->name }}</p>
        </div>
        <div>
            <p class="text-gray-500">Valid Until</p>
            <p class="font-medium">{{ $membership->end_date->format('d M Y') }}</p>
        </div>
        <div>
            <p class="text-gray-500">Days Remaining</p>
            <p class="font-medium">{{ now()->diffInDays($membership->end_date, false) }} days</p>
        </div>
    </div>
</div>
@else
<div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
    <p class="text-yellow-800">You don't have an active membership.</p>
    <a href="{{ route('pricing') }}" class="inline-block mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Get Membership</a>
</div>
@endif
@endsection
