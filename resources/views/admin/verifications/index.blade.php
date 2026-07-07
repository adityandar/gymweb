@extends('layouts.admin')
@section('title', 'Payment Verification - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-6">Payment Verification</h1>

@forelse ($orders as $order)
<div class="bg-white rounded-lg shadow p-6 mb-4">
    <div class="flex justify-between items-start">
        <div>
            <h3 class="font-semibold">{{ $order->user->name }}</h3>
            <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
            <p class="text-sm text-gray-500">Plan: {{ $order->plan->name }} — Rp {{ number_format($order->amount, 0, ',', '.') }}</p>
            <p class="text-sm text-gray-500">Status:
                <span class="{{ $order->status === 'waiting_confirmation' ? 'text-yellow-600' : 'text-red-600' }} font-medium">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
            </p>
            @if ($order->proof)
            <p class="text-sm text-gray-500 mt-1">{{ $order->proof->notes ?? '' }}</p>
            <a href="{{ asset('storage/' . $order->proof->file_path) }}" target="_blank" class="text-blue-600 hover:underline text-sm">View Payment Proof</a>
            @endif
        </div>
        @if ($order->status === 'waiting_confirmation')
        <div class="flex gap-2">
            <form action="{{ route('admin.verifications.approve', $order) }}" method="POST">
                @csrf
                <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">Approve</button>
            </form>
            <form action="{{ route('admin.verifications.reject', $order) }}" method="POST" onsubmit="return confirm('Reject payment?')">
                @csrf
                <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm">Reject</button>
            </form>
        </div>
        @endif
    </div>
</div>
@empty
<p class="text-gray-500">No payments waiting for verification.</p>
@endforelse
@endsection
