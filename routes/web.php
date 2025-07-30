<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\banner;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/menus', [MenuController::class, 'show'])->name('menu.show');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // User Management
    Route::resource('user', UserController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('menuss', MenuController::class)->names([
    'index' => 'menu.index',
    'create' => 'menu.create',
    'store' => 'menu.store',
    'edit' => 'menu.edit',
    'update' => 'menu.update',
    'destroy' => "menu.destroy"])->except('show');
    Route::resource('banner', BannerController::class)->except('show');
});

require __DIR__.'/auth.php';
