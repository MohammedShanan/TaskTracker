<?php

use App\Http\Controllers\Api\V1\BoardController;
use App\Http\Controllers\Api\V1\ListController;
use App\Http\Controllers\Api\V1\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'api/v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
    Route::apiResource('boards', BoardController::class);
    Route::apiResource('lists', ListController::class);
    Route::apiResource('tasks', ListController::class);
    Route::post('boards/{board}/lists', [ListController::class, 'store']);
    Route::post('lists/{list}/tasks', [TaskController::class, 'store']);
});
