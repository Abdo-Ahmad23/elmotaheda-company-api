<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::latest()->get();

        return response()->json([
            'status' => true,
            'data'   => $admins
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $admin = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'added successfully',
            'data'    => $admin
        ], 201);
    }

    public function destroy($id)
    {
        $currentAdminId = auth()->id();

        if ($currentAdminId == $id) {
            return response()->json([
                'status'  => false,
                'message' => 'you can not delete your account'
            ], 400);
        }

        $admin = User::find($id);

        if (!$admin) {
            return response()->json([
                'status'  => false,
                'message' => 'this profile is not found'
            ], 404);
        }

        $admin->delete();

        return response()->json([
            'status'  => true,
            'message' => 'deleted successfully'
        ], 200);
    }
}