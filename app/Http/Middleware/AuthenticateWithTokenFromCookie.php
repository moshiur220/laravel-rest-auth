<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticateWithTokenFromCookie
{
    public function handle(Request $request, Closure $next)
    {
        // Retrieve the token from the cookie
        $token = $request->cookie('access_token');

        if (!$token) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Parse the token
        $token = urldecode($token);
        $tokenParts = explode('|', $token);

        if (count($tokenParts) !== 2) {
            return response()->json(['message' => 'Invalid token format'], 401);
        }

        [$id, $tokenValue] = $tokenParts;

        // Retrieve the token model from the database
        $tokenModel = PersonalAccessToken::find($id);

        if (!$tokenModel || !hash_equals($tokenModel->token, hash('sha256', $tokenValue))) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        // Authenticate the user
        $user = $tokenModel->tokenable;

        Auth::login($user);

        return $next($request);
    }
}
