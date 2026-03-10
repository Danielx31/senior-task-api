<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index']);

    Route::middleware('throttle:60,1')->group(function () {
        Route::post('/tasks', [TaskController::class, 'store']);
    });

    Route::patch('/tasks/{task}/completed', [TaskController::class, 'completed']);
});
