@extends('layouts.member')
@section('title', 'Attendance - GymFlow')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Attendance</h1>
    @if ($hasActiveMembership)
        <a href="{{ route('attendance.qr') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Generate QR</a>
    @endif
</div>

@if (! $hasActiveMembership)
<div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
    <p class="text-yellow-800 font-medium">Attendance hanya tersedia untuk member dengan membership aktif.</p>
    <a href="{{ route('pricing') }}" class="inline-block mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Beli Membership</a>
</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Date</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Check-in Time</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($attendances as $a)
            <tr>
                <td class="px-6 py-4 text-sm">{{ $a->date->format('d M Y') }}</td>
                <td class="px-6 py-4 text-sm">{{ $a->check_in_time->format('H:i:s') }}</td>
            </tr>
            @empty
            <tr><td colspan="2" class="px-6 py-4 text-center text-gray-500">No attendance records.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
