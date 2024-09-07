<?php
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TaskTrackerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('boards.index');
});
// creating user account
Route::get("/register", [RegisterController::class, 'register']);
Route::post("/register", [RegisterController::class, 'createUser']);

// user login and authentications
Route::get("/login", [LoginController::class, 'login'])->name(name: 'login');
Route::post("/login", [LoginController::class, 'authenticate']);

// boards CRUD
Route::get('/dashboard',[TaskTrackerController::class, 'index'])->name('boards.index');
Route::post('/boards/store', [TaskTrackerController::class, 'store'])->name('boards.store');
Route::get('boards/{board}', [TaskTrackerController::class, 'show'])->name('boards.show');
Route::delete('boards/{board}', [TaskTrackerController::class, 'delete'])->name('boards.delete');