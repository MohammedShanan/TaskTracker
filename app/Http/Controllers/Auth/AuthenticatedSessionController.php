<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use \Firebase\JWT\JWT;
use Illuminate\Support\Facades\Cookie;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // dd("im here in create login");
        return view('login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        $user_name  = request()->name;
        $user = User::where('name', $user_name)->first();
        $authToken = $user->createToken('auth_token')->plainTextToken;
        $secretKey = env('JWT_SECRET');
        $userIdToken = JWT::encode(['user_id' => $user->id], $secretKey, 'HS256');
        $cookies = [cookie('user_id', $userIdToken, 43200), cookie('auth_token', $authToken, 43200)];
        if (!$request->hasCookie('recently_viewed')) {
            $recentlyViewed = cookie('recently_viewed', json_encode([]), 43200);
            array_unshift($cookies, $recentlyViewed);
        }
        return redirect()->intended(route('boards.index', absolute: false))->withCookies($cookies);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {

        Auth::guard('web')->logout();
        Cookie::queue(Cookie::forget('user_id'));
        Cookie::queue(Cookie::forget('recently_viewed'));
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
