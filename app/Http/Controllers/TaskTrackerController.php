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
        // dd("here in index");
        $token = request()->cookie('user_id');
        $userId = decodeToken($token);
        $recentlyViewed =
            json_decode(request()->cookie('recently_viewed', '[]'), true);
        if ($userId) {
            $user = User::findOrFail($userId);
            return view('index', ['boards' => $user->boards, 'recently_viewed' => $recentlyViewed]);
        } else {
            return view('login');
        }
    }
    public function show(Board $board)
    {
        $token = request()->cookie('user_id');
        $userId = decodeToken($token);
        if ($userId) {
            $recentlyViewed = json_decode(request()->cookie('recently_viewed', '[]'), true);

            if (array_key_exists($board->id, $recentlyViewed)) {
                unset($recentlyViewed[$board->id]);
            } elseif (count($recentlyViewed) == 6) {
                $last = array_key_last($recentlyViewed);
                unset($recentlyViewed[$last]);
            }
            $recentlyViewed = [$board->id => $board->name] + $recentlyViewed;
            Cookie::queue(Cookie::make('recently_viewed', json_encode($recentlyViewed), 43200));
            return view('board', ['board' => $board]);
        }
    }

    public function store()
    {
        $token = request()->cookie('user_id');
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
    public function destroy(Board $board)
    {
        $recentlyViewed = json_decode(request()->cookie('recently_viewed', '[]'), true);
        unset($recentlyViewed[$board->id]);
        Cookie::queue(Cookie::make('recently_viewed', json_encode($recentlyViewed), 43200));
        $board->delete();
        return to_route('boards.index');
    }
}
