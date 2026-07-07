<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\GymClass;
use App\Services\AttendanceService;
use Illuminate\View\View;

class ClassController extends Controller
{
    public function index(AttendanceService $attendanceService): View
    {
        $classes = GymClass::with('trainer', 'bookings')
            ->where('schedule', '>=', now())
            ->latest('schedule')
            ->get();

        $canBook = $attendanceService->hasActiveMembership(auth()->user());

        return view('member.classes', compact('classes', 'canBook'));
    }
}
