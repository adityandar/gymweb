<?php

namespace App\Services;

use App\Models\Membership;
use App\Models\Order;

class MembershipService
{
    public function activate(Order $order): Membership
    {
        // Deactivate any existing active membership
        Membership::where('user_id', $order->user_id)
            ->where('status', 'active')
            ->update(['status' => 'cancelled']);

        $plan = $order->plan;
        $startDate = now();
        $endDate = now()->addMonths($plan->duration_months);

        return Membership::create([
            'user_id' => $order->user_id,
            'plan_id' => $plan->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
        ]);
    }

    public function checkExpired(): void
    {
        Membership::where('status', 'active')
            ->where('end_date', '<', now())
            ->update(['status' => 'expired']);
    }
}
