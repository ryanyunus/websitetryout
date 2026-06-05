<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TryoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('tryout.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tryout Routes
    Route::get('/tryout', [TryoutController::class, 'index'])->name('tryout.index');
    Route::get('/tryout/{tryout}', [TryoutController::class, 'show'])->name('tryout.show');
    Route::get('/tryout/{tryout}/checkout', [TryoutController::class, 'checkout'])->name('tryout.checkout');
    Route::post('/tryout/payment/{transaction}', [TryoutController::class, 'processPayment'])->name('tryout.payment');
    Route::post('/tryout/{tryout}/start', [TryoutController::class, 'start'])->name('tryout.start');
    Route::get('/tryout/{tryout}/exam/{attempt}', [TryoutController::class, 'exam'])->name('tryout.exam');
    Route::post('/tryout/{tryout}/submit/{attempt}', [TryoutController::class, 'submit'])->name('tryout.submit');
    Route::get('/tryout/{tryout}/result/{attempt}', [TryoutController::class, 'result'])->name('tryout.result');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/transactions', [\App\Http\Controllers\AdminController::class, 'transactions'])->name('transactions');
    Route::get('/tryouts', [\App\Http\Controllers\AdminController::class, 'tryouts'])->name('tryouts');
    Route::post('/tryouts/{tryout}/toggle', [\App\Http\Controllers\AdminController::class, 'toggleTryout'])->name('tryouts.toggle');
    Route::post('/tryouts/{tryout}/price', [\App\Http\Controllers\AdminController::class, 'updatePrice'])->name('tryouts.price');
});

// Midtrans Webhook
Route::post('/api/midtrans-callback', [TryoutController::class, 'notification'])->name('midtrans.notification');

require __DIR__.'/auth.php';
