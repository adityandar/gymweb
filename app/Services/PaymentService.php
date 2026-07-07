<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\SystemSetting;
use DB;
use Illuminate\Support\Facades\Log;
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

    public function createTransaction(Order $order): ?string
    {
        if (SystemSetting::isManual()) {
            return null;
        }

        $midtransOrderId = 'ORDER-' . $order->id . '-' . time();

        $payload = [
            'transaction_details' => [
                'order_id' => $midtransOrderId,
                'gross_amount' => (int) $order->amount,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone ?? '',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($payload);
        } catch (\Exception $e) {
            Log::error('Midtrans create transaction failed: ' . $e->getMessage(), ['order_id' => $order->id]);
            return null;
        }

        $order->update([
            'midtrans_snap_token' => $snapToken,
            'midtrans_order_id' => $midtransOrderId,
        ]);

        return $snapToken;
    }

    public function handleWebhook(array $payload): void
    {
        if (SystemSetting::isManual()) {
            return;
        }

        $orderId = $payload['order_id'] ?? null;
        if (! $orderId) {
            Log::warning('Midtrans webhook missing order_id', $payload);
            return;
        }

        if (! $this->verifySignature($payload)) {
            Log::warning('Midtrans webhook signature verification failed', ['order_id' => $orderId]);
            return;
        }

        $order = Order::where('midtrans_order_id', $orderId)->first();
        if (! $order) {
            Log::warning('Midtrans webhook: order not found', ['midtrans_order_id' => $orderId]);
            return;
        }

        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus = $payload['fraud_status'] ?? 'accept';

        $payment = Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'amount' => (int) ($payload['gross_amount'] ?? $order->amount),
                'midtrans_transaction_id' => $payload['transaction_id'] ?? null,
                'midtrans_transaction_status' => $transactionStatus,
                'payment_type' => $payload['payment_type'] ?? null,
                'raw_response' => $payload,
            ]
        );

        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            if ($transactionStatus === 'capture' && $fraudStatus !== 'accept') {
                $this->failOrder($order, $payment, $transactionStatus);
                return;
            }

            DB::transaction(function () use ($order, $payment) {
                $order->update(['status' => 'paid']);
                $payment->update(['paid_at' => now()]);
                app(MembershipService::class)->activate($order);
            });
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $this->failOrder($order, $payment, $transactionStatus);
        } elseif ($transactionStatus === 'pending') {
            $order->update(['status' => 'pending']);
            $payment->update(['midtrans_transaction_status' => $transactionStatus]);
        }
    }

    private function failOrder(Order $order, Payment $payment, string $status): void
    {
        $order->update(['status' => 'failed']);
        $payment->update([
            'midtrans_transaction_status' => $status,
            'paid_at' => null,
        ]);
    }

    private function verifySignature(array $payload): bool
    {
        $serverKey = config('midtrans.server_key');
        if (empty($serverKey)) {
            return false;
        }

        $signatureKey = $payload['signature_key'] ?? '';

        $orderId = $payload['order_id'] ?? '';
        $statusCode = $payload['status_code'] ?? '';
        $grossAmount = $payload['gross_amount'] ?? '';

        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        return hash_equals($expectedSignature, $signatureKey);
    }
}
