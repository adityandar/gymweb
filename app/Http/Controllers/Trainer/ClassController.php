<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\GymClass;
use Illuminate\View\View;

class ClassController extends Controller
{
    public function index(): View
    {
        $classes = GymClass::with('bookings.user')
            ->where('trainer_id', auth()->id())
            ->where('schedule', '>=', now())
            ->latest('schedule')
            ->get();

        return view('trainer.classes', compact('classes'));
    }
}
