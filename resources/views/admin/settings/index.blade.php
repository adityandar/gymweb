@extends('layouts.admin')
@section('title', 'Settings - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-6">System Settings</h1>

<div class="bg-white rounded-lg shadow p-6 max-w-lg">
    <h2 class="text-lg font-semibold mb-4">Payment Mode</h2>
    <form action="{{ route('admin.settings.payment-mode') }}" method="POST">
        @csrf @method('PUT')
        <div class="space-y-3 mb-6">
            <label class="flex items-center gap-3 p-3 border rounded cursor-pointer hover:bg-gray-50 {{ $paymentMode === 'automatic' ? 'border-blue-500 bg-blue-50' : '' }}">
                <input type="radio" name="payment_mode" value="automatic" {{ $paymentMode === 'automatic' ? 'checked' : '' }} class="text-blue-600">
                <div>
                    <p class="font-medium">Automatic</p>
                    <p class="text-sm text-gray-500">Payment via Midtrans. Membership activated automatically after successful payment.</p>
                </div>
            </label>
            <label class="flex items-center gap-3 p-3 border rounded cursor-pointer hover:bg-gray-50 {{ $paymentMode === 'manual' ? 'border-blue-500 bg-blue-50' : '' }}">
                <input type="radio" name="payment_mode" value="manual" {{ $paymentMode === 'manual' ? 'checked' : '' }} class="text-blue-600">
                <div>
                    <p class="font-medium">Manual Verification</p>
                    <p class="text-sm text-gray-500">Member uploads payment proof. Admin approves manually.</p>
                </div>
            </label>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
    </form>
</div>
@endsection
