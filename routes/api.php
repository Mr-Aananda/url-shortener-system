<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\UrlApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Route;


// User Registration Route
Route::post('register', [AuthApiController::class, 'register']);

// User Login Route
Route::post('login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    //Logout route
    Route::post('logout', [AuthApiController::class, 'logout']);
    // User Controller
    Route::apiResource('users', UserApiController::class);
     // URL Controller
    Route::apiResource('urls', UrlApiController::class);
    Route::get('api/{shortUrl}', [UrlApiController::class, 'redirectToMainUrl']);
});

