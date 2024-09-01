<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
class TaskTrackerController extends Controller
{
    public function index(){
        $token = request()->cookie('auth_token');
        $secretKey = env('JWT_SECRET');
        $algorithm = 'HS256'; 
        $decoded = JWT::decode($token, new key($secretKey, $algorithm));
        // Extract user ID from the payload
        $userId = $decoded->user_id;
        $boards = [
        "Board1",
        "Board2",
        "Board3",
        "Board4",
        "Board5",
        "Board6",
        "Board7",
        "Board8",
        "Board9",
        "Board10",
        "Board11",
        "Board12",
        "Board12",
        "Board12",
        "Board12",
        "Board12",
        "Board12",
        "Board12",
        "Board12",
        "Board12",
        ];
        return view('dashboard', ['token' => $token, 'boards'=>$boards]);
    }

    public function show(){
        $token = request()->cookie('auth_token');
        return view('board');
    }

    public function store(){
        $token = request()->cookie('auth_token');
        return to_route('boards.show', 1);
    }
}
