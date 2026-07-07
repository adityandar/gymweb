@extends('layouts.member')
@section('title', 'Payment Success - GymFlow')

@section('content')
<div class="max-w-md mx-auto text-center py-12">
    <div class="text-5xl mb-4">&#x2705;</div>
    <h1 class="text-2xl font-bold text-green-600 mb-2">Payment Successful!</h1>
    <p class="text-gray-500 mb-6">Your membership has been activated.</p>
    <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Go to Dashboard</a>
</div>
@endsection
