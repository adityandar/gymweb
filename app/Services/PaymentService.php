<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction(Order $order): string
    {
        $payload = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $order->id . '-' . time(),
                'gross_amount' => (int) $order->amount,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone ?? '',
            ],
        ];

        $snapToken = Snap::getSnapToken($payload);

        $order->update(['midtrans_snap_token' => $snapToken]);

        return $snapToken;
    }

    public function handleWebhook(array $payload): void
    {
        $orderId = $payload['order_id'] ?? '';
        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus = $payload['fraud_status'] ?? 'accept';

        $order = Order::where('midtrans_snap_token', '!=', null)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (! $order) {
            return;
        }

        $payment = Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'amount' => $order->amount,
                'midtrans_transaction_id' => $payload['transaction_id'] ?? null,
                'midtrans_transaction_status' => $transactionStatus,
                'payment_type' => $payload['payment_type'] ?? null,
                'raw_response' => $payload,
            ]
        );

        if ($transactionStatus === 'capture' && $fraudStatus === 'accept') {
            $order->update(['status' => 'paid']);
            $payment->update(['paid_at' => now()]);
            app(MembershipService::class)->activate($order);
        } elseif ($transactionStatus === 'settlement') {
            $order->update(['status' => 'paid']);
            $payment->update(['paid_at' => now()]);
            app(MembershipService::class)->activate($order);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $order->update(['status' => 'failed']);
        } elseif ($transactionStatus === 'pending') {
            $order->update(['status' => 'pending']);
        }
    }
}
