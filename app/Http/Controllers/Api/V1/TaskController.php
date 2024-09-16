<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TasksList;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of all tasks.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response with all tasks.
     */
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    /**
     * Store a newly created task in the specified list.
     *
     * @param \Illuminate\Http\Request $request The incoming request with the task details.
     * @param int $listId The ID of the list to which the task belongs.
     * @return \Illuminate\Http\JsonResponse A JSON response with the created task ID or an error message.
     */
    public function store(Request $request, $listId)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            $task = Task::create([
                'name' => $request->name,
                'list_id'   => $listId,
            ]);
            return response()->json(["id" => $task->id], 200);
        } catch (\Exception $e) {
            Log::error('Error creating task: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to create task'], 500);
        }
    }

    /**
     * Display the specified task.
     *
     * @param int $taskId The ID of the task to display.
     * @return \Illuminate\Http\JsonResponse A JSON response with the task details or an error message.
     */
    public function show(Request $request, $taskId)
    {
        try {
            $task = Task::findOrFail($taskId);
            return response()->json($task, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Task not found: ' . $e->getMessage());
            return response()->json(['error' => 'Task not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error fetching task: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch task'], 500);
        }
    }

    /**
     * Update the specified task.
     *
     * @param \Illuminate\Http\Request $request The incoming request with the updated task details.
     * @param int $taskId The ID of the task to update.
     * @return \Illuminate\Http\JsonResponse A JSON response with the updated task ID or an error message.
     */
    public function update(Request $request, $taskId)
    {
        // Validate the request data
        $request->validate([
            'name'        => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'completed'   => 'sometimes|boolean',
            'position'    => 'sometimes|integer',
            'due_date'    => 'sometimes|nullable|date',
            'priority'    => 'sometimes|string',
            'list_id'     => 'sometimes|integer|exists:lists,id',
        ]);

        try {
            $task = Task::findOrFail($taskId);
            // Update only the provided fields
            $task->update($request->only([
                'name',
                'description',
                'completed',
                'position',
                'due_date',
                'priority',
                'list_id',
            ]));

            return response()->json(['id' => $task->id], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Task not found: ' . $e->getMessage());
            return response()->json(['error' => 'Task not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error updating task: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to update task'], 500);
        }
    }

    /**
     * Remove the specified task from storage.
     *
     * @param int $taskId The ID of the task to delete.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure.
     */
    public function destroy(Request $request, $taskId)
    {
        try {
            // Find the task by ID
            $task = Task::findOrFail($taskId);

            // Delete the task
            $task->delete();

            return response()->json(['message' => 'Task deleted successfully'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Task not found: ' . $e->getMessage());
            return response()->json(['error' => 'Task not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting task: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to delete task'], 500);
        }
    }
}
