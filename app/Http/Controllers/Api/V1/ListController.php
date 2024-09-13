<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\TasksList;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lists = TasksList::all();
        return response()->json($lists);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $boardId)
    {
        try {
            Log::info('User has logged in.', [$request->all()]);
            $list = TasksList::create([
                'name' => $request->name,
                'board_id'   => $boardId
            ]);
            return response()->json(["id" => $list->id], 200);
        } catch (\Exception $e) {
            Log::error('Error updating list: ' . $e->getMessage());
            return response()->json("not ok", 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TasksList $tasksList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TasksList $list, $id)
    {
        try {
            $list = TasksList::find($id);
            $list->update(
                [
                    'name' => request()->name,
                ]
            );
            return response()->json(['id' => $list->id], 200);
        } catch (\Exception $e) {
            Log::error('Error updating list: ' . $e->getMessage());
            return response()->json("not ok", 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $list = TasksList::find($id);
            $list->delete();
            return response()->json("deleted List", 200);
        } catch (\Exception $e) {
            Log::error('Error updating list: ' . $e->getMessage());
            return response()->json("not ok", 200);
        }
    }
}
