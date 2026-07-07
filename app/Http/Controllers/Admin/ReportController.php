<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Payment;
use App\Models\User;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $revenueByMonth = Payment::whereNotNull('paid_at')
            ->selectRaw("to_char(paid_at, 'YYYY-MM') as month, sum(amount) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $membersByMonth = User::role('member')
            ->selectRaw("to_char(created_at, 'YYYY-MM') as month, count(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $attendanceByMonth = Attendance::selectRaw("to_char(date, 'YYYY-MM') as month, count(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.reports.index', compact('revenueByMonth', 'membersByMonth', 'attendanceByMonth'));
    }
}
