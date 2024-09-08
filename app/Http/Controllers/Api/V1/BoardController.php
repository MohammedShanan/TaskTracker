<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Display the specified resource.
     */
    public function show(Board $board)
    {
        return $board;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Log::info('User has logged in.', [$request->all()]);
        try {
            
            $board = Board::find($id);
            $board->update(
                [
                    'name' => $request->name,
                ]
            );
            return response()->json(['id' => $board->id], 200);
        } catch (\Exception $e) {
            Log::error('Error updating board: ' . $e->getMessage());
            return response()->json("not ok", 200);
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
