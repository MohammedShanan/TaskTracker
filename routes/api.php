<?php

use App\Http\Controllers\Api\V1\BoardController;
use App\Http\Controllers\Api\V1\ListController;
use App\Http\Controllers\Api\V1\TaskController;
use Illuminate\Support\Facades\Route;

/**
 * API routes for version 1 of the application.
 * 
 * @prefix api/v1
 * @namespace App\Http\Controllers\Api\V1
 */
Route::group(['prefix' => 'api/v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
    /**
     * Resource routes for managing boards.
     * 
     * This defines routes for CRUD operations on boards:
     * - GET /api/v1/boards - index
     * - POST /api/v1/boards - store
     * - GET /api/v1/boards/{board} - show
     * - PUT/PATCH /api/v1/boards/{board} - update
     * - DELETE /api/v1/boards/{board} - destroy
     */
    Route::apiResource('boards', BoardController::class)->names([
        'index' => 'api.boards.index',
        'store' => 'api.boards.store',
        'show' => 'api.boards.show',
        'update' => 'api.boards.update',
        'destroy' => 'api.boards.destroy',
    ]);

    /**
     * Resource routes for managing lists.
     * 
     * This defines routes for CRUD operations on lists:
     * - GET /api/v1/lists - index
     * - POST /api/v1/lists - store
     * - GET /api/v1/lists/{list} - show
     * - PUT/PATCH /api/v1/lists/{list} - update
     * - DELETE /api/v1/lists/{list} - destroy
     */
    Route::apiResource('lists', ListController::class)->names([
        'index' => 'api.lists.index',
        'store' => 'api.lists.store',
        'show' => 'api.lists.show',
        'update' => 'api.lists.update',
        'destroy' => 'api.lists.destroy',
    ]);

    /**
     * Resource routes for managing tasks.
     * 
     * This defines routes for CRUD operations on tasks:
     * - GET /api/v1/tasks - index
     * - POST /api/v1/tasks - store
     * - GET /api/v1/tasks/{task} - show
     * - PUT/PATCH /api/v1/tasks/{task} - update
     * - DELETE /api/v1/tasks/{task} - destroy
     */

    Route::apiResource('tasks', TaskController::class)->names([
        'index' => 'api.tasks.index',
        'store' => 'api.tasks.store',
        'show' => 'api.tasks.show',
        'update' => 'api.tasks.update',
        'destroy' => 'api.tasks.destroy',
    ]);
    
    /**
     * Custom routes for creating lists and tasks within a board or list.
     * 
     * - POST /api/v1/boards/{board}/lists - Create a list within a board.
     * - POST /api/v1/lists/{list}/tasks - Create a task within a list.
     */
    Route::post('boards/{board}/lists', [ListController::class, 'store']);
    Route::post('lists/{list}/tasks', [TaskController::class, 'store']);
});
