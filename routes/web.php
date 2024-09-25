<?php

use App\Http\Controllers\DashboardController; // Import the DashboardController
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    //Profile Controllers
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //User Controller
    Route::resource('user', UserController::class);

    //URL Controller
    Route::resource('url', UrlController::class);
    route::get('/s/{shortUrl}', [UrlController::class, 'redirectToMainUrl'])->name('url.redirect');
});


require __DIR__ . '/auth.php';
