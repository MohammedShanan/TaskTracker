<?php

use App\Http\Controllers\Api\V1\BoardController;
use App\Http\Controllers\Api\V1\ListController;
use App\Http\Controllers\Api\V1\TaskController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'api/v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
    Route::apiResource('boards', BoardController::class)->names([
        'index' => 'api.boards.index',
        'store' => 'api.boards.store',
        'show' => 'api.boards.show',
        'update' => 'api.boards.update',
        'destroy' => 'api.boards.destroy',
    ]);
    Route::apiResource('lists', ListController::class)->names([
        'index' => 'api.lists.index',
        'store' => 'api.lists.store',
        'show' => 'api.lists.show',
        'update' => 'api.lists.update',
        'destroy' => 'api.lists.destroy',
    ]);
    Route::apiResource('tasks', TaskController::class)->names([
        'index' => 'api.tasks.index',
        'store' => 'api.tasks.store',
        'show' => 'api.tasks.show',
        'update' => 'api.tasks.update',
        'destroy' => 'api.tasks.destroy',
    ]);
    Route::post('boards/{board}/lists', [ListController::class, 'store']);
    Route::post('lists/{list}/tasks', [TaskController::class, 'store']);
});
