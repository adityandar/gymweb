<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function store(Request $request, MembershipPlan $plan): RedirectResponse
    {
        if (! $plan->is_active) {
            return redirect()->route('pricing')->with('error', 'Plan tidak tersedia.');
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'plan_id' => $plan->id,
            'amount' => $plan->price,
            'status' => 'pending',
        ]);

        return redirect()->route('checkout.pay', $order);
    }

    public function pay(Order $order, PaymentService $paymentService): View
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->route('dashboard')->with('error', 'Order sudah diproses.');
        }

        $snapToken = $order->midtrans_snap_token ?? $paymentService->createTransaction($order);

        return view('member.checkout', compact('order', 'snapToken'));
    }

    public function success(): View
    {
        return view('member.checkout-success');
    }

    public function failed(): View
    {
        return view('member.checkout-failed');
    }
}
