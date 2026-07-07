<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\GymClass;
use Illuminate\View\View;

class ClassController extends Controller
{
    public function index(): View
    {
        $classes = GymClass::with('trainer', 'bookings')
            ->where('schedule', '>=', now())
            ->latest('schedule')
            ->get();

        return view('member.classes', compact('classes'));
    }
}
