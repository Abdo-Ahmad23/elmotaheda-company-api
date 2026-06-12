<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // $token = $user->createToken('admin_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => "admin is created successfully",
            // 'access_token' => $token,
            // 'token_type' => 'Bearer',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($validatedData)) {
            return response()->json([
                'status' => false,
                'message' => 'Data of login is not true !!'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        
        $token = $user->createToken('admin_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'loggined successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'logged out',
        ], 200);
    }
}