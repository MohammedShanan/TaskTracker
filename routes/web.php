<?php

use App\Http\Controllers\TaskTrackerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});




Route::middleware('auth')->group(function () {
    Route::get('/boards', [TaskTrackerController::class, 'index'])->name('boards.index');
    Route::get('boards/{board}', [TaskTrackerController::class, 'show'])->name('boards.show');
    Route::post('/boards/store', [TaskTrackerController::class, 'store'])->name('boards.store');
    Route::delete('boards/{board}', [TaskTrackerController::class, 'destroy'])->name('boards.destroy');
});

require __DIR__ . '/auth.php';
