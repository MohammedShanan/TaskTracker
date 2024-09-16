<?php

use App\Http\Controllers\TaskTrackerController;
use Illuminate\Support\Facades\Route;

/**
 * Public routes available to all users.
 */
Route::get('/', function () {
    return view('login');
});



/**
 * Routes that require authentication.
 * 
 * These routes are protected by the 'auth' middleware, ensuring that only authenticated users can access them.
 */
Route::middleware('auth')->group(function () {
    /**
     * Routes for managing boards.
     * 
     * - GET /boards - Display a list of all boards.
     * - GET /boards/{board} - Show details of a specific board.
     * - POST /boards/store - Create a new board.
     * - DELETE /boards/{board} - Delete a specific board.
     */
    Route::get('/boards', [TaskTrackerController::class, 'index'])->name('boards.index');
    Route::get('boards/{board}', [TaskTrackerController::class, 'show'])->name('boards.show');
    Route::post('/boards/store', [TaskTrackerController::class, 'store'])->name('boards.store');
    Route::delete('boards/{board}', [TaskTrackerController::class, 'destroy'])->name('boards.destroy');
});

/**
 * Include the authentication routes.
 * 
 * This file typically contains routes related to user registration, login, and password management.
 */
require __DIR__ . '/auth.php';
