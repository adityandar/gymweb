<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\AttendanceService;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(): View
    {
        $attendances = auth()->user()->attendances()->latest('check_in_time')->limit(30)->get();
        $hasActiveMembership = auth()->user()->activeMembership() !== null;

        return view('member.attendance', compact('attendances', 'hasActiveMembership'));
    }

    public function qr(AttendanceService $attendanceService): View
    {
        if (! $attendanceService->hasActiveMembership(auth()->user())) {
            return view('member.qr', ['token' => null, 'canCheckIn' => false]);
        }

        $token = $attendanceService->generateQrToken(auth()->user());

        return view('member.qr', ['token' => $token, 'canCheckIn' => true]);
    }
}
