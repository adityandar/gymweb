@extends('layouts.admin')
@section('title', 'Admin Dashboard - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard</h1>

<div class="grid grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-500 text-sm">Total Members</p>
        <p class="text-3xl font-bold text-gray-900">{{ $totalMembers }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-500 text-sm">Active Plans</p>
        <p class="text-3xl font-bold text-gray-900">{{ $activePlans }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-500 text-sm">Trainers</p>
        <p class="text-3xl font-bold text-gray-900">{{ $totalTrainers }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-500 text-sm">Revenue</p>
        <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold mb-2">Quick Links</h2>
    <div class="flex gap-4">
        <a href="{{ route('admin.plans.index') }}" class="text-blue-600 hover:underline">Manage Plans</a>
        <a href="{{ route('admin.members.index') }}" class="text-blue-600 hover:underline">View Members</a>
    </div>
</div>
@endsection
