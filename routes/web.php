<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Member\AttendanceController;
use App\Http\Controllers\Member\BookingController;
use App\Http\Controllers\Member\CheckoutController;
use App\Http\Controllers\Member\ClassController as MemberClassController;
use App\Http\Controllers\Member\DashboardController as MemberDashboard;
use App\Http\Controllers\Member\PaymentController as MemberPayment;
use App\Http\Controllers\Member\WorkoutController as MemberWorkoutController;
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

    Route::get('/workout', [MemberWorkoutController::class, 'index'])->name('workout.index');
    Route::get('/classes', [MemberClassController::class, 'index'])->name('classes.index');
    Route::post('/classes/{class}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.cancel');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('plans', App\Http\Controllers\Admin\PlanController::class)->except(['show']);
    Route::get('/members', [App\Http\Controllers\Admin\MemberController::class, 'index'])->name('members.index');
    Route::get('/members/{member}', [App\Http\Controllers\Admin\MemberController::class, 'show'])->name('members.show');
    Route::get('/payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
    Route::get('/attendance/scan', [App\Http\Controllers\Admin\AttendanceController::class, 'scanPage'])->name('attendance.scan');
    Route::post('/attendance/scan', [App\Http\Controllers\Admin\AttendanceController::class, 'scan'])->name('attendance.scan.store');
    Route::resource('classes', App\Http\Controllers\Admin\ClassController::class);
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
});

Route::middleware(['auth', 'role:trainer'])->prefix('trainer')->name('trainer.')->group(function () {
    Route::get('/dashboard', function () { return view('trainer.dashboard'); })->name('dashboard');
    Route::resource('workout-plans', App\Http\Controllers\Trainer\WorkoutPlanController::class);
    Route::post('/workout-plans/{plan}/logs', [App\Http\Controllers\Trainer\ExerciseLogController::class, 'store'])->name('exercise-logs.store');
    Route::delete('/workout-plans/{plan}/logs/{log}', [App\Http\Controllers\Trainer\ExerciseLogController::class, 'destroy'])->name('exercise-logs.destroy');
    Route::get('/classes', [App\Http\Controllers\Trainer\ClassController::class, 'index'])->name('classes.index');
});

require __DIR__.'/auth.php';
