<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use \Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function authenticate()
    {
        request()->validate([
            'name' => ['required', 'max:45'],
            'password' => ['required', 'max:45'],
        ]);
        $user_name  = request()->name;
        $password = request()->password;
        $user = User::where('name', $user_name)->first();
        if ($user && Hash::check($password, $user->password)) {
            $secretKey = env('JWT_SECRET');
            $token = JWT::encode(['user_id' => $user->id], $secretKey, 'HS256');
            $authToken = cookie('auth_token', $token, 43200);
            $recentlyViewed = cookie('recently_viewed', json_encode([]), 43200);
            return redirect()->intended('boards.index')->withCookies([$authToken, $recentlyViewed]);
        } else {
            return redirect()->back()->withErrors(['error' => 'Wrong username or password']);
        }
    }

    public function logout(Request $request)
    {
        // Log the user out (invalidate their session)
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page or wherever you want
        return redirect('/login');
    }
}
