<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $listId)
    {
        try {
            Log::info('User has logged in.', [$request->all()]);
            $task = Task::create([
                'name' => $request->name,
                'list_id'   => $listId
            ]);
            return response()->json(["id" => $task->id], 200);
        } catch (\Exception $e) {
            Log::error('Error updating list: ' . $e->getMessage());
            return response()->json("not ok", 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
