<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::role('member')->with('roles');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'ilike', "%{$request->search}%")
                  ->orWhere('email', 'ilike', "%{$request->search}%");
            });
        }

        $members = $query->latest()->paginate(15);

        return view('admin.members.index', compact('members'));
    }

    public function show(User $member): View
    {
        $member->load('memberships.plan', 'attendances', 'workoutPlans');
        $activeMembership = $member->activeMembership();

        return view('admin.members.show', compact('member', 'activeMembership'));
    }
}
