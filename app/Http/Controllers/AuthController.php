<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $sameEmail=User::where('email',$request->email)->first();
        $sameUsername=User::where('username',$request->username)->first();
        if($sameEmail){
            return response()->json(['success' => false, 'message' => 'Email already taken'], 400);
        }
        if($sameUsername){
            return response()->json(['success' => false, 'message' => 'Username already taken'], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);
        /*
        // generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        // return response
        $user->token = $token;
        */

        return response()->json(['success' => true, 'message' => 'User registered successfully', 'data' => $user], 201);
    }
    // login user

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);
        $user = User::where('username', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['success' => true, 'message' => 'User logged in successfully', 'data' => ['token' => $token, 'user' => $user]], 201);
    }
// log out

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        // $request->user()->tokens()->delete();
        return response()->json(['success' => true, 'message' => 'User logged out successfully'], 200);
    }

    // user info

    public function user(Request $request)
    {
        // return $request->user();

       return response()->json(['success' => true, 'message' => 'User logged in successfully', 'data' => $request->user()], 201);
    }
    public function userInfo(Request $request)
    {
        return response()->json(['success' => true, 'message' => 'User info retrieved successfully', 'data' => $request->user()], 200);
    }

}
