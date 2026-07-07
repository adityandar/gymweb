@extends('layouts.member')
@section('title', 'Payment Failed - GymFlow')

@section('content')
<div class="max-w-md mx-auto text-center py-12">
    <div class="text-5xl mb-4">&#x274C;</div>
    <h1 class="text-2xl font-bold text-red-600 mb-2">Payment Failed</h1>
    <p class="text-gray-500 mb-6">Something went wrong. Please try again.</p>
    <a href="{{ route('pricing') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Try Again</a>
</div>
@endsection
