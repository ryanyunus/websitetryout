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
    Route::post('/tryout/{tryout}/start', [TryoutController::class, 'start'])->name('tryout.start');
    Route::get('/tryout/{tryout}/exam/{attempt}', [TryoutController::class, 'exam'])->name('tryout.exam');
    Route::post('/tryout/{tryout}/submit/{attempt}', [TryoutController::class, 'submit'])->name('tryout.submit');
    Route::get('/tryout/{tryout}/result/{attempt}', [TryoutController::class, 'result'])->name('tryout.result');
});

require __DIR__.'/auth.php';
