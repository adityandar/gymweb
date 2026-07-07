<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\GymClass;
use App\Services\AttendanceService;
use Illuminate\Http\RedirectResponse;

class BookingController extends Controller
{
    public function store(GymClass $class, AttendanceService $attendanceService): RedirectResponse
    {
        if (! $attendanceService->hasActiveMembership(auth()->user())) {
            return back()->with('error', 'Hanya member dengan membership aktif yang bisa book kelas.');
        }

        if ($class->bookedCount() >= $class->capacity) {
            return back()->with('error', 'Class is full.');
        }

        $exists = Booking::where('class_id', $class->id)
            ->where('user_id', auth()->id())
            ->where('status', 'booked')
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already booked this class.');
        }

        Booking::create([
            'class_id' => $class->id,
            'user_id' => auth()->id(),
            'status' => 'booked',
        ]);

        return back()->with('success', 'Class booked successfully.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled.');
    }
}
