<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(): View
    {
        $attendances = auth()->user()->attendances()->latest('check_in_time')->limit(30)->get();

        return view('member.attendance', compact('attendances'));
    }

    public function qr(AttendanceService $attendanceService): View
    {
        $token = $attendanceService->generateQrToken(auth()->user());

        return view('member.qr', compact('token'));
    }

    public function scan(Request $request, AttendanceService $attendanceService): \Illuminate\Http\RedirectResponse
    {
        $token = $request->input('token');
        $attendance = $attendanceService->validateAndRecord($token);

        if (! $attendance) {
            return back()->with('error', 'QR invalid atau expired.');
        }

        return back()->with('success', 'Check-in berhasil dicatat.');
    }
}
