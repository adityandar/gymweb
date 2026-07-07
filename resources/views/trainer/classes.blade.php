@extends('layouts.trainer')
@section('title', 'My Classes - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-6">My Classes</h1>

@forelse ($classes as $class)
<div class="bg-white rounded-lg shadow p-6 mb-4">
    <h2 class="text-lg font-semibold">{{ $class->name }}</h2>
    <p class="text-sm text-gray-500">{{ $class->schedule->format('d M Y, H:i') }} — {{ $class->bookedCount() }}/{{ $class->capacity }}</p>
    @if ($class->bookings->count())
    <div class="mt-2">
        <p class="text-sm font-medium mb-1">Attendees:</p>
        <ul class="text-sm text-gray-500">
            @foreach ($class->bookings as $booking)
                @if ($booking->status === 'booked')
                    <li>{{ $booking->user->name }}</li>
                @endif
            @endforeach
        </ul>
    </div>
    @endif
</div>
@empty
<p class="text-gray-500">No classes assigned.</p>
@endforelse
@endsection
