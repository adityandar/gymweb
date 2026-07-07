<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Member\DashboardController as MemberDashboard;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'landing'])->name('home');
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');

Route::get('/dashboard', [MemberDashboard::class, 'index'])
    ->middleware(['auth', 'verified', 'role:member'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:member'])->group(function () {
    Route::post('/checkout/{plan}', function () {
        return redirect()->route('dashboard')->with('success', 'Checkout coming in Phase 2.');
    })->name('checkout');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('plans', App\Http\Controllers\Admin\PlanController::class)->except(['show']);
    Route::get('/members', [App\Http\Controllers\Admin\MemberController::class, 'index'])->name('members.index');
    Route::get('/members/{member}', [App\Http\Controllers\Admin\MemberController::class, 'show'])->name('members.show');
});

Route::middleware(['auth', 'role:trainer'])->prefix('trainer')->name('trainer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('trainer.dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';
