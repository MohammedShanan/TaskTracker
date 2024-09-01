<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(){
        return view('/register');
    }

    public function createUser(){
        request()->validate([
            "user_name" => ['required', 'max:45', 'unique:users,name'],
            'email' => ['required', 'max:45'],
            'password' => ['required', 'max:45', 'confirmed'],
            'password_confirmation' => ['required', 'max:45'],
        ],
        [
            'user_name.unique' => 'This username is already taken. Please choose another one.',
        ]);
        User::create([
            'name' => request()->user_name,
            'email' => request()->email,
            'password' => request()->password,
        ]);
        return to_route('login');
    }
}
