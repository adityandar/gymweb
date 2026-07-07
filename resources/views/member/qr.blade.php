@extends('layouts.member')
@section('title', 'Check-in QR - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-4">Check-in QR</h1>
<p class="text-gray-500 mb-6">Show this QR to the gym staff to check in. Expires in 60 seconds.</p>

<div class="bg-white rounded-lg shadow p-6 max-w-sm mx-auto text-center">
    <div class="mb-4">
        {!! QrCode::size(250)->generate($token) !!}
    </div>
    <button onclick="location.reload()" class="text-blue-600 hover:underline text-sm">Regenerate QR</button>
</div>
@endsection
