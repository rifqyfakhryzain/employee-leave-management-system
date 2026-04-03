<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'message' => 'Email atau password salah'
        ], 401);
    }

    $user = Auth::user();

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login berhasil',
        'user' => $user,
        'token' => $token
    ]);
}
public function register(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6'
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    return response()->json([
        'message' => 'Register berhasil',
        'user' => $user
    ]);
}
}
