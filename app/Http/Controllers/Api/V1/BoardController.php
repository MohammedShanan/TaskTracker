<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;

/**
 * handles Boards related operations
 */
class BoardController extends Controller
{
    /**
     * Display a listing of all boards.
     *
     * This method retrieves all the boards from the database and returns them
     * as a JSON response.
     * 
     * @return \Illuminate\Http\JsonResponse A JSON response containing all boards.
     */
    public function index()
    {
        $boards = Board::all();
        return response()->json($boards);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}
    /**
     * Display a board
     * 
     * This method retrieves a board form the database and return it as a json response
     * @param mixed $boardId
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show($boardId)
    {
        $board = Board::findOrFail($boardId);
        if (!$board) {
            return response()->json([]);
        }
        return response()->json($board);
    }

    /**
     * Update the specified board by ID.
     *
     * @param \Illuminate\Http\Request $request The incoming request.
     * @param int $id The ID of the board to update.
     * 
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the success or failure of the update.
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            // Find the board by ID or fail if not found
            $board = Board::findOrFail($id);

            // Update the board's name
            $board->update([
                'name' => $request->name,
            ]);

            // Return success response with updated board ID
            return response()->json(['id' => $board->id], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle board not found
            return response()->json(['error' => 'Board not found'], 404);
        } catch (\Exception $e) {
            // Log and return general error
            Log::error('Error updating board: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to update board'], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        //
    }
}
