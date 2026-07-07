@extends('layouts.member')
@section('title', 'Classes - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-6">Upcoming Classes</h1>

<div class="grid gap-6">
    @forelse ($classes as $class)
    <div class="bg-white rounded-lg shadow p-6 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-semibold">{{ $class->name }}</h3>
            <p class="text-sm text-gray-500">Trainer: {{ $class->trainer?->name ?? 'N/A' }}</p>
            <p class="text-sm text-gray-500">{{ $class->schedule->format('d M Y, H:i') }}</p>
            <p class="text-sm text-gray-400">{{ $class->bookedCount() }}/{{ $class->capacity }} booked</p>
        </div>
        <div>
            @php $myBooking = $class->bookings->firstWhere('user_id', auth()->id()); @endphp
            @if ($myBooking && $myBooking->status === 'booked')
                <form action="{{ route('bookings.cancel', $myBooking) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="bg-red-100 text-red-700 px-4 py-2 rounded hover:bg-red-200">Cancel</button>
                </form>
            @else
                <form action="{{ route('bookings.store', $class) }}" method="POST">
                    @csrf
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                            {{ $class->bookedCount() >= $class->capacity ? 'disabled' : '' }}>
                        {{ $class->bookedCount() >= $class->capacity ? 'Full' : 'Book' }}
                    </button>
                </form>
            @endif
        </div>
    </div>
    @empty
    <p class="text-gray-500">No upcoming classes.</p>
    @endforelse
</div>
@endsection
