<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    \App\Models\Membership::where('status', 'active')
        ->whereDate('end_date', '<', now()->toDateString())
        ->update(['status' => 'expired']);
})->daily()->name('memberships:expire');

Schedule::call(function () {
    \App\Models\Order::where('status', 'pending')
        ->where('created_at', '<', now()->subDay())
        ->update(['status' => 'expired']);
})->daily()->name('orders:expire');
