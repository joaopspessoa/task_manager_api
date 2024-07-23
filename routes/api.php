<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(TaskController::class)->group(function () {
        Route::get('tasks', 'get');
        Route::get('tasks/{id}', 'show');
        Route::post('tasks', 'store');
        Route::put('tasks/{id}', 'update');
        Route::delete('tasks/{id}', 'delete');
    });

    Route::post('logout', [AuthController::class, 'logout']);
});
