<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use App\Models\Order;
use App\Models\PaymentProof;
use App\Models\SystemSetting;
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

        // All orders start as pending; manual mode moves to waiting_confirmation after proof upload
        $order = Order::create([
            'user_id' => auth()->id(),
            'plan_id' => $plan->id,
            'amount' => $plan->price,
            'status' => 'pending',
            'payment_mode' => SystemSetting::paymentMode(),
        ]);

        return redirect()->route('checkout.pay', $order);
    }

    public function pay(Order $order, PaymentService $paymentService): View
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (! in_array($order->status, ['pending', 'waiting_confirmation', 'rejected'])) {
            return redirect()->route('dashboard')->with('error', 'Order sudah diproses.');
        }

        $paymentMode = SystemSetting::paymentMode();
        $snapToken = null;

        if ($paymentMode === 'automatic' && $order->status === 'pending') {
            $snapToken = $order->midtrans_snap_token ?? $paymentService->createTransaction($order);
        }

        return view('member.checkout', compact('order', 'snapToken', 'paymentMode'));
    }

    public function uploadProof(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'notes' => 'nullable|string|max:500',
        ]);

        // Delete previous proof if rejected
        if ($order->proof) {
            \Storage::disk('public')->delete($order->proof->file_path);
            $order->proof->delete();
        }

        $path = $request->file('file')->store('payment-proofs', 'public');

        PaymentProof::create([
            'order_id' => $order->id,
            'file_path' => $path,
            'notes' => $request->notes,
            'uploaded_at' => now(),
        ]);

        $order->update(['status' => 'waiting_confirmation']);

        return redirect()->route('dashboard')->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
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
