@extends('layouts.member')
@section('title', 'Payment - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-6">Complete Payment</h1>

<div class="bg-white rounded-lg shadow p-6 max-w-lg mx-auto">

    @if ($switchToPlan)
    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded">
        <p class="text-sm text-blue-800 mb-2">
            Kamu punya order pending untuk <strong>{{ $order->plan->name }}</strong>.
        </p>
        <p class="text-sm text-blue-800 mb-3">
            Ingin ganti ke <strong>{{ $switchToPlan->name }}</strong> (Rp {{ number_format($switchToPlan->price, 0, ',', '.') }})?
        </p>
        <form action="{{ route('checkout.switch', [$order, $switchToPlan]) }}" method="POST">
            @csrf
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Ya, Ganti Plan</button>
            <a href="{{ route('checkout.pay', $order) }}" class="ml-2 text-sm text-gray-500 hover:underline">Batal</a>
        </form>
    </div>
    @endif

    <div class="mb-6 pb-6 border-b">
        <h2 class="text-lg font-semibold mb-2">{{ $order->plan->name }} Plan
            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $paymentMode === 'automatic' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                {{ ucfirst($paymentMode) }}
            </span>
        </h2>
        <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($order->amount, 0, ',', '.') }}</p>
        <p class="text-sm text-gray-500 mt-1">{{ $order->plan->duration_months }} month(s) access</p>
        <p class="text-xs text-gray-400 mt-1">Order #{{ $order->id }} — {{ ucfirst(str_replace('_', ' ', $order->status)) }}</p>
    </div>

    @if ($paymentMode === 'automatic')
        <button id="pay-button" class="w-full bg-blue-600 text-white py-3 rounded-lg text-lg hover:bg-blue-700">
            Pay Now
        </button>
        <p class="text-center text-sm text-gray-500 mt-4">Order expires in 24 hours if not paid.</p>

        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script>
            document.getElementById('pay-button').addEventListener('click', function () {
                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function () { window.location.href = '{{ route('checkout.success') }}'; },
                    onPending: function () { window.location.href = '{{ route('dashboard') }}'; },
                    onError: function () { window.location.href = '{{ route('checkout.failed') }}'; },
                    onClose: function () { window.location.href = '{{ route('dashboard') }}'; }
                });
            });
        </script>
    @else
        <div class="mb-4 p-4 bg-gray-50 rounded">
            <p class="text-sm font-medium mb-2">Bank Account:</p>
            <p class="text-sm text-gray-600">BCA <span class="font-mono">1234567890</span> a/n GymFlow</p>
        </div>

        @if (in_array($order->status, ['waiting_confirmation', 'rejected']))
            <div class="p-4 rounded mb-4 {{ $order->status === 'waiting_confirmation' ? 'bg-yellow-50 text-yellow-800' : 'bg-red-50 text-red-800' }}">
                {{ $order->status === 'waiting_confirmation' ? 'Waiting for admin verification...' : 'Payment rejected. Please upload a new proof.' }}
            </div>
        @endif

        @if ($order->status !== 'waiting_confirmation' || $order->status === 'rejected')
        <form action="{{ route('checkout.upload-proof', $order) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Proof (JPG, PNG, PDF max 5MB)</label>
                <input type="file" name="file" accept=".jpg,.jpeg,.png,.pdf" required
                       class="w-full border border-gray-300 rounded px-3 py-2">
                @error('file')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes (optional)</label>
                <input type="text" name="notes" maxlength="500" class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg text-lg hover:bg-blue-700">Upload Proof</button>
        </form>
        @endif
    @endif
</div>
@endsection
