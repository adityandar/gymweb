<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use App\Models\Order;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalMembers = User::role('member')->count();
        $totalTrainers = User::role('trainer')->count();
        $activePlans = MembershipPlan::where('is_active', true)->count();
        $totalRevenue = Order::where('status', 'paid')->sum('amount');
        $paymentMode = SystemSetting::paymentMode();

        return view('admin.dashboard', compact(
            'totalMembers',
            'totalTrainers',
            'activePlans',
            'totalRevenue',
            'paymentMode'
        ));
    }
}
