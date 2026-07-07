<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function scanPage(): View
    {
        return view('admin.attendance.scan');
    }

    public function scan(Request $request, AttendanceService $attendanceService): \Illuminate\Http\RedirectResponse
    {
        $token = $request->input('token');
        $attendance = $attendanceService->validateAndRecord($token);

        if (! $attendance) {
            return back()->with('error', 'QR invalid, expired, atau member tidak memiliki membership aktif.');
        }

        return back()->with('success', 'Check-in berhasil untuk ' . $attendance->user->name);
    }
}
