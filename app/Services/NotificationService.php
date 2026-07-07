<?php

namespace App\Services;

use App\Mail\MembershipExpiring;
use App\Models\Membership;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public function sendExpiringReminders(): void
    {
        $expiring = Membership::where('status', 'active')
            ->whereDate('end_date', now()->addDays(3))
            ->with('user', 'plan')
            ->get();

        foreach ($expiring as $membership) {
            Mail::to($membership->user->email)->queue(new MembershipExpiring($membership));
        }
    }
}
