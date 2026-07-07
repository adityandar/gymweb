<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\MembershipService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentVerificationController extends Controller
{
    public function index(): View
    {
        $orders = Order::whereIn('status', ['waiting_confirmation', 'rejected'])
            ->with('user', 'plan', 'proof')
            ->latest()
            ->get();

        return view('admin.verifications.index', compact('orders'));
    }

    public function approve(Order $order, MembershipService $membershipService): RedirectResponse
    {
        if ($order->status !== 'waiting_confirmation') {
            return back()->with('error', 'Order tidak dapat diapprove.');
        }

        $order->update(['status' => 'paid']);

        if ($order->proof) {
            $order->proof->update([
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);
        }

        $membershipService->activate($order);

        return back()->with('success', 'Pembayaran disetujui. Membership diaktifkan.');
    }

    public function reject(Request $request, Order $order): RedirectResponse
    {
        if ($order->status !== 'waiting_confirmation') {
            return back()->with('error', 'Order tidak dapat direject.');
        }

        $order->update(['status' => 'rejected']);

        return back()->with('success', 'Pembayaran ditolak. Member dapat upload ulang.');
    }
}
