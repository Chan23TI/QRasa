<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ABCController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\banner;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/menus', [MenuController::class, 'show'])->name('menu.show');


// Pesan Routes
Route::post('/pesan', [PesanController::class, 'store'])->name('pesan.store');
Route::get('/pesan/summary/{ids}', [PesanController::class, 'multiSummary'])->name('pesan.multi_summary');
Route::get('/pesan/{pesan}/summary', [PesanController::class, 'show'])->name('pesan.summary');

Route::patch('/pesan/{pesan}/update-status', [PesanController::class, 'updateStatus'])->name('pesan.updateStatus');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // User Management
    Route::resource('user', UserController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('ABC', ABCController::class);
    Route::resource('contact', ContactController::class);

    Route::resource('menu', MenuController::class)->names([
    'index' => 'menu.index',
    'create' => 'menu.create',
    'store' => 'menu.store',
    'edit' => 'menu.edit',
    'update' => 'menu.update',
    'destroy' => "menu.destroy"])->except('show');
    Route::resource('banner', BannerController::class)->except('show');

    // Meja Routes (Admin only)
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::resource('meja', \App\Http\Controllers\MejaController::class);
    });

    Route::get('/pesan', [PesanController::class, 'index'])->name('pesan.index');
});

require __DIR__.'/auth.php';
