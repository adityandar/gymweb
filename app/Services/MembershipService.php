<?php

namespace App\Services;

use App\Models\Membership;
use App\Models\Order;

class MembershipService
{
    public function activate(Order $order): Membership
    {
        return DB::transaction(function () use ($order) {
            Membership::where('user_id', $order->user_id)
                ->where('status', 'active')
                ->update(['status' => 'cancelled']);

            $plan = $order->plan;

            return Membership::create([
                'user_id' => $order->user_id,
                'plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => now()->addMonths($plan->duration_months),
                'status' => 'active',
            ]);
        });
    }

    public function checkExpired(): void
    {
        Membership::where('status', 'active')
            ->whereDate('end_date', '<', now()->toDateString())
            ->update(['status' => 'expired']);
    }
}
