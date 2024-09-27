<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\UrlApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// User Registration Route
Route::post('register', [AuthApiController::class, 'register']);

// User Login Route
Route::post('login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    //Logout route
    Route::post('logout', [AuthApiController::class, 'logout']);
    // User Controller
    Route::apiResource('user', UserApiController::class);
    // URL Controller
    Route::apiResource('url', UrlApiController::class);
    Route::get('s/{shortUrl}', [UrlApiController::class, 'redirectToMainUrl']);
});
