<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\TasksList;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * Display a listing of all task lists.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response with all task lists.
     */
    public function index()
    {
        $lists = TasksList::all();
        return response()->json($lists);
    }


    /**
     * Store a newly created task list in the specified board.
     *
     * @param \Illuminate\Http\Request $request The incoming request with the list details.
     * @param int $boardId The ID of the board to which the task list belongs.
     * @return \Illuminate\Http\JsonResponse A JSON response with the created list ID or an error message.
     */
    public function store(Request $request, $boardId)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {

            // Create a new task list
            $list = TasksList::create([
                'name'     => $request->name,
                'board_id' => $boardId
            ]);

            return response()->json(['id' => $list->id], 201);
        } catch (\Exception $e) {
            Log::error('Error creating list: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to create list'], 500);
        }
    }

    /**
     * Display the specified task list.
     *
     * @param \App\Models\TasksList $tasksList The task list to display.
     * @return \Illuminate\Http\JsonResponse A JSON response with the task list details.
     */
    public function show(TasksList $tasksList)
    {
        return response()->json($tasksList);
    }
    /**
     * Update the specified task list.
     *
     * @param \Illuminate\Http\Request $request The incoming request with the updated list details.
     * @param int $id The ID of the task list to update.
     * @return \Illuminate\Http\JsonResponse A JSON response with the updated list ID or an error message.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            // Find the task list by ID
            $list = TasksList::findOrFail($id);

            // Update the list
            $list->update([
                'name' => $request->name,
            ]);

            return response()->json(['id' => $list->id], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('List not found: ' . $e->getMessage());
            return response()->json(['error' => 'List not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error updating list: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to update list'], 500);
        }
    }


    /**
     * Remove the specified task list from storage.
     *
     * @param int $id The ID of the task list to delete.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure.
     */
    public function destroy($id)
    {
        try {
            // Find the task list by ID
            $list = TasksList::findOrFail($id);

            // Delete the task list
            $list->delete();

            return response()->json(['message' => 'List deleted successfully'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('List not found: ' . $e->getMessage());
            return response()->json(['error' => 'List not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting list: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to delete list'], 500);
        }
    }
}
