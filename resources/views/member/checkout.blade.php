@extends('layouts.member')
@section('title', 'Payment - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-6">Complete Payment</h1>

<div class="bg-white rounded-lg shadow p-6 max-w-lg mx-auto">
    <div class="mb-6 pb-6 border-b">
        <h2 class="text-lg font-semibold mb-2">{{ $order->plan->name }} Plan</h2>
        <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($order->amount, 0, ',', '.') }}</p>
        <p class="text-sm text-gray-500 mt-1">{{ $order->plan->duration_months }} month(s) access</p>
    </div>

    <button id="pay-button" class="w-full bg-blue-600 text-white py-3 rounded-lg text-lg hover:bg-blue-700">
        Pay Now
    </button>

    <p class="text-center text-sm text-gray-500 mt-4">
        Order expires in 24 hours if not paid.
    </p>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                window.location.href = '{{ route('checkout.success') }}';
            },
            onPending: function (result) {
                window.location.href = '{{ route('dashboard') }}';
            },
            onError: function (result) {
                window.location.href = '{{ route('checkout.failed') }}';
            },
            onClose: function () {
                window.location.href = '{{ route('dashboard') }}';
            }
        });
    });
</script>
@endsection
