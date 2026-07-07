@extends('layouts.trainer')
@section('title', 'Trainer Dashboard - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-4">Trainer Dashboard</h1>
<p class="text-gray-500">Welcome, {{ auth()->user()->name }}. Trainer features coming in Phase 3.</p>
@endsection
