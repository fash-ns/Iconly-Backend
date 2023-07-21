<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\IconController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/auth')->group(function(){
    Route::post('/check-existence', [AuthController::class, 'checkUserExistence']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/current-user', [AuthController::class, 'getCurrentUser']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
});

Route::middleware('auth')->prefix('/icons')->group(function() {
    Route::get('/list', [IconController::class, 'index']);
    Route::get('/list/selected', [IconController::class, 'indexSelected']);
    Route::get('/download', [IconController::class, 'download']);
});
