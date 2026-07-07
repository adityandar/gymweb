@extends('layouts.admin')
@section('title', 'Reports - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-6">Reports</h1>

<div class="grid grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Revenue by Month</h2>
        <div class="space-y-2">
            @forelse ($revenueByMonth as $r)
            <div class="flex justify-between text-sm border-b pb-1">
                <span>{{ $r->month }}</span>
                <span class="font-medium">Rp {{ number_format($r->total, 0, ',', '.') }}</span>
            </div>
            @empty
            <p class="text-gray-500 text-sm">No revenue data yet.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Member Registrations</h2>
        <div class="space-y-2">
            @forelse ($membersByMonth as $m)
            <div class="flex justify-between text-sm border-b pb-1">
                <span>{{ $m->month }}</span>
                <span class="font-medium">{{ $m->total }} new</span>
            </div>
            @empty
            <p class="text-gray-500 text-sm">No data yet.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 col-span-2">
        <h2 class="text-lg font-semibold mb-4">Attendance by Month</h2>
        <div class="grid grid-cols-4 gap-2">
            @forelse ($attendanceByMonth as $a)
            <div class="text-center p-3 bg-gray-50 rounded">
                <p class="text-xs text-gray-500">{{ $a->month }}</p>
                <p class="text-xl font-bold">{{ $a->total }}</p>
            </div>
            @empty
            <p class="text-gray-500 text-sm col-span-4">No attendance data yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
