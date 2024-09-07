<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\TasksList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class TaskTrackerController extends Controller
{
    public function index()
    {
        $token = request()->cookie('auth_token');
        $userId = decodeToken($token);
        $recentlyViewed =
            json_decode(request()->cookie('recently_viewed', '[]'), true);
        if ($userId) {
            $user = User::findOrFail($userId);
            return view('dashboard', ['boards' => $user->boards, 'recently_viewed' => $recentlyViewed]);
        } else {
            return view('login');
        }
    }
    public function show(Board $board)
    {
        $recentlyViewed = json_decode(request()->cookie('recently_viewed', '[]'), true);
        if (count($recentlyViewed) == 4) {
            array_pop($recentlyViewed);
        }
        array_unshift($recentlyViewed, [$board->id, $board->name]);
        Cookie::queue(Cookie::make('recently_viewed', json_encode($recentlyViewed), 43200));
        return view('board', ['board' => $board]);
    }

    public function store()
    {
        $token = request()->cookie('auth_token');
        request()->validate([
            'name' => 'string|max:255',
        ]);
        $userId = decodeToken($token);
        if ($userId) {
            $board = Board::create([
                'name' => request()->board_name,
                'user_id' => $userId
            ]);
            return to_route('boards.show', $board->id);
        } else {
            return view('login');
        }
    }
    public function delete(Board $board)
    {
        $recentlyViewed = json_decode(request()->cookie('recently_viewed', '[]'), true);
        foreach ($recentlyViewed as $index => $recent) {
            if ($recent[0] == $board->id) {
                unset($recentlyViewed[$index]);
                Cookie::queue(Cookie::make('recently_viewed', json_encode($recentlyViewed), 43200));
            }
        }
        $board->delete();
        return to_route('boards.index');
    }
}
