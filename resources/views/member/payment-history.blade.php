@extends('layouts.member')
@section('title', 'Payment History - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-6">Payment History</h1>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Plan</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Amount</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Status</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Date</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm font-medium">{{ $order->plan->name }}</td>
                <td class="px-6 py-4 text-sm">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full
                        {{ $order->status === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $order->status === 'failed' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No payment history.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
