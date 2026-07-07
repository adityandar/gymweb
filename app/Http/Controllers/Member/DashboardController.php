<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $membership = $user->activeMembership();
        $totalAttendances = $user->attendances()->count();
        $pendingOrders = $user->orders()->where('status', 'pending')->count();

        return view('member.dashboard', compact('membership', 'totalAttendances', 'pendingOrders'));
    }
}
