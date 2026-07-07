<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function landing(): View
    {
        return view('landing');
    }

    public function pricing(): View
    {
        $plans = MembershipPlan::where('is_active', true)->get();
        return view('pricing', compact('plans'));
    }
}
