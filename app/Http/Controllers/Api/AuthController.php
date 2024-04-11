<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|numeric|unique:users,phone_number',
            'password' => 'required|min:4|confirmed',
        ]);

        $user = User::create($validate);

        $token = $user->createToken($user->email)->plainTextToken;

        return response([
            'token' => $token
        ], 200);
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'login_identity' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $validate['login_identity'])->orWhere('phone_number', $validate['login_identity'])->first();

        if (!$user || !password_verify($validate['password'], $user->password)) {
            return response([
                'message' => __('Invalid credentials')
            ], 401);
        }

        $token = $user->createToken($validate['login_identity'])->plainTextToken;

        return response([
            'token' => $token
        ], 200);
    }
}
