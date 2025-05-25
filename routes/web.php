<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ABCController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('ABC', ABCController::class);
     Route::resource('contact', ContactController::class);
});

require __DIR__.'/auth.php';
