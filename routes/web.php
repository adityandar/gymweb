<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Member\AttendanceController;
use App\Http\Controllers\Member\CheckoutController;
use App\Http\Controllers\Member\DashboardController as MemberDashboard;
use App\Http\Controllers\Member\PaymentController as MemberPayment;
use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'landing'])->name('home');
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');

Route::post('/webhook/midtrans', PaymentWebhookController::class)
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::get('/dashboard', [MemberDashboard::class, 'index'])
    ->middleware(['auth', 'verified', 'role:member'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:member'])->group(function () {
    Route::post('/checkout/{plan}', [CheckoutController::class, 'store'])->name('checkout');
    Route::get('/checkout/{order}/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/failed', [CheckoutController::class, 'failed'])->name('checkout.failed');

    Route::get('/payment-history', [MemberPayment::class, 'history'])->name('payment.history');

    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/qr', [AttendanceController::class, 'qr'])->name('attendance.qr');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('plans', App\Http\Controllers\Admin\PlanController::class)->except(['show']);
    Route::get('/members', [App\Http\Controllers\Admin\MemberController::class, 'index'])->name('members.index');
    Route::get('/members/{member}', [App\Http\Controllers\Admin\MemberController::class, 'show'])->name('members.show');
    Route::get('/payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
    Route::get('/attendance/scan', [App\Http\Controllers\Admin\AttendanceController::class, 'scanPage'])->name('attendance.scan');
    Route::post('/attendance/scan', [App\Http\Controllers\Admin\AttendanceController::class, 'scan'])->name('attendance.scan.store');
});

Route::middleware(['auth', 'role:trainer'])->prefix('trainer')->name('trainer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('trainer.dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';
