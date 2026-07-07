@extends('layouts.admin')
@section('title', 'Payments - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-6">Payment Records</h1>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Transaction ID</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Member</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Plan</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Amount</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Status</th>
                <th class="text-left px-6 py-3 text-sm font-medium text-gray-500">Date</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($payments as $p)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm text-gray-500">{{ $p->midtrans_transaction_id ?? '-' }}</td>
                <td class="px-6 py-4 text-sm">{{ $p->order->user->name }}</td>
                <td class="px-6 py-4 text-sm">{{ $p->order->plan->name }}</td>
                <td class="px-6 py-4 text-sm">Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full
                        {{ $p->midtrans_transaction_status === 'settlement' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $p->midtrans_transaction_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ in_array($p->midtrans_transaction_status, ['cancel', 'deny', 'expire']) ? 'bg-red-100 text-red-700' : '' }}">
                        {{ $p->midtrans_transaction_status ?? 'unknown' }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $p->created_at->format('d M Y H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No payments yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $payments->links() }}</div>
@endsection
